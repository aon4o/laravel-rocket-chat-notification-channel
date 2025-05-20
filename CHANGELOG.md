# Change log

All notable changes to `aon4o/laravel-rocket-chat-notifications-channel` will be documented in this file

## [0.4.0] - 2025-TODO

### Added

- Added stricter type hinting to all internal classes and methods
- Added support for Rocket.Chat notifications through REST API

### Removed

- Removed support for PHP 5 and 7
- Removed support for Laravel 5, 6, 7, 8, 9
- Rocket.Chat notifications through Webhooks are no longer supported

## [0.3.0] - 2020-09-09

### Added

- ([#17](https://github.com/laravel-notification-channels/rocket-chat/pull/17)) Added Laravel 8 support

## [0.2.0] - 2020-04-26

### Added

- ([#14](https://github.com/laravel-notification-channels/rocket-chat/pull/14)) Added Laravel 7 support
- ([#7](https://github.com/laravel-notification-channels/rocket-chat/pull/7)) Method `getChannel` added to
  `NotificationChannels\RocketChat\RocketChatMessage` class
- ([#7](https://github.com/laravel-notification-channels/rocket-chat/pull/7)) Method `getFrom` added to
  `NotificationChannels\RocketChat\RocketChatMessage` class

### Changed

- ([#7](https://github.com/laravel-notification-channels/rocket-chat/pull/7)) Method `channel` renamed to
  `getDefaultChannel` in `NotificationChannels\RocketChat\RocketChat` class
- ([#7](https://github.com/laravel-notification-channels/rocket-chat/pull/7)) Method `token` renamed to `getToken` in
  `NotificationChannels\RocketChat\RocketChat` class
- ([#7](https://github.com/laravel-notification-channels/rocket-chat/pull/7)) Method `setFromArray` renamed to
  `setPropertiesFromArray` in
  `NotificationChannels\RocketChat\RocketChatAttachment` class

### Fixed

- ([#9](https://github.com/laravel-notification-channels/rocket-chat/pull/9)) Allow the use of `DateTimeImmutable`
  argument in `timestamp` method of
  `NotificationChannels\RocketChat\RocketChatAttachment` class

### Removed

- ([#7](https://github.com/laravel-notification-channels/rocket-chat/pull/7)) Method `url` removed from
  `NotificationChannels\RocketChat\RocketChat` class
- ([#10](https://github.com/laravel-notification-channels/rocket-chat/pull/10)) Method `clearAttachments` removed from
  `NotificationChannels\RocketChat\RocketChatMessage` class

## 0.1.0 - 2020-02-21

- Initial release
