<?php

namespace phpGone\Core;

use bemang\Config;
use phpGone\Helpers\Url;
use phpGone\Router\Route;
use GuzzleHttp\Psr7\Response;
use bemang\renderer\PHPRender;
use bemang\renderer\TwigRender;
use phpGone\Router\Routeur;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BackController
 * Class abstraite de base pour les controleurs
 */
abstract class BackController
{
    private Route $route;
    private ServerRequestInterface $request;

    /**
     * Uniqument les classes simples à construire !!
     *
     * @var array
     */
    protected $argumentToProvide = [
        \Psr\Log\LoggerInterface::class => \phpGone\Log\Logger::class,
        \phpGone\Helpers\Url::class => \phpGone\Helpers\Url::class
    ];

    /**
     * Constucteur du BackController
     *
     * @param Route $route Route qui a 'matché'
     * @param ServerRequestInterface $request Requête à traiter
     */
    public function __construct(Route $route, $request)
    {
        $this->setRoute($route);
        $this->setRequest($request);
    }

    /**
     * Execute la bonne fonction enfante en fonction de l'action
     * et fourni les bons arguments
     *
     * @return void
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

    private function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    private function setRoute(Route $route)
    {
        $this->route = $route;
    }

    protected function getRoute(): Route
    {
        return $this->route;
    }

    protected function getActionParameters(string $action)
    {
        $method = new \ReflectionMethod(get_class($this), $action);
        return $method->getParameters();
    }

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
            throw new \InvalidArgumentException("La méthode $action n'existe pas");
        }
    }

    /**
     * Fourni le bon argument
     *
     * //TODO : revoir la manière de distribution de certains arguments (les mettre dans le tableau) (?)
     *
     * @param \ReflectionParameter $param
     * @return mixin argument à utiliser
     */
    protected function provideParameter(\ReflectionParameter $reflectionParameter)
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
            if (Config::getInstance()->get('defaultRender') === 'php') {
                $url = new Url();
                return new PHPRender($url->getAppPath('views'), $url->getTmpPath('cache/twig'));
            }
            if (Config::getInstance()->get('defaultRender') === 'twig') {
                $url = new Url();
                $render = new TwigRender($url->getAppPath('views'), $url->getTmpPath('cache/twig'));
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
                throw new \InvalidArgumentException("Le système de rendu $renderSystem est inconnu");
            }
        }
    }

    protected function phpRender(string $view, array $datas): ResponseInterface
    {
        $url = new Url();
        $render = new PHPRender($url->getViewsPath(), $url->getTmpPath('cache/twig'));
        return new Response('200', [], $render->render($view, $datas));
    }

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
            $response = $response->withStatus($status);
            return $response;
        } else {
            throw new \InvalidArgumentException('Route inconnue ou invalide');
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
        $response = $response->withStatus(404);
        return $response;
    }
}
