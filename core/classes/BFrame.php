<?php
/**
 * Class BFrame
 * Manage Models, Controllers and Views
 */

class BFrame
{

    /**
     * $controller
     * it will receive the controller value (Coming from the URL)
     */
    private $controller;

    /**
     * $action
     * it will receive the action value (Coming from the URL)
     */
    private $action;

    /**
     * it will receive an array parameter values (Coming from the URL)
     */
    private $params;

    /**
     * $notFound
     * page not found   
     */
    private $notFound = '/app/views/404.php';


    /**
     * BFrame constructor.
     * Gets the values of the controller, action, and parameters. Configures the controlled and action (method).
     */
    public function __construct()
    {
        $this->getUrlData();

        if (!$this->controller) {
            require_once ABSPATH . '/app/controllers/HomeController.php';
            $this->controller = new HomeController();
            $this->controller->index();
            return;
        }

        if (!file_exists(ABSPATH . '/app/controllers/' . $this->controller . '.php')) {
            require_once ABSPATH . $this->notFound;
            return;
        }

        require_once ABSPATH . '/app/controllers/' . $this->controller . '.php';

        $this->controller = preg_replace('/[^a-zA-Z]/i', '', $this->controller);

        if (!class_exists($this->controller)) {
            require_once ABSPATH . $this->notFound;
            return;
        }

        $this->controller = new $this->controller($this->params);

        if (method_exists($this->controller, $this->action)) {
            $this->controller->{$this->action}($this->params);
            return;
        }

        if (!$this->action && method_exists($this->controller, 'index')) {
            $this->controller->index();
            return;
        }

        require_once ABSPATH . $this->notFound;

        return;
    }

    /**
     * Gets parameters from $ _GET ['path']
     * and set the properties $this->controller, $this->action, and $this->params
     */
    public function getUrlData()
    {

        if (isset($_GET['path'])) {
            $path = $_GET['path'];

            $path = rtrim($path, '/');
            $path = filter_var($path, FILTER_SANITIZE_URL);

            $path = explode('/', $path);

            $this->controller = check_array($path, 0);
            $this->controller .= '-controller';
            $this->action = check_array($path, 1);

            if (check_array($path, 2)) {
                unset($path[0]);
                unset($path[1]);
                $this->params = array_values($path);
            }
        }

    }

}