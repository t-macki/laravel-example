<?php

namespace Domain\Entity;


trait EntityTrait
{
    /**
     * __construct()
     *
     * @param array
     */
    public function __construct(array $properties = array())
    {
        $this->initialize($properties);
    }

    /**
     * データを初期化します。
     *
     * @param array
     */
    private function initialize(array $properties = array())
    {
        foreach (array_keys(get_object_vars($this)) as $name) {
            $this->{$name} = null;
            if (array_key_exists($name, $properties)) {
                $value = (is_object($properties[$name])) ? clone $properties[$name] : $properties[$name];
                $this->{$name} = $value;
                unset($properties[$name]);
            }
        }
        if (count($properties) !== 0) {
            throw new \InvalidArgumentException(
                sprintf('Not supported properties [%s]',
                    implode(',', array_keys($properties))
                )
            );
        }
        return $this;
    }

    /**
     * 配列に変換して返します。
     *
     * @return array
     */
    public function toArray()
    {
        $values = array();
        foreach (array_keys(get_object_vars($this)) as $name) {
            $value = $this->{$name};
            $values[$name] = ($value instanceof EntityInterface) ? $value->toArray() : $value;
        }
        return $values;
    }

    /**
     * __isset
     *
     * @param mixed
     * @return bool
     */
    public function __isset($name)
    {
        return property_exists($this, $name);
    }

    /**
     * __get
     *
     * @param mixed
     * @return mixed
     * @throws \LogicException
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        } else {
            throw new \LogicException(
                sprintf('The property "%s" does not exists.', $name)
            );
        }
    }

    /**
     * __set
     *
     * @param mixed
     * @param mixed
     * @throws \LogicException
     */
    final public function __set($name, $value)
    {
        throw new \LogicException(
            sprintf('The property "%s" could not set.', $name)
        );

//        if (property_exists($this, $name)) {
//            $this->$name = $value;
//        } else {
//            throw new LogicException(sprintf('Undefined property: $%s', $name));
//        }
    }

    /**
     * IteratorAggregate::getIterator()
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator(get_object_vars($this));
    }

    public function __toString()
    {
        return __CLASS__ .' : '. json_encode($this->toArray());
    }
}