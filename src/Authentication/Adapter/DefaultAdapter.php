<?php 
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Authentication\Adapter;

use Zend\Authentication\Result,
    Zend\Crypt\Password\Bcrypt,
    Zend\Session\Container,
    CmsCommon\Persistence\MapperProviderInterface,
    CmsCommon\Persistence\MapperProviderTrait,
    CmsCommon\Mapping\Common\PasswordableInterface,
    CmsCommon\Mapping\Common\StateableInterface,
    CmsCommon\Mapping\Dateable\ExpirableInterface,
    CmsAuthentication\Adapter\AbstractAdapter,
    CmsAuthentication\Adapter\AdapterChainEvent,
    CmsUser\Mapping\LoginTrackableInterface,
    CmsUser\Options\AuthenticationOptionsInterface,
    CmsUser\Persistence\UserMapperInterface;

class DefaultAdapter extends AbstractAdapter implements MapperProviderInterface
{
    use MapperProviderTrait;

    /**
     * @var AuthenticationOptionsInterface
     */
    protected $options;

    /**
     * @var callable
     */
    protected $credentialPreprocessor;

    /**
     * __construct
     *
     * @param UserMapperInterface $mapper
     * @param AuthenticationOptionsInterface $options
     */
    public function __construct(UserMapperInterface $mapper, AuthenticationOptionsInterface $options)
    {
        $this->setMapper($mapper);
        $this->options = $options;
    }

    /**
     * {@inheritDoc}
     *
     * @throws Exception\BadMethodCallException
     */
    public function authenticate(AdapterChainEvent $e)
    {
        if ($this->isSatisfied()) {
            $storage = $this->getStorage()->read();
            $e->setIdentity($storage['identity'])
              ->setCode(Result::SUCCESS)
              ->setMessages(['Authentication successful']);

            return;
        }

        $post = $e->getRequest()->getPost();

        $identity = $post->get($e->getIdentityKey());
        $identityObject = $this->getMapper()->findByIdentity($identity);
        if (!$identityObject) {
            $e->setCode(Result::FAILURE_IDENTITY_NOT_FOUND)
              ->setMessages(['A record with the supplied identity could not be found']);
            $this->setSatisfied(false);

            return false;
        }

        if ($identityObject instanceof PasswordableInterface) {
            $credential = $post->get($e->getCredentialKey());
            $credential = $this->preprocessCredential($credential);
            $password   = $identityObject->getPassword();

            if (!$this->getMapper()->getPasswordService()->verify($credential, $password)) {
                // Password does not match
                $e->setCode(Result::FAILURE_CREDENTIAL_INVALID)
                  ->setMessages(['Supplied credential is invalid']);
                $this->setSatisfied(false);

                return false;
            }

            // Update user's password hash if the cost parameter has changed
            $this->updateCredentialHash($identityObject, $credential);
        }

        if ($identityObject instanceof StateableInterface) {
            $allowedStates = $this->options->getAllowedAuthenticationStates();

            // Don't allow user to login if state is not in allowed list
            if ($allowedStates && !in_array($identityObject->getState(), $allowedStates, true)) {
                $e->setCode(Result::FAILURE_UNCATEGORIZED)
                  ->setMessages(['A record with the supplied identity is disabled']);
                $this->setSatisfied(false);

                return false;
            }
        }

        if ($identityObject instanceof ExpirableInterface
            && null !== ($expireAt = $identityObject->getExpireAt())
            && $expireAt < new \DateTime('now')
        ) {
            $e->setCode(Result::FAILURE_UNCATEGORIZED)
              ->setMessages(['Record has expired']);
            $this->setSatisfied(false);

            return false;
        }

        // Regenerate the id
        $session = new Container($this->getStorage()->getNameSpace());
        $session->getManager()->regenerateId();

        // Success!
        $e->setIdentity($identityObject->getId());

        // Remember user if needed
        if ($post->get('rememberme') && ($ttl = $e->getRememberMeTimeout()) > 0) {
            $session->getManager()->rememberMe($ttl);
        }

        if ($identityObject instanceof LoginTrackableInterface) {
            $identityObject->setLoginAt(new \DateTime('now'));
        }

        $this->getMapper()->update($identityObject)->save();

        $this->setSatisfied(true);

        $storage = $this->getStorage()->read();
        $storage['identity'] = $e->getIdentity();
        $this->getStorage()->write($storage);

        $e->setCode(Result::SUCCESS)
          ->setMessages(['Authentication successful']);
    }

    /**
     * Called when user id logged out
     *
     * @param  AdapterChainEvent $e Event passed
     * @return void
     */
    public function logout(AdapterChainEvent $e)
    {
        $session = new Container($this->getStorage()->getNameSpace());
        $session->getManager()->forgetMe();
        $session->getManager()->destroy();
    }

    /**
     * Update identity object password hash if cost has been changed
     *
     * @param PasswordableInterface $identityObject
     * @param string $password
     * @return self
     */
    protected function updateCredentialHash(PasswordableInterface $identityObject, $password)
    {
        $cryptoService = $this->getMapper()->getPasswordService();
        if (!$cryptoService instanceof Bcrypt) {
            return $this;
        }

        $hash = explode('$', $identityObject->getPassword());
        if ($hash[2] === $cryptoService->getCost()) {
            return $this;
        }

        $identityObject->setPassword($cryptoService->create($password));

        return $this;
    }

    /**
     * Preprocess credential
     *
     * @param string $credential
     * @return string
     */
    public function preprocessCredential($credential)
    {
        $processor = $this->getCredentialPreprocessor();
        if (is_callable($processor)) {
            return $processor($credential);
        }

        return $credential;
    }

    /**
     * Get credential preprocessor
     *
     * @return callable
     */
    public function getCredentialPreprocessor()
    {
        return $this->credentialPreprocessor;
    }

    /**
     * Set credential preprocessor
     *
     * @param callable $credentialPreprocessor the value to be set
     * @return self
     */
    public function setCredentialPreprocessor(callable $credentialPreprocessor)
    {
        $this->credentialPreprocessor = $credentialPreprocessor;
        return $this;
    }
}
