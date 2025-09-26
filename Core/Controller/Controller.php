<?php

namespace Core\Controller;

class Controller
{

    protected $viewPath;
    protected $template;

    /**
     * It takes a view and a variable array, extracts the variables from the array, and then requires the
     * view file. 
     * 
     * The view file is a PHP file that contains HTML and PHP code. 
     * 
     * The view file is then required by the template file. 
     * 
     * The template file is a PHP file that contains HTML and PHP code. 
     * 
     * The template file is then required by the controller. 
     * 
     * The controller is a PHP file that contains HTML and PHP code. 
     * 
     * The controller is then required by the index.php file. 
     * 
     * The index.php file is a PHP file that contains HTML and PHP code. 
     * 
     * The index.php file is then required by the browser. 
     * 
     * The browser is a PHP file that contains HTML and PHP code. 
     * 
     * The browser is then required by the
     * 
     * @param view The name of the view to render.
     * @param var the variables that will be used in the view
     */
    protected function render($view, $var = [])
    {
        ob_start();
        extract($var);
        require $this->viewPath . str_replace('.', '/', $view) . '.php';
        $content = ob_get_clean();
        require($this->viewPath . 'templates/' . $this->template . '.php');
    }

    protected function forbidden()
    {
        header("HTTP/1.0 403 Forbidden");
        die('Acces Interdit');
    }

    protected function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        die('Page introuvable');
    }
}
