<?php

namespace Core\Entity;

class Entity
{

    /**
     * If you try to access a property that doesn't exist, it will look for a method with the same name as
     * the property, but with the first letter capitalized, and call that method
     * 
     * @param key The name of the property you're trying to access.
     * 
     * @return The value of the property.
     */
    public function __get($key)
    {
        $method = 'get' . ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }
}
