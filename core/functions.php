<?php
/**
 * function to automatically load all default classes
 * @param $class_name
 */
spl_autoload_register(function ($class_name) {
    // PSR-4 mapping for BFrame namespace
    $prefix = 'BFrame\\';

    if (strpos($class_name, $prefix) === 0) {
        $relative_class = substr($class_name, strlen($prefix));

        // BFrame\Core\ClassName -> core/Classes/ClassName.php
        if (strpos($relative_class, 'Core\\') === 0) {
            $base_dir = ABSPATH . '/core/Classes/';
            $relative_class = substr($relative_class, strlen('Core\\'));
        }
        // BFrame\App\ClassName -> app/ClassName.php
        elseif (strpos($relative_class, 'App\\') === 0) {
            $base_dir = ABSPATH . '/app/';
            $relative_class = substr($relative_class, strlen('App\\'));
        } else {
            return;
        }

        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // Fallback for non-namespaced classes (legacy support)
    $core_file = ABSPATH . '/core/Classes/' . $class_name . '.php';
    if (file_exists($core_file)) {
        require_once $core_file;
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