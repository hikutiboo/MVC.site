<?php

define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
const ROOT_DIRS = ['app', 'view', 'core'];

spl_autoload_register(
/**
 * @throws Exception
 */ function ($path): void {
        foreach (ROOT_DIRS as $dir) {
            $classPath = BASE_PATH . $dir . DIRECTORY_SEPARATOR .
                str_replace('\\', DIRECTORY_SEPARATOR, $path) . '.php';
            if (file_exists($classPath)) {
                include_once($classPath);
                return;
            }
        }

        throw new Exception(\Bootstrap::__("Class not found by this path \"") . $path . "\"");
    }
);