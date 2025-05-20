<?php

declare(strict_types=1);

namespace NotificationChannels\RocketChat;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;

final class RocketChat
{
    /** @var HttpClient */
    private HttpClient $http;

    /** @var string */
    private string $url;

    /** @var string */
    private string $token;

    /** @var string */
    private string $userId;

    /** @var string|null */
    private string|null $defaultChannel;

    /**
     * @param  HttpClient  $http
     * @param  string  $url
     * @param  string  $token
     * @param  string  $user_id
     * @param  string|null  $defaultChannel
     */
    public function __construct(
        HttpClient $http,
        string $url,
        string $token,
        string $user_id,
        string|null $defaultChannel = null,
    ) {
        $this->http = $http;
        $this->url = rtrim($url, '/');
        $this->token = $token;
        $this->userId = $user_id;
        $this->defaultChannel = $defaultChannel;
    }

    /**
     * Returns RocketChat token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Returns default channel id or name.
     *
     * @return string|null
     */
    public function getDefaultChannel(): string|null
    {
        return $this->defaultChannel;
    }

    /**
     * Send a message.
     *
     * @param  string  $to
     * @param  array  $message
     *
     * @return void
     *
     * @throws GuzzleException
     */
    public function sendMessage(string $to, array $message): void
    {
        $endpoint = sprintf('%s/api/v1/chat.postMessage', $this->url);

        $this->post($endpoint, [
            'headers' => [
                'X-Auth-Token' => $this->token,
                'X-User-Id' => $this->userId,
                'Rocket-Channel-Id' => $to,
                'Content-Type' => 'application/json',
            ],
            'json' => array_merge($message, [
                'channel' => $to,
            ]),
        ]);
    }

    /**
     * Perform a simple POST request.
     *
     * @param  string  $url
     * @param  array  $options
     *
     * @return void
     *
     * @throws GuzzleException
     */
    private function post(string $url, array $options): void
    {
        $this->http->post($url, $options);
    }
}
