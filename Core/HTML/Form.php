<?php

namespace Core\HTML;

class Form
{

    protected $data;
    public $surround = 'p';

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    protected function surround($html)
    {
        return "<{$this->surround}>{$html}</{$this->surround}>";
    }

    /**
     * If the data is an object, return the property, otherwise return the array value
     * 
     * @param index The name of the field to get the value for.
     * 
     * @return The value of the index.
     */
    protected function getValue($index)
    {
        if (is_object($this->data)) {
            return $this->data->$index;
        }
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

    public function input($name, $label, $options = [])
    {
        $type = isset($options['type']) ? $options['type'] : 'text';
        return $this->surround('<input type="' . $type . '" name="' . $name . '" value="' . $this->getValue($name) . '">');
    }

    public function submit()
    {

        return $this->surround('<button type="submit">Envoyer</button>');
    }
}
