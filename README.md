# Rocket.Chat REST API Laravel Notifications Channel

![Packagist Version](https://img.shields.io/packagist/v/aon4o/laravel-rocket-chat-notification-channel?style=flat-square&logo=packagist)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/aon4o/laravel-rocket-chat-notification-channel.svg?style=flat-square)](https://packagist.org/packages/aon4o/laravel-rocket-chat-notification-channel)

## Introduction

This package makes it easy to send notifications using [RocketChat](https://rocket.chat/) with Laravel 5.6+.
The package uses the REST API of RocketChat to send messages to channels instead of using the Webhooks method.

## Contents

- [Installation](#installation)
    - [Setting up the RocketChat service](#setting-up-the-rocketchat-service)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Testing](#testing)
- [Linting](#linting)
- [Security](#security)
- [Credits](#credits)
- [Change log](#change-log)
- [License](#license)

## Installation

You can install the package via composer:

```shell script
$ composer require aon4o/laravel-rocket-chat-notification-channel
```

### Setting up the RocketChat service

In order to send message to RocketChat channels, you need to
obtain [Webhook](https://rocket.chat/docs/administrator-guides/integrations#how-to-create-a-new-incoming-webhook).

Add your RocketChat API server's base url, incoming Webhook Token and optionally the default channel to your
`config/services.php`:

```php
// config/services.php
...
'rocketchat' => [
     // Base URL for RocketChat API server (https://your.rocketchat.server.com)
    'url' => env('ROCKETCHAT_URL'),
    'token' => env('ROCKETCHAT_TOKEN'),
    // Default user id (optional)
    'user_id' => env('ROCKETCHAT_USER_ID'),
    // Default channel (optional)
    'channel' => env('ROCKETCHAT_CHANNEL'),
],
...
```

## Usage

You can use the channel in your `via()` method inside the notification:

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\RocketChat\RocketChatMessage;
use NotificationChannels\RocketChat\RocketChatChannel;

class TaskCompleted extends Notification
{
    public function via($notifiable): array
    {
        return [
            RocketChatChannel::class,
        ];
    }

    public function toRocketChat($notifiable): RocketChatMessage
    {
        return RocketChatMessage::create('Test message')
            ->to('channel_name') // optional if set in config
            ->from('webhook_token'); // optional if set in config
    }
}
```

In order to let your notification know which RocketChat channel you are targeting, add the
`routeNotificationForRocketChat` method to your Notifiable model:

```php
public function routeNotificationForRocketChat(): string
{
    return 'channel_name';
}
```

### Available methods

`from()`: Sets the sender's access token.

`to()`: Specifies the channel id to send the notification to (overridden by `routeNotificationForRocketChat` if empty).

`content()`: Sets a content of the notification message. Supports GitHub flavored Markdown.

`alias()`:  This will cause the message’s name to appear as the given alias, but your username will still display.

`emoji()`: This will make the avatar on this message be an emoji. (e.g. ':see_no_evil:')

`avatar()`: This will make the avatar use the provided image url.

`attachment()`: This will add an single attachment.

`attachments()`: This will add multiple attachments.

`clearAttachments()`: This will remove all attachments.

### Adding Attachment

There are several ways to add one or more attachments to a message

```php
public function toRocketChat($notifiable)
{
    return RocketChatMessage::create('Test message')
        ->to('channel_name') // optional if set in config
        ->from('webhook_token') // optional if set in config
        ->attachments([
            RocketChatAttachment::create()->imageUrl('test'),
            RocketChatAttachment::create(['image_url' => 'test']),
            new RocketChatAttachment(['image_url' => 'test']),
            [
                'image_url' => 'test'
            ]   
        ]);   
}
```

#### Available methods

`color()`: The color you want the order on the left side to be, any value background-css supports.

`text()`: The text to display for this attachment, it is different than the message’s text.

`timestamp()`: Displays the time next to the text portion. ISO8601 Zulu Date or instance of any `\DateTime`

`thumbnailUrl()`: An image that displays to the left of the text, looks better when this is relatively small.

`messageLink()`: Only applicable if the ts is provided, as it makes the time clickable to this link.

`collapsed()`: Causes the image, audio, and video sections to be hiding when collapsed is true.

`author($name, $link, $icon)`: shortcut for author methods

`authorName()`: Name of the author.

`authorLink()`: Providing this makes the author name clickable and points to this link.

`authorIcon()`: Displays a tiny icon to the left of the Author’s name.

`title()`: Title to display for this attachment, displays under the author.

`titleLink()`: Providing this makes the title clickable, pointing to this link.

`titleLinkDownload()`: When this is true, a download icon appears and clicking this saves the link to file.

`imageUrl()`: The image to display, will be “big” and easy to see.

`audioUrl()`: Audio file to play, only supports what html audio does.

`videoUrl()`: Video file to play, only supports what html video does.

`fields()`: An array of Attachment Field Objects.

```php
[
    [
        'short' => false, // Whether this field should be a short field. Default: false
        'title' => 'Title 1', //The title of this field. Required
        'value' => 'Value 1' // The value of this field, displayed underneath the title value. Required
    ],
    [
        'short' => true,
        'title' => 'Title 2',
        'value' => 'Value 2'
    ],

];   
```

## Testing

```shell script
$ composer test
```

## Linting

```shell script
$ composer lint
```

## Security

If you discover any security related issues, please email a.o.naidenov@gmail.com instead of using the issue tracker.

## Credits

- [Anton Komarev](https://komarev.com)
- [Nicholas](https://github.com/Funfare)
- [atymic](https://github.com/atymic)
- [All Contributors](../../contributors)

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

