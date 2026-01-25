<?php

namespace BFrame\Core;

/**
 * MainController - All controllers should extend this class
 */
class MainController
{


    public function view($name, $params)
    {
        if (is_array($params)) {
            extract($params);
        }

        require ABSPATH . '/app/Views/' . $name . '.php';
    }

}