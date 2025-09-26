<?php

namespace Core\HTML;

class BootstrapForm extends Form
{

    protected function surround($html)
    {
        return "<div class =\"mb-3\">{$html}</div>";
    }


    /**
     * It creates a label and an input field, and then surrounds them with a div
     * 
     * @param name The name of the input field.
     * @param label The label of the input
     * @param options an array of options for the input
     * 
     * @return The label and the input.
     */
    public function input($name, $label, $required = false, $options = [])
    {
        $type = isset($options['type']) ? $options['type'] : 'text';
        $label = '<label class="form-label">' . $label . '</label>';
        if ($type === 'textarea') {
            $input1 = '<textarea class="form-control" name="' . $name . '"id="' . $name . '"';
            $input2 = '>' . $this->getValue($name) . '</textarea>';
        } else {
            $input1 = '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" value="' . $this->getValue($name) . '" class="form-control" ';
            $input2 = '>';
        }
        if ($required = true) {
            $input = $input1 . " required " . $input2;
        } else {
            $input = $input1 . $input2;
        }

        return $this->surround($label . $input);
    }

    /**
     * It returns a string that contains a label and an input tag. 
     * 
     * The label is the first argument, the input tag is the second argument, and the third argument is an
     * array of options. 
     * 
     * The function uses the `surround()` function to wrap the label and input tag in a `<p>` tag. 
     * 
     * The `surround()` function is defined in the `HTML.php` file. 
     * 
     * The `surround()` function takes a string as an argument and returns a string that contains the
     * argument wrapped in a `<p>` tag. 
     * 
     * The `input()` function uses the `getValue()` function to get the value of the input tag. 
     * 
     * The `getValue()` function is defined in the `Form.php` file. 
     * 
     * The `getValue()`
     * 
     * @param name The name of the input field.
     * @param label The label of the input
     * @param options 
     * 
     * @return The input method is returning the result of the surround method.
     */

    /**
     * It creates a select input with the name, label, options, and javascript (if any) passed to it
     * 
     * @param name The name of the input
     * @param label The label of the input
     * @param options array of options
     * @param js if true, the select will submit the form when changed
     * 
     * @return The label and the input.
     */
    public function select($name, $label, $options, $js = false)
    {
        if ($js) {
            $input = '<select onchange="this.form.submit()" class="form-control" name="' . $name . '">';
        } else {
            $input = '<select class="form-control" name="' . $name . '">';
        }
        $label = '<label class="form-label">' . $label . '</label>';
        foreach ($options as $k => $v) {
            $attributes = '';
            if ($k == $this->getValue($name)) {
                $attributes = ' selected';
            }
            $input .= "<option value='$k'$attributes>$v</option>";
        }
        $input .= '</select>';
        return $this->surround($label . $input);
    }

    /**
     * It takes a string as an argument, and returns a string. 
     * 
     * The string it returns is a button. 
     * 
     * The string it takes as an argument is the text that will appear on the button.
     * 
     * @return A string.
     */
    public function submit()
    {

        return '<button type="submit" class="btn btn-primary">Envoyer</button>';
    }
}
