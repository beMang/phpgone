<?php
/**
 * Fichier de la classe TrailingSlashMiddleware
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Middlewares;

/**
 * Class TrailingSlashMiddleware
 * Permet de rediriger si il y a un slash a la fin de l'url
 */
class TrailingSlashMiddleware extends Middleware
{
    /**
     * Fait fonctionner le middleware (Méthode magique)
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Requête à traiter
     * @param string $next Fonction à appeler
     * @return \Psr\Http\Message\Response
     */
    public function __invoke(\Psr\Http\Message\ServerRequestInterface $request, $next)
    {
        $uri = $request->getUri()->getPath();
        if (substr($uri, -1, 1) == '/') {
            if (!empty(substr($uri, 0, -1))) {
                $response = new \GuzzleHttp\Psr7\Response;
                $response = $response->withStatus(301)
                                 ->withHeader('Location', substr($uri, 0, -1));
                //$this->getApp()->getContainer()->get(\phpGone\Log\Logger::class)
                //                               ->info('Redirection vers ' . substr($uri, 0, -1));
                return $response;
            }
        }
        return $next($request);
    }
}
