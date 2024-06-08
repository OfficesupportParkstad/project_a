<?php

class Router
{
    private $routes = [];

    public function __construct()
    {
        $this->routes = [];
    }

    public function add($urlPattern, $controllerAction)
    {
        $this->routes[$urlPattern] = $controllerAction;
    }

    public function dispatch($url)
    {
        // 1. URL ophalen
        $url = $_SERVER['REQUEST_URI'];

        // 2. URL analyseren
        $components = parse_url($url);

        // 3. Haal de host op
        $host = $components['host'];

        // 4. Haal de path op
        $path = $components['path'];

        // 5. Haal de query op
        $query = $components['query'];

        // 6. Verwijder voorloop- en naslag tekens
        $cleanPath = trim($path, '/');

        // 7. Split het pad in segmenten
        $segments = explode('/', $cleanPath);

        // 8. Loop door de routes
        foreach ($this->routes as $urlPattern => $controllerAction) {
            // Splits de URL en het routepatroon op "/"

            // Vergelijk elk segment van de URL met het corresponderdesegment van de route
            if ($urlPattern == $cleanPath) {
                $controllerName = $controllerAction['controller'];
                $actionName = $controllerAction['action'];

                if (class_exists($controllerName)) {
                    $controller = new $controllerName();

                    if (method_exists($controller, $actionName)) {
                        $controller->$actionName();
                        return;
                    } else {
                        echo "actie $actionName niet gevonden in controller $controllerName";
                    }
                } else {
                    echo "Controller $controllerName niet gevonden";
                    return;
                }
            }
        }

        // Foutafhandeling
        echo "Geen overeenkomstige route gevonden";
    }
}
