<?php

namespace phpGone\Router;

use bemang\Config;
use phpGone\Router\Route;

 /**
  * class Routeur
  *
  * Choisi la bonne route en fonction de l'url
  */
class Routeur
{
    protected array $routes = [];
    public const NO_ROUTE = 1;

    public function __construct()
    {
        $this->registerControllers();
    }

    /**
     * Récupère la bonne route en fonction de l'url
     *
     * @param [type] $url
     * @return void
     */
    public function getMatchedRoute($url): Route
    {
        foreach ($this->routes as $route) {
            if ($route->match($url) === true) {
                return $route;
            }
            unset($route);
        }
        throw new \RuntimeException('Aucune route ne correspond à l\'url', self::NO_ROUTE);
    }

    public function registerControllers(): void
    {
        $config_routes = Config::getInstance()->get('routes');
        $attributs_routes = $this->getAttributesRoutes();

        $routes = array_merge($config_routes, $attributs_routes);
        $this->routes = $routes;
    }

    public function getAttributesRoutes()
    {
        $attributes_routes = [];
        $classes = $this->getClassesFromADir(Config::getInstance()->get('controllersPath')[0]);
        foreach ($classes as $class) {
            $reflection = new \ReflectionClass($class);
            foreach ($reflection->getMethods() as $method) {
                $attributes = $method->getAttributes();
                if (!empty($attributes)) {
                    foreach ($attributes as $attribute) {
                        $attributes_routes[] = $attribute->newInstance();
                    }
                }
            }
        }
        return $attributes_routes;
    }

    public function getClassesFromADir(string $dir): array
    {
        $files_list = array_slice(scandir($dir), 2);
        $classes = [];
        foreach ($files_list as $file) {
            $absolute_path = join('/', [$dir, $file]);
            if (is_file($absolute_path)) {
                $classes[] = $this->getClassNameFile($absolute_path);
            } elseif (is_dir($absolute_path)) {
                $classes [] = $this->getClassesFromADir($absolute_path);
            }
        }
        return $this->uniformArray($classes);
    }

    public function getClassNameFile(string $file): string
    {
        if (is_file($file)) {
            $file = str_replace('//', '/', $file); //Url "propre"
            $base_namespace = Config::getInstance()->get('controllersPath')[1];
            $file = str_replace(
                '.' . str_replace('\\', '/', $base_namespace),
                '',
                $file
            );
            $file = str_replace('.php', '', $file);
            $parts = explode('/', $file);
            $className = $base_namespace . \join('\\', $parts);
            if (class_exists($className)) {
                return $className;
            } else {
                throw new \RuntimeException('La classe ' . $className . ' n\'existe pas');
            }
        }
    }

    public function uniformArray(array $array): array
    {
        $uniformed_array = [];
        foreach ($array as $value) {
            if (is_array($value)) {
                $uniformed_array = array_merge($uniformed_array, $this->uniformArray($value));
            } else {
                $uniformed_array[] = $value;
            }
        }
        return $uniformed_array;
    }
}
