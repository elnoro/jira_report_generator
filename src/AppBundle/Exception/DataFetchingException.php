<?php

namespace AppBundle\Exception;

use Doctrine\DBAL\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

/**
 * Class DataFetchingException.
 */
class DataFetchingException extends \RuntimeException
{
    /**
     * @param RequestException $exception
     *
     * @return DataFetchingException
     */
    public static function fromHttpException(RequestException $exception): self
    {
        if ($exception instanceof ServerException || $exception instanceof ConnectException) {
            return new self(sprintf(
                'Cannot get data because server is unavailable: %d %s',
                $exception->getResponse() ? $exception->getResponse()->getStatusCode() : 'no response',
                $exception->getRequest()->getUri()
            ));
        }
        if ($exception->getResponse()->getStatusCode() === 401) {
            return new self('Cannot authenticate');
        }

        return new self(sprintf(
            'Cannot get a resource: %d %s',
            $exception->getResponse()->getStatusCode(),
            $exception->getRequest()->getUri()
        ));
    }

    /**
     * @param string $request
     * @param string $response
     *
     * @return DataFetchingException
     */
    public static function cannotParseResult(string $request, string $response): self
    {
        return new self(sprintf('Cannot parse the result from %s: %s', $request, $response));
    }
}
