<?php

namespace phpGone\Core;

use Psr\Http\Message\ResponseInterface;

/**
 * Class qui permet de renvoyer une réponse au client
 */
class ResponseSender
{
    /**
     * Renvoie une réponse au client
     *
     * @param ResponseInterface $response Réponse à renvoyer
     * @return boolean Résultat
     */
    public function send(ResponseInterface $response): bool
    {
        $http_line = sprintf(
            'HTTP/%s %s %s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );

        header($http_line, true, $response->getStatusCode());

        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header("$name: $value", false);
            }
        }

        $stream = $response->getBody();

        if ($stream->isSeekable()) {
            $stream->rewind();
        }

        while (!$stream->eof()) {
            echo $stream->read(1024 * 8);
        }
        return true;
    }
}
