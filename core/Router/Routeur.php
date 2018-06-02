<?php

namespace phpGone\Router;

 /**
  * class Routeur
  *
  * Permet de choisir la bonne route en fonction de la requête
  */
class Routeur
{
    protected $routes = [];
    const NO_ROUTE = 1;

    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    public function getRoute($url)
    {
        foreach ($this->routes as $route) {
            $matches = $route->match($url);

            //Si la route correspond à l'url
            if ($matches !== false) {
                $route->setMatches($matches);
                return $route;
            }
            unset($route);
        }
        throw new \RuntimeException('Aucune route ne correspond à l\'url', self::NO_ROUTE);
    }
}
