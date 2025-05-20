<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Illuminate\Notifications\Notification;
use NotificationChannels\RocketChat\RocketChatMessage;

class TestNotificationWithMissedChannel extends Notification
{
    public function toRocketChat(): RocketChatMessage
    {
        return RocketChatMessage::create('hello')->from(':token');
    }
}
