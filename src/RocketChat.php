<?php

declare(strict_types=1);

namespace NotificationChannels\RocketChat;

use GuzzleHttp\Client as HttpClient;

final class RocketChat
{
    /** @var \GuzzleHttp\Client */
    private $http;

    /** @var string */
    private $url;

    /** @var string */
    private $token;

    /** @var string */
    private $userId;

    /** @var string|null */
    private $defaultChannel;

    /**
     * @param  \GuzzleHttp\Client  $http
     * @param  string  $url
     * @param  string  $token
     * @param  string|null  $defaultChannel
     * @return void
     */
    public function __construct(HttpClient $http, string $url, string $token, string $user_id, ?string $defaultChannel = null)
    {
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
    public function getDefaultChannel(): ?string
    {
        return $this->defaultChannel;
    }

    /**
     * Send a message.
     *
     * @param  string  $to
     * @param  array  $message
     * @return void
     */
    public function sendMessage(string $to, array $message): void
    {
        $url = sprintf('%s/api/v1/chat.postMessage', $this->url);

        $this->post($url, [
            'headers' => [
                'X-Auth-Token' => $this->token,
                'X-User-Id' => $this->userId,
                'Rocket-Channel-Id' => $to,
                'Content-Type' => 'application/json'
            ],
            'json' => array_merge($message, [
                'channel' => $to,
            ]),
        ]);
    }

    /**
     * Perform a simple post request.
     *
     * @param  string  $url
     * @param  array  $options
     * @return void
     */
    private function post(string $url, array $options): void
    {
        $this->http->post($url, $options);
    }
}
