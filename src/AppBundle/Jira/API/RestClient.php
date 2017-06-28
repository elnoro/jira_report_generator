<?php

namespace AppBundle\Jira\API;

use AppBundle\Exception\DataFetchingException;
use AppBundle\Jira\Issue\IssueList;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;

/**
 * Class RestClient.
 */
final class RestClient implements SearchEngineInterface
{
    const REST_API_PATH = '/rest/api/2/';
    /** @var HttpClient */
    private $httpClient;

    /**
     * @param JiraAccessParameters $jiraAccessParameters
     *
     * @return RestClient
     */
    public static function connect(JiraAccessParameters $jiraAccessParameters): self
    {
        return new self(new HttpClient([
            'base_uri' => $jiraAccessParameters->getServerUrl().self::REST_API_PATH,
            'auth' => [$jiraAccessParameters->getUsername(), $jiraAccessParameters->getPassword()],
        ]));
    }

    /**
     * RestClient constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $jql
     *
     * @return IssueList
     */
    public function search(string $jql): IssueList
    {
        try {
            $response = $this->httpClient->get('search', ['query' => ['jql' => $jql]]);
            $result = json_decode((string) $response->getBody(), true);
            if (!$result) {
                throw DataFetchingException::cannotParseResult($jql, (string) $response->getBody());
            }

            return IssueList::denormalize($result);
        } catch (RequestException $e) {
            throw DataFetchingException::fromHttpException($e);
        }
    }
}
