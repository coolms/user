<?php 
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Authentication\Storage;

use Zend\Authentication\Storage\Session,
    Zend\Authentication\Storage\StorageInterface,
    CmsCommon\Persistence\MapperInterface,
    CmsCommon\Persistence\MapperProviderInterface,
    CmsCommon\Persistence\MapperProviderTrait;

class DefaultStorage implements StorageInterface, MapperProviderInterface
{
    use MapperProviderTrait;

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var object|null
     */
    protected $resolvedIdentity;

    /**
     * @param MapperInterface $mapper
     * @param StorageInterface $storage
     */
    public function __construct(MapperInterface $mapper, StorageInterface $storage = null)
    {
        $this->setMapper($mapper);
        if (null !== $storage) {
            $this->setStorage($storage);
        }
    }

    /**
     * Returns true if and only if storage is empty
     *
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If it is impossible to determine whether storage is empty
     * @return bool
     */
    public function isEmpty()
    {
        if ($this->getStorage()->isEmpty()) {
            return true;
        }

        if (null === $this->read()) {
            $this->clear();
            return true;
        }

        return false;
    }

    /**
     * Returns the contents of storage
     *
     * Behavior is undefined when storage is empty.
     *
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If reading contents from storage is impossible
     * @return object|null
     */
    public function read()
    {
        if (null !== $this->resolvedIdentity) {
            return $this->resolvedIdentity;
        }

        $identity = $this->getStorage()->read();

        if (is_int($identity) || is_scalar($identity)) {
            $identity = $this->getMapper()->find($identity);
        }

        $this->resolvedIdentity = $identity ?: null;

        return $this->resolvedIdentity;
    }

    /**
     * Writes $contents to storage
     *
     * @param  mixed $contents
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If writing $contents to storage is impossible
     */
    public function write($contents)
    {
        $this->resolvedIdentity = null;
        $this->getStorage()->write($contents);
    }

    /**
     * Clears contents from storage
     *
     * @throws \Zend\Authentication\Exception\InvalidArgumentException If clearing contents from storage is impossible
     */
    public function clear()
    {
        $this->resolvedIdentity = null;
        $this->getStorage()->clear();
    }

    /**
     * Get storage
     *
     * @return StorageInterface
     */
    public function getStorage()
    {
        if (null === $this->storage) {
            $this->setStorage(new Session);
        }

        return $this->storage;
    }

    /**
     * Set storage
     *
     * @param StorageInterface $storage
     * @return self
     */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
        return $this;
    }
}
