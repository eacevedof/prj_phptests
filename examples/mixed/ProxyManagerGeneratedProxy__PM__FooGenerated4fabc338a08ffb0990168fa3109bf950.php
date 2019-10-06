<?php

namespace ProxyManagerGeneratedProxy\__PM__\Foo;

class Generated4fabc338a08ffb0990168fa3109bf950 extends \Foo implements \ProxyManager\Proxy\VirtualProxyInterface
{

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $valueHolder182f5 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializere2e16 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties0eb88 = [
        
    ];

    private static $signature4fabc338a08ffb0990168fa3109bf950 = 'YTo0OntzOjk6ImNsYXNzTmFtZSI7czozOiJGb28iO3M6NzoiZmFjdG9yeSI7czo1MDoiUHJveHlNYW5hZ2VyXEZhY3RvcnlcTGF6eUxvYWRpbmdWYWx1ZUhvbGRlckZhY3RvcnkiO3M6MTk6InByb3h5TWFuYWdlclZlcnNpb24iO3M6NDY6IjIuMi4zQDRkMTU0NzQyZTMxYzM1MTM3ZDUzNzRjOTk4ZThmODZiNTRkYjJlMmYiO3M6MTI6InByb3h5T3B0aW9ucyI7YTowOnt9fQ==';

    public function doSomething()
    {
        $this->initializere2e16 && $this->initializere2e16->__invoke($this->valueHolder182f5, $this, 'doSomething', array(), $this->initializere2e16);

        return $this->valueHolder182f5->doSomething();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? $reflection = new \ReflectionClass(__CLASS__);
        $instance = $reflection->newInstanceWithoutConstructor();

        $instance->initializere2e16 = $initializer;

        return $instance;
    }

    public function __construct()
    {
        static $reflection;

        if (! $this->valueHolder182f5) {
            $reflection = $reflection ?: new \ReflectionClass('Foo');
            $this->valueHolder182f5 = $reflection->newInstanceWithoutConstructor();
        }
    }

    public function & __get($name)
    {
        $this->initializere2e16 && $this->initializere2e16->__invoke($this->valueHolder182f5, $this, '__get', ['name' => $name], $this->initializere2e16);

        if (isset(self::$publicProperties0eb88[$name])) {
            return $this->valueHolder182f5->$name;
        }

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder182f5;

            $backtrace = debug_backtrace(false);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    get_parent_class($this),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
            return;
        }

        $targetObject = $this->valueHolder182f5;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializere2e16 && $this->initializere2e16->__invoke($this->valueHolder182f5, $this, '__set', array('name' => $name, 'value' => $value), $this->initializere2e16);

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder182f5;

            return $targetObject->$name = $value;
            return;
        }

        $targetObject = $this->valueHolder182f5;
        $accessor = function & () use ($targetObject, $name, $value) {
            return $targetObject->$name = $value;
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializere2e16 && $this->initializere2e16->__invoke($this->valueHolder182f5, $this, '__isset', array('name' => $name), $this->initializere2e16);

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder182f5;

            return isset($targetObject->$name);
            return;
        }

        $targetObject = $this->valueHolder182f5;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializere2e16 && $this->initializere2e16->__invoke($this->valueHolder182f5, $this, '__unset', array('name' => $name), $this->initializere2e16);

        $realInstanceReflection = new \ReflectionClass(get_parent_class($this));

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder182f5;

            unset($targetObject->$name);
            return;
        }

        $targetObject = $this->valueHolder182f5;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __clone()
    {
        $this->initializere2e16 && $this->initializere2e16->__invoke($this->valueHolder182f5, $this, '__clone', array(), $this->initializere2e16);

        $this->valueHolder182f5 = clone $this->valueHolder182f5;
    }

    public function __sleep()
    {
        $this->initializere2e16 && $this->initializere2e16->__invoke($this->valueHolder182f5, $this, '__sleep', array(), $this->initializere2e16);

        return array('valueHolder182f5');
    }

    public function __wakeup()
    {
    }

    public function setProxyInitializer(\Closure $initializer = null)
    {
        $this->initializere2e16 = $initializer;
    }

    public function getProxyInitializer()
    {
        return $this->initializere2e16;
    }

    public function initializeProxy() : bool
    {
        return $this->initializere2e16 && $this->initializere2e16->__invoke($this->valueHolder182f5, $this, 'initializeProxy', array(), $this->initializere2e16);
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder182f5;
    }

    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHolder182f5;
    }


}
