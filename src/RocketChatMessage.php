<?php

declare(strict_types=1);

namespace NotificationChannels\RocketChat;

class RocketChatMessage
{
    /** @var string|null RocketChat channel id. */
    protected string|null $channel = null;

    /** @var string|null A user or app access token. */
    protected string|null $from = null;

    /** @var string The text content of the message. */
    protected string $content;

    /** @var string|null The alias name of the message. */
    protected string|null $alias = null;

    /** @var string|null The avatar emoji of the message. */
    protected string|null $emoji = null;

    /** @var string|null The avatar image of the message. */
    protected string|null $avatar = null;

    /** @var RocketChatAttachment[] Attachments of the message. */
    protected array $attachments = [];

    /**
     * Create a new instance of RocketChatMessage.
     *
     * @param  string  $content
     *
     * @return static
     */
    public static function create(string $content = ''): self
    {
        return new static($content);
    }

    /**
     * Create a new instance of RocketChatMessage.
     *
     * @param  string  $content
     */
    public function __construct(string $content = '')
    {
        $this->content($content);
    }

    /**
     * @return string|null
     */
    public function getChannel(): string|null
    {
        return $this->channel;
    }

    /**
     * @return string|null
     */
    public function getFrom(): string|null
    {
        return $this->from;
    }

    /**
     * Set the sender's access token.
     *
     * @param  string  $accessToken
     *
     * @return $this
     */
    public function from(string $accessToken): self
    {
        $this->from = $accessToken;

        return $this;
    }

    /**
     * Set the RocketChat channel the message should be sent to.
     *
     * @param  string  $channel
     *
     * @return $this
     */
    public function to(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Set the sender's alias.
     *
     * @param  string  $alias
     *
     * @return $this
     */
    public function alias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Set the sender's emoji.
     *
     * @param  string  $emoji
     *
     * @return $this
     */
    public function emoji(string $emoji): self
    {
        $this->emoji = $emoji;

        return $this;
    }

    /**
     * Set the sender's avatar.
     *
     * @param  string  $avatar
     *
     * @return $this
     */
    public function avatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Set the content of the RocketChat message.
     * Supports GitHub flavored Markdown.
     *
     * @param  string  $content
     *
     * @return $this
     */
    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Add an attachment to the message.
     *
     * @param  array|RocketChatAttachment  $attachment
     *
     * @return $this
     */
    public function attachment(RocketChatAttachment|array $attachment): self
    {
        if (! ($attachment instanceof RocketChatAttachment)) {
            $attachment = new RocketChatAttachment($attachment);
        }

        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * Add multiple attachments to the message.
     *
     * @param  array|RocketChatAttachment[]  $attachments
     *
     * @return $this
     */
    public function attachments(array $attachments): self
    {
        foreach ($attachments as $attachment) {
            $this->attachment($attachment);
        }

        return $this;
    }

    /**
     * Get an array representation of the RocketChatMessage.
     *
     * @return array
     */
    public function toArray(): array
    {
        $attachments = [];

        foreach ($this->attachments as $attachment) {
            $attachments[] = $attachment->toArray();
        }

        return array_filter([
            'text' => $this->content,
            'channel' => $this->channel,
            'alias' => $this->alias,
            'emoji' => $this->emoji,
            'avatar' => $this->avatar,
            'attachments' => $attachments,
        ]);
    }
}
