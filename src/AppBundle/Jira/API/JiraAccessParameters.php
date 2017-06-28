<?php

namespace AppBundle\Jira\API;

/**
 * Class JiraAccessParameters.
 */
final class JiraAccessParameters
{
    /** @var string */
    private $serverUrl;

    /** @var string */
    private $username;

    /** @var string */
    private $password;

    /**
     * @param array $parameters
     *
     * @return JiraAccessParameters
     */
    public static function fromArray(array $parameters): self
    {
        return new self($parameters['serverUrl'], $parameters['username'], $parameters['password']);
    }

    /**
     * JiraAccessParameters constructor.
     *
     * @param string $serverUrl
     * @param string $username
     * @param string $password
     */
    public function __construct(string $serverUrl, string $username, string $password)
    {
        $this->serverUrl = $serverUrl;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getServerUrl(): string
    {
        return $this->serverUrl;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
