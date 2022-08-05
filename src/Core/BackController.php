<?php

namespace phpGone\Core;

use bemang\Config;
use bemang\ConfigException;
use bemang\InvalidArgumentExceptionConfig;
use bemang\renderer\PHPRender;
use bemang\renderer\TwigRender;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use phpGone\Helpers\Logger;
use phpGone\Helpers\Url;
use phpGone\Router\Route;
use phpGone\Router\Routeur;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;
use ReflectionMethod;
use ReflectionParameter;

/**
 * Class BackController
 * Class abstraite de base pour les contrôleurs
 */
abstract class BackController
{
    /**
     * Uniquement les classes simples à construire !!
     *
     * @var array
     */
    protected array $argumentToProvide = [
        LoggerInterface::class => Logger::class,
        Url::class => Url::class
    ];
    private Route $route;
    private ServerRequestInterface $request;

    /**
     * @param Route $route Route qui a 'matché'
     * @param ServerRequestInterface $request Requête à traiter
     */
    public function __construct(Route $route, ServerRequestInterface $request)
    {
        $this->setRoute($route);
        $this->setRequest($request);
    }

    private function setRoute(Route $route): void
    {
        $this->route = $route;
    }

    private function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    /**
     * /**
     * @throws InvalidArgumentExceptionConfig
     * @throws \bemang\renderer\Exception\InvalidArgumentException
     * @throws ConfigException
     */
    protected function render(string $view, array $datas, string $renderSystem = null): ResponseInterface
    {
        if (is_null($renderSystem)) {
            if (Config::getInstance()->get('defaultRender') === 'php') {
                return $this->phpRender($view, $datas);
            }
            if (Config::getInstance()->get('defaultRender') === 'twig') {
                return $this->twigRender($view, $datas);
            }
        } else {
            if ($renderSystem === 'php') {
                return $this->phpRender($view, $datas);
            } elseif ($renderSystem === 'twig') {
                return $this->twigRender($view, $datas);
            } else {
                throw new InvalidArgumentException("Le système de rendu $renderSystem est inconnu");
            }
        }
    }

    /**
     * @throws \bemang\renderer\Exception\InvalidArgumentException
     */
    protected function phpRender(string $view, array $datas): ResponseInterface
    {
        $url = new Url();
        $render = new PHPRender($url->getViewsPath(), $url->getTmpPath('cache/twig'));
        return new Response('200', [], $render->render($view, $datas));
    }

    /**
     * @throws InvalidArgumentExceptionConfig
     * @throws ConfigException
     * @throws \bemang\renderer\Exception\InvalidArgumentException
     */
    protected function twigRender(string $view, array $datas): ResponseInterface
    {
        $url = new Url();
        $render = new TwigRender($url->getViewsPath(), $url->getTmpPath('cache/twig'));
        $render->addTwigExtensions(Config::getInstance()->get('TwigExtensions'));
        return new Response('200', [], $render->render($view, $datas));
    }

    /**
     * Permet de rediriger vers une autre route
     *
     * @param string $route
     * @param integer $status
     * @return ResponseInterface
     */
    protected function redirectToRoute(string $route, int $status = 301): ResponseInterface
    {
        $router = new Routeur();
        $routes = $router->getAttributesRoutes();
        if (isset($routes[$route]) && $routes[$route] instanceof Route) {
            $controllerClass = $routes[$route]->getController();
            $controller = new $controllerClass($routes[$route], $this->request);
            $response = $controller->execute();
            return $response->withStatus($status);
        } else {
            throw new InvalidArgumentException('Route inconnue ou invalide');
        }
    }

    /**
     * Execute la bonne fonction enfante en fonction de l'action
     * et fourni les bons arguments
     *
     * @return ResponseInterface
     * @throws ReflectionException
     * @throws \bemang\renderer\Exception\InvalidArgumentException
     */
    public function execute(): ResponseInterface
    {
        if (method_exists($this, 'setUp')) {
            call_user_func_array([$this, 'setUp'], [$this->request]);
        }
        return call_user_func_array(
            [$this, $this->getRoute()->getAction()],
            $this->provideParameters($this->getRoute()->getAction())
        );
    }

    protected function getRoute(): Route
    {
        return $this->route;
    }

    /**
     * @throws ReflectionException
     * @throws \bemang\renderer\Exception\InvalidArgumentException
     */
    protected function provideParameters(string $action): array
    {
        if (method_exists($this, $action)) {
            $resultArray = [];
            $parameters = $this->getActionParameters($action);
            foreach ($parameters as $reflectionParameter) {
                $resultArray[] = $this->provideParameter($reflectionParameter);
            }
            return $resultArray;
        } else {
            throw new InvalidArgumentException("La méthode $action n'existe pas");
        }
    }

    /**
     * @throws ReflectionException
     */
    protected function getActionParameters(string $action): array
    {
        $method = new ReflectionMethod(get_class($this), $action);
        return $method->getParameters();
    }

    /**
     * Fourni le bon argument
     *
     *
     * @param ReflectionParameter $reflectionParameter
     * @return mixed Argument à utiliser
     * @noinspection PhpInconsistentReturnPointsInspection
     * @throws \bemang\renderer\Exception\InvalidArgumentException
     */
    protected function provideParameter(ReflectionParameter $reflectionParameter): mixed
    {
        if ($reflectionParameter->getType() == null || $reflectionParameter->getType()->getName() == 'string') {
            if (array_key_exists($reflectionParameter->getName(), $this->getRoute()->getMatches())) {
                return $this->getRoute()->getMatches()[$reflectionParameter->getName()];
            }
        }
        if (
            $reflectionParameter->getType()->getName() == 'GuzzleHttp\Psr7\Request' ||
            $reflectionParameter->getType()->getName() == 'Psr\Http\Message\RequestInterface'
        ) {
            return $this->request;
        }
        if (
            $reflectionParameter->getType()->getName() == 'bemang\Config'
            || $reflectionParameter->getType()->getName() == 'bemang\ConfigInterface'
        ) {
            return Config::getInstance();
        }
        if (
            $reflectionParameter->getType()->getName() == 'bemang\renderer\RendererInterface'
        ) {
            if ('php' === Config::getInstance()->get('defaultRender')) {
                $url = new Url();
                return new PHPRender($url->getViewsPath(), $url->getTmpPath('cache/twig'));
            }
            if (Config::getInstance()->get('defaultRender') === 'twig') {
                $url = new Url();
                $render = new TwigRender($url->getViewsPath(), $url->getTmpPath('cache/twig'));
                $render->addTwigExtensions(Config::getInstance()->get('TwigExtensions'));
                return $render;
            }
        }
        //Provide simple classes/interfaces
        foreach ($this->argumentToProvide as $interface => $toProvide) {
            if ($reflectionParameter->getType()->getName() == $interface) {
                return new $toProvide();
            }
        }
    }

    /**
     * Permet de changer de route et d'avoir une erreur 404
     *
     * @return ResponseInterface Réponse avec l'erreur 404
     */
    protected function error(): ResponseInterface
    {
        $router = new Routeur();
        $errorRoute = $router->getAttributesRoutes()['error404'];
        $controllerName = $errorRoute->getController();
        $controller = new $controllerName($errorRoute, $this->request);
        $response = $controller->execute();
        return $response->withStatus(404);
    }
}
