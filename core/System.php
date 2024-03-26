<?php
declare(strict_types=1);

/**
 * @param string $url
 * @param array $routes
 */
class System
{
    public function parseUrl(string $url, array $routes) : array{
        $result = [
            'controller' => 'errors\E404',
            'params' => []
        ];

        foreach($routes as $route){
            $matches = [];

            if(preg_match($route['regex'], $url, $matches)){
                $result['controller'] = $route['controller'];

                if(isset($route['params'])){
                    foreach($route['params'] as $name => $num){
                        $result['params'][$name] = $matches[$num];
                    }
                }

                break;
            }
        }

        return $result;
    }
}