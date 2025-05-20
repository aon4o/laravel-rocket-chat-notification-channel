<?php

declare(strict_types=1);

use NotificationChannels\RocketChat\RocketChatAttachment;

it('can accept a config when constructing an attachment', function () {
    $attachment = new RocketChatAttachment(['title' => 'test123']);

    expect($attachment->toArray())->toEqual(['title' => 'test123']);
});

it('can accept a config when creating an attachment', function () {
    $attachment = RocketChatAttachment::create(['title' => 'test123']);

    expect($attachment->toArray())->toEqual(['title' => 'test123']);
});

it('returns an empty array if not configured', function () {
    $attachment = new RocketChatAttachment();

    expect($attachment->toArray())->toEqual([]);
});

it('can set the color', function () {
    $attachment = new RocketChatAttachment();
    $attachment->color('#FFFFFF');

    expect($attachment->toArray())->toEqual(['color' => '#FFFFFF']);
});

it('can set the text', function () {
    $attachment = new RocketChatAttachment();
    $attachment->text('test123');

    expect($attachment->toArray())->toEqual(['text' => 'test123']);
});

it('can set the timestamp', function () {
    $attachment = new RocketChatAttachment();
    $attachment->timestamp('2020-02-19T19:00:00.000Z');

    expect($attachment->toArray())->toEqual(['ts' => '2020-02-19T19:00:00.000Z']);
});

it('can set the timestamp as datetime', function () {
    $date = DateTime::createFromFormat('Y-m-d H:i:s.u', '2020-02-19 19:00:00.000');
    $attachment = new RocketChatAttachment();
    $attachment->timestamp($date);

    expect($attachment->toArray())->toEqual(['ts' => $date->format(DateTimeInterface::ATOM)]);
});

it('can set the timestamp as immutable datetime', function () {
    $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', '2020-02-19 19:00:00.000');
    $attachment = new RocketChatAttachment();
    $attachment->timestamp($date);

    expect($attachment->toArray())->toBe(['ts' => $date->format(DateTimeInterface::ATOM)]);
});

it('can set the thumb url', function () {
    $attachment = new RocketChatAttachment();
    $attachment->thumbnailUrl('test123');

    expect($attachment->toArray())->toEqual(['thumb_url' => 'test123']);
});

it('can set the message link', function () {
    $attachment = new RocketChatAttachment();
    $attachment->messageLink('test123');

    expect($attachment->toArray())->toEqual(['message_link' => 'test123']);
});

it('can set the collapsed', function () {
    $attachment = new RocketChatAttachment();
    $attachment->collapsed(true);

    expect($attachment->toArray())->toEqual(['collapsed' => true]);
});

it('can set the author name', function () {
    $attachment = new RocketChatAttachment();
    $attachment->authorName('author');

    expect($attachment->toArray())->toEqual(['author_name' => 'author']);
});

it('can set the author link', function () {
    $attachment = new RocketChatAttachment();
    $attachment->authorLink('test123');

    expect($attachment->toArray())->toEqual(['author_link' => 'test123']);
});

it('can set the author icon', function () {
    $attachment = new RocketChatAttachment();
    $attachment->authorIcon('test123');

    expect($attachment->toArray())->toEqual(['author_icon' => 'test123']);
});

it('can set the author', function () {
    $attachment = new RocketChatAttachment();
    $attachment->author('aname', 'alink', 'aicon');

    expect($attachment->toArray())->toEqual([
        'author_name' => 'aname',
        'author_link' => 'alink',
        'author_icon' => 'aicon',
    ]);
});

it('can set the title', function () {
    $attachment = new RocketChatAttachment();
    $attachment->title('test123');

    expect($attachment->toArray())->toEqual(['title' => 'test123']);
});

it('can set the title link', function () {
    $attachment = new RocketChatAttachment();
    $attachment->titleLink('test123');

    expect($attachment->toArray())->toEqual(['title_link' => 'test123']);
});

it('can set the title link download', function () {
    $attachment = new RocketChatAttachment();
    $attachment->titleLinkDownload(true);

    expect($attachment->toArray())->toEqual(['title_link_download' => true]);
});

it('can set the image url', function () {
    $attachment = new RocketChatAttachment();
    $attachment->imageUrl('test123');

    expect($attachment->toArray())->toEqual(['image_url' => 'test123']);
});

it('can set the audio url', function () {
    $attachment = new RocketChatAttachment();
    $attachment->audioUrl('test123');

    expect($attachment->toArray())->toEqual(['audio_url' => 'test123']);
});

it('can set the video url', function () {
    $attachment = new RocketChatAttachment();
    $attachment->videoUrl('test123');

    expect($attachment->toArray())->toEqual(['video_url' => 'test123']);
});

it('can set the fields', function () {
    $fields = [
        [
            'short' => false,
            'title' => 'test1',
            'value' => 'value1',
        ],
        [
            'short' => true,
            'title' => 'test2',
            'value' => 'value2',
        ],
    ];
    $attachment = new RocketChatAttachment();
    $attachment->fields($fields);

    expect($attachment->toArray())->toEqual(compact('fields'));
});

it('cannot set unknown field', function () {
    $attachment = new RocketChatAttachment(['notExisting']);
    expect($attachment->toArray())->toEqual([]);
});
