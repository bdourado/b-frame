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

    /**
     * Return a JSON response
     * @param mixed $data
     * @param int $status
     */
    public function json($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    /**
     * Get JSON body from the request
     * @return mixed
     */
    public function getBody()
    {
        $json = file_get_contents('php://input');
        return json_decode($json, true);
    }

}