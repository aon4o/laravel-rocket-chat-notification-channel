<?php

declare(strict_types=1);

use NotificationChannels\RocketChat\RocketChatAttachment;
use NotificationChannels\RocketChat\RocketChatMessage;

it('can accept a content when constructing a message', function () {
    $message = new RocketChatMessage('test-content');

    expect($message->toArray())->toBe(['text' => 'test-content']);
});

it('can accept a content when creating a message', function () {
    $message = RocketChatMessage::create('test-content');

    expect($message->toArray())->toBe(['text' => 'test-content']);
});

it('can set the content', function () {
    $message = (new RocketChatMessage())->content('test-content');

    expect($message->toArray())->toBe(['text' => 'test-content']);
});

it('can set the channel', function () {
    $message = (new RocketChatMessage())->to('test-channel');

    expect($message->getChannel())->toBe('test-channel');
});

it('can set the from', function () {
    $message = (new RocketChatMessage())->from('test-token');

    expect($message->getFrom())->toBe('test-token');
});

it('can set the alias', function () {
    $message = (new RocketChatMessage())->alias('test-alias');

    expect($message->toArray())->toBe(['alias' => 'test-alias']);
});

it('can set the emoji', function () {
    $message = (new RocketChatMessage())->emoji(':emoji:');

    expect($message->toArray())->toBe(['emoji' => ':emoji:']);
});

it('can set the avatar', function () {
    $message = (new RocketChatMessage())->avatar('avatar_img');

    expect($message->toArray())->toBe(['avatar' => 'avatar_img']);
});

it('can set attachment', function () {
    $attachment = RocketChatAttachment::create(['title' => 'test']);
    $message = (new RocketChatMessage())->attachment($attachment);

    expect($message->toArray()['attachments'][0])->toBe($attachment->toArray());
});

it('can set attachment as array', function () {
    $message = (new RocketChatMessage())->attachment(['title' => 'test']);

    expect($message->toArray()['attachments'][0])->toBe(['title' => 'test']);
});

it('can set multiple attachments', function () {
    $message = (new RocketChatMessage())->attachments([
        RocketChatAttachment::create(),
        RocketChatAttachment::create(),
        RocketChatAttachment::create(),
    ]);

    expect($message->toArray()['attachments'])->toHaveCount(3);
});
