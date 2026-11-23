<?php

class View
{
    /**
     * render a view with data passed
     *
     * @param String $view the view to display
     * @param Array $data data to pass to the view
     * @return void
     */
    
    public static function render($view, $data = [])
    {
        // Importe le contenu de $data comme variables 
        extract($data);

        ob_start();

        require __DIR__ . '/../views/' . $view . '.php';

        $content = ob_get_clean();

        require __DIR__ . '/../views/layout.php';
    }
}