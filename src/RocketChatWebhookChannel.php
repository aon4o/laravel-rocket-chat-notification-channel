<?php

declare(strict_types=1);

namespace NotificationChannels\RocketChat;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Notifications\Notification;
use NotificationChannels\RocketChat\Exceptions\CouldNotSendNotification;

final class RocketChatWebhookChannel
{
    /** @var RocketChat The HTTP client instance. */
    private RocketChat $rocketChat;

    /**
     * Create a new RocketChat channel instance.
     *
     * @param  RocketChat  $rocketChat
     *
     * @return void
     */
    public function __construct(RocketChat $rocketChat)
    {
        $this->rocketChat = $rocketChat;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  Notification  $notification
     *
     * @return void
     *
     * @throws CouldNotSendNotification
     */
    public function send(mixed $notifiable, Notification $notification): void
    {
        /** @var RocketChatMessage $message */
        $message = $notification->toRocketChat($notifiable);

        $channel = $message->getChannel() ?: $notifiable->routeNotificationFor('RocketChat');
        $channel = $channel ?: $this->rocketChat->getDefaultChannel();

        if (empty($channel)) {
            throw CouldNotSendNotification::missingTo();
        }

        $from = $message->getFrom() ?: $this->rocketChat->getToken();

        if (! $from) {
            throw CouldNotSendNotification::missingFrom();
        }

        try {
            $this->sendMessage($channel, $message);
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::rocketChatRespondedWithAnError($exception);
        } catch (Exception $exception) {
            throw CouldNotSendNotification::couldNotCommunicateWithRocketChat($exception);
        }
    }

    /**
     * @param  string  $to
     * @param  RocketChatMessage  $message
     *
     * @return void
     */
    private function sendMessage(string $to, RocketChatMessage $message): void
    {
        $this->rocketChat->sendMessage($to, $message->toArray());
    }
}
