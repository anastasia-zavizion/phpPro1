<?php
namespace Core;
use Core\Traits\HttpMethods;
use App\Enums\Http\Method;
use App\Controllers\Controller;
use App\Enums\Http\Status;

class Router{
    use HttpMethods;

    protected static Router|null $instance = null;

    protected array $routes = [];
    protected array $params = []; //values from routes, like ids
    protected string $currentRoute;

    protected array $convertTypes = [
        'd' => 'int',
        '.' => 'string'
    ];

    //Singleton
    static public function getInstance():static{
        if(is_null(static::$instance)){
            static::$instance = new static;
        }
        return static::$instance;
    }

    static protected function setUri(string $uri):static{
        $uri = preg_replace('/\//', '\\/', $uri);
        $uri = preg_replace('/\{([a-z_-]+):([^}]+)}/', '(?P<$1>$2)', $uri);
        $uri = "/^$uri$/i";

        $router = static::getInstance();
        $router->routes[$uri] = [];
        $router->currentRoute =$uri;

        return $router;
    }
    static public function dispatch(string $uri):string{
        $router = static::getInstance();
        $response = null;
        //remove get params
        $uri = $router->removeGetParams($uri);
        $uri = trim($uri, '/');
        if ($router->match($uri)) {
            $router->checkRequestMethod();
            $controller = $router->getController();
            $action = $router->getAction($controller);
            //$router->params - only ids
            if ($controller->before($action, $router->params)) { //check if all is ok
                $response = call_user_func_array([$controller, $action], $router->params); //try get response
                $controller->after($action, $router->params);
            }
        }
        if($response){
            return jsonResponse($response['code'], [
                'data' => $response['body'],
                'errors' => $response['errors']
            ]);
        }
        return jsonResponse(Status::INTERNAL_SERVER_ERROR->value, [
            'data' =>[],
            'errors' =>'No response'
        ]);
    }

    protected function getController(): Controller
    {
        $controller = $this->params['controller'] ?? null;
        unset($this->params['controller']);
        return new $controller; //create controller object
    }

    protected function getAction(Controller $controller): string
    {
        $action = $this->params['action'] ?? null;
        unset($this->params['action']);
        return $action;
    }

    protected function match(string $uri): bool
    {

        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $uri, $matches)) { //if found router
                $this->params = $this->buildParams($route, $matches, $params); //add cleaned params
                return true;
            }
        }

        throw new \Exception("Route [$uri] not found", 404);
    }

    protected function buildParams(string $route, array $matches, array $params): array
    {
        preg_match_all('/\(\?P<[\w]+>(\\\\)?([\w\.][\+]*)\)/', $route, $types);
        $matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

        if (!empty($types)) {  //types for params
            $lastKey = array_key_last($types);
            $step = 0;
            $types[$lastKey] = array_map(fn($value) => str_replace('+', '', $value), $types[$lastKey]);
            foreach($matches as $name => $value) {
                settype($value, $this->convertTypes[$types[$lastKey][$step]]);
                $params[$name] = $value;
                $step++;
            }
        }
        return $params;
    }

    protected function removeGetParams(string $uri) :string{
        return preg_replace('/([\w\/\-]+)\?([\w\/%*&\?\=]+)/', '$1', $uri);
    }

    protected function setMethod(Method $method) :static{
        $this->routes[$this->currentRoute]['method'] = $method->value;
        return $this;
    }

    protected function setController(string $controller) :static{
        if(class_exists($controller)){
            $this->routes[$this->currentRoute]['controller'] = $controller;
            return $this;
        }else{
            throw new \Exception("Controller [$controller] doesn't exists!");
        }
    }

    protected function setAction(string $action){
        $controller = $this->routes[$this->currentRoute]['controller'] ?? null;
        if (!method_exists($controller, $action)) {
            throw new \Exception("Action [$action] doesn't exists in [".$controller."]!");
        }
        $this->routes[$this->currentRoute]['action'] = $action;
        return $this;
    }

    public function __call(string $name, array $arguments)
    {
        $methodName = 'set'.ucfirst($name);
        if(!method_exists($this,$methodName)){
            throw new \Exception(__CLASS__.", Method $name doesnt exist");
        }
        $refMethod = new \ReflectionMethod($this::class, $methodName);
        if($refMethod->getReturnType() !== 'void'){
            return call_user_func_array([$this,$methodName], $arguments);
        }
        call_user_func_array([$this,$methodName], $arguments);
    }

}