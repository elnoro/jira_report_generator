<?php

namespace AppBundle\Translation\API;

use AppBundle\DTO\ConnectionParameters;
use AppBundle\Translation\Direction;
use AppBundle\Translation\TranslatorInterface;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;

/**
 * Class YandexTranslator.
 */
final class YandexTranslator implements TranslatorInterface
{
    /** @var HttpClient */
    private $httpClient;

    /** @var ConnectionParameters */
    private $connectionParameters;

    public static function connect(ConnectionParameters $connectionParameters): self
    {
        $httpClient = new HttpClient(['base_uri' => $connectionParameters->getUrl()]);

        return new self($httpClient, $connectionParameters);
    }

    /**
     * YandexTranslator constructor.
     *
     * @param HttpClient           $httpClient
     * @param ConnectionParameters $connectionParameters
     */
    public function __construct(HttpClient $httpClient, ConnectionParameters $connectionParameters)
    {
        $this->httpClient = $httpClient;
        $this->connectionParameters = $connectionParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function translate(array $words, Direction $direction): array
    {
        try {
            $response = $this->httpClient->post(
                'api/v1.5/tr.json/translate',
                $this->buildRequestParams($words, $direction)
            );
        } catch (RequestException $exception) {
            return [];
        }
        $result = json_decode((string) $response->getBody(), true);

        return $result['text'] ?? [];
    }

    /**
     * @param array $words
     *
     * @return string
     */
    protected function buildRequestBody(array $words): string
    {
        return implode('&', array_map(function ($word) {
            return 'text='.$word;
        }, $words));
    }

    /**
     * @param array     $words
     * @param Direction $direction
     *
     * @return array
     */
    protected function buildRequestParams(array $words, Direction $direction): array
    {
        $requestParams = [
            'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
            'query' => [
                'key' => $this->connectionParameters->getToken(),
                'lang' => sprintf('%s-%s', $direction->getFrom(), $direction->getTo()),
            ],
            'body' => $this->buildRequestBody($words),
        ];

        return $requestParams;
    }
}
