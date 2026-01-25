<?php
/**
 * function to automatically load all default classes
 * @param $class_name
 */
spl_autoload_register(function ($class_name) {
    // Check in core classes
    $core_file = ABSPATH . '/core/classes/' . $class_name . '.php';
    if (file_exists($core_file)) {
        require_once $core_file;
        return;
    }

    // Check in app models
    $model_file = ABSPATH . '/app/models/' . $class_name . '.php';
    if (file_exists($model_file)) {
        require_once $model_file;
        return;
    }
});

/**
 * function to check if key exists in array
 * @param $array
 * @param $key
 * @return mixed|null
 */
function check_array($array, $key)
{
    if (isset($array[$key]) && !empty($array[$key])) {
        return $array[$key];
    }
    return null;
}