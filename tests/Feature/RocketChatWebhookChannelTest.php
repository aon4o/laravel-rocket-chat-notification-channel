<?php

declare(strict_types=1);

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Psr7\Response;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use NotificationChannels\RocketChat\Exceptions\CouldNotSendNotification;
use NotificationChannels\RocketChat\RocketChat;
use NotificationChannels\RocketChat\RocketChatWebhookChannel;
use Tests\Fixtures\TestNotifiable;
use Tests\Fixtures\TestNotification;
use Tests\Fixtures\TestNotificationWithMissedChannel;
use Tests\Fixtures\TestNotificationWithMissedFrom;

uses(MockeryPHPUnitIntegration::class);

it('can send a notification', function () {
    $client = Mockery::mock(GuzzleHttpClient::class);

    $apiBaseUrl = 'http://localhost:3000';
    $token = ':token';
    $user_id = ':user_id';
    $channel = ':channel';

    $client->shouldReceive('post')->once()
        ->with(
            "{$apiBaseUrl}/api/v1/chat.postMessage",
            [
                'headers' => [
                    'X-Auth-Token' => $token,
                    'X-User-Id' => $user_id,
                    'Rocket-Channel-Id' => $channel,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'text' => 'hello',
                    'channel' => $channel,
                ],
            ]
        )->andReturn(new Response(200));

    $rocketChat = new RocketChat($client, $apiBaseUrl, $token, $user_id, $channel);
    $channel = new RocketChatWebhookChannel($rocketChat);
    $channel->send(new TestNotifiable(), new TestNotification());
});

it('handles generic errors', function () {
    $client = Mockery::mock(GuzzleHttpClient::class);
    $this->expectException(CouldNotSendNotification::class);

    $apiBaseUrl = 'http://localhost:3000';
    $token = ':token';
    $user_id = ':user_id';
    $channel = ':channel';

    $client->shouldReceive('post')->once()
        ->with(
            "{$apiBaseUrl}/api/v1/chat.postMessage",
            [
                'headers' => [
                    'X-Auth-Token' => $token,
                    'X-User-Id' => $user_id,
                    'Rocket-Channel-Id' => $channel,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'text' => 'hello',
                    'channel' => $channel,
                ],
            ]
        )->andThrow(new Exception('Test'));

    $rocketChat = new RocketChat($client, $apiBaseUrl, $token, $user_id, $channel);
    $channel = new RocketChatWebhookChannel($rocketChat);
    $channel->send(new TestNotifiable(), new TestNotification());
});

it('does not send a message when channel missed', function () {
    $this->expectException(CouldNotSendNotification::class);

    $rocketChat = new RocketChat(new GuzzleHttpClient(), '', '', '', '', '');
    $channel = new RocketChatWebhookChannel($rocketChat);
    $channel->send(new TestNotifiable(), new TestNotificationWithMissedChannel());
});

it('does not send a message when from missed', function () {
    $this->expectException(CouldNotSendNotification::class);

    $rocketChat = new RocketChat(new GuzzleHttpClient(), '', '', '', '');
    $channel = new RocketChatWebhookChannel($rocketChat);
    $channel->send(new TestNotifiable(), new TestNotificationWithMissedFrom());
});
