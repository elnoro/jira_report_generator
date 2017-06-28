<?php

namespace AppBundle\DTO;

/**
 * Class ConnectionParameters.
 */
class ConnectionParameters
{
    /** @var string */
    private $url;

    /** @var string */
    private $token;

    /**
     * ConnectionParameters constructor.
     *
     * @param string $url
     * @param string $token
     */
    public function __construct(string $url, string $token)
    {
        $this->url = $url;
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
