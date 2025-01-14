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

    // Định nghĩa route cho phương thức PUT
    public function put($path, $action, $middleware = [], $name = null)
    {
        $this->routes[] = [
            'method' => 'PUT',
            'path' => $path,
            'action' => $action,
            'middleware' => $middleware,
            'name' => $name
        ];
    }

    // Định nghĩa route cho phương thức DELETE
    public function delete($path, $action, $middleware = [], $name = null)
    {
        $this->routes[] = [
            'method' => 'DELETE',
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
            $currentPath = substr($currentPath, strlen($baseUrl)); // Loại bỏ tiền tố /CNMoi
        }
        foreach ($this->routes as $route) {
            if ($currentMethod === $route['method']) {
                // Kiểm tra xem đường dẫn có chứa tham số hay không
                $routePattern = preg_replace('/\{(\w+)\}/', '(\w+)', $route['path']);
                $routePattern = "#^$routePattern$#";

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
        echo "404 - Not Found";
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
