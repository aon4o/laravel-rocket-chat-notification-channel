<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Illuminate\Notifications\Notifiable;

class TestNotifiable
{
    use Notifiable;

    public function routeNotificationForRocketChat(): string
    {
        return '';
    }
}
