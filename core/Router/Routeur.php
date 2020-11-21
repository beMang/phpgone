<?php

namespace phpGone\Router;

 /**
  * class Routeur
  *
  * Choisi la bonne route en fonction de l'url
  */
class Routeur
{
    protected array$routes = [];
    const NO_ROUTE = 1;

    /**
     * Ajoute une route au routeur
     *
     * @param Route $route Route à ajouter
     * @return void
     */
    public function addRoute(Route $route) :void
    {
        $this->routes[] = $route;
    }

    /**
     * Récupère la bonne route en fonction de l'url
     *
     * @param [type] $url
     * @return void
     */
    public function getRoute($url)
    {
        foreach ($this->routes as $route) {
            if ($route->match($url) === true) {
                return $route;
            }
            unset($route);
        }
        throw new \RuntimeException('Aucune route ne correspond à l\'url', self::NO_ROUTE);
    }
}
