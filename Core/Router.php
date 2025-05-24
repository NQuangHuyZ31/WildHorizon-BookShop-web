<?php

namespace Core;

class Router
{
    private $routes = [];

    // Định nghĩa route với tham số
    public function get($path, $action, $middleware = [], $name = null)
    {
        $this->routes[] = [
            'method' => 'GET',
            'path' => $path,
            'action' => $action,
            'middleware' => $middleware,
            'name' => $name
        ];
    }
    // Định nghĩa route cho phương thức POST
    public function post($path, $action, $middleware = [], $name = null)
    {
        $this->routes[] = [
            'method' => 'POST',
            'path' => $path,
            'action' => $action,
            'middleware' => $middleware,
            'name' => $name
        ];
    }

    // Xử lý request
    public function handleRequest()
    {

        $currentPath = strtok($_SERVER['REQUEST_URI'], '?'); // Lấy đường dẫn không chứa query string
        $currentMethod = strtoupper($_SERVER['REQUEST_METHOD']);
        $baseUrl = BASE_URL_NAME; // Đây là thư mục gốc của ứng dụng
        if (strpos($currentPath, $baseUrl) === 0) {
            $currentPath = substr($currentPath, strlen($baseUrl));
        }
        foreach ($this->routes as $route) {
            if ($currentMethod === $route['method']) {
                // Kiểm tra xem đường dẫn có chứa tham số hay không

                $routePattern = preg_replace('/\{(\w+)\}/', '([^/]+)', $route['path']);
                $routePattern = "#^$routePattern$#";
                $routePattern = preg_replace('/\{slug\}/', '([a-zA-Z0-9-]+)', $routePattern); // Thay {slug} thành regex cho slug
                $routePattern = preg_replace('/\{id\}/', '(\d+)', $routePattern);            // Thay {id} thành regex cho ID
                if (preg_match($routePattern, $currentPath, $matches)) {
                    array_shift($matches);

                    $middlewareList = $route['middleware'];
                    $action = $route['action'];

                    $this->runMiddleware($middlewareList, function () use ($action, $matches) {
                        if (is_callable($action)) {
                            call_user_func_array($action, $matches);
                        } elseif (is_array($action)) {
                            $controllerName = $action[0];
                            $methodName = $action[1];

                            if (class_exists($controllerName)) {
                                $controller = new $controllerName();
                                if (method_exists($controller, $methodName)) {
                                    call_user_func_array([$controller, $methodName], $matches);
                                } else {
                                    echo "Method $methodName not found in controller $controllerName";
                                }
                            } else {
                                echo "Controller $controllerName not found.";
                            }
                        }
                    });

                    return;
                }
            }
        }

        // Nếu không tìm thấy route phù hợp
        http_response_code(404);
        // echo '<img src="' . BASE_URL . '/Public/images/unnamed-13.jpg" alt="" style="width:100%;height:100%">';
        header('location:' . BASE_URL . '/');
    }
    // Xử lí middleware
    private function runMiddleware($middlewareList, $next)
    {
        $handler = function ($request) use ($middlewareList, $next) {
            $middleware = current($middlewareList);
            if ($middleware) {
                next($middlewareList);
                $middlewareInstance = new $middleware();
                return $middlewareInstance->handle($request, function ($request) use ($middlewareList, $next) {
                    return $this->runMiddleware($middlewareList, $next);
                });
            } else {
                return $next($request);
            }
        };

        $handler([]);
    }
}
