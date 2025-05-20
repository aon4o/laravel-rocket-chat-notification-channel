<?php

declare(strict_types=1);

namespace NotificationChannels\RocketChat;

use DateTimeInterface;
use Illuminate\Support\Str;

class RocketChatAttachment
{
    /** @var string|null The color you want the order on the left side to be, any value background-css supports. */
    protected string|null $color = null;

    /** @var string|null The text to display for this attachment, it is different from the message’s text. */
    protected string|null $text = null;

    /** @var string|null Displays the time next to the text portion. */
    protected string|null $timestamp = null;

    /** @var string|null An image that displays to the left of the text looks better when this is relatively small. */
    protected string|null $thumbnailUrl = null;

    /** @var string|null Only applicable if the ts is provided, as it makes the time clickable to this link. */
    protected string|null $messageLink = null;

    /** @var bool Causes the image, audio, and video sections to be hiding when collapsed is true. */
    protected bool $collapsed = false;

    /** @var string|null Name of the author. */
    protected string|null $authorName = null;

    /** @var string|null Providing this makes the author name clickable and points to this link. */
    protected string|null $authorLink = null;

    /** @var string|null Displays a tiny icon to the left of the Author’s name. */
    protected string|null $authorIcon = null;

    /** @var string|null Title to display for this attachment, displays under the author. */
    protected string|null $title = null;

    /** @var string|null Providing this makes the title clickable, pointing to this link. */
    protected string|null $titleLink = null;

    /** @var bool When this is true, a download icon appears and clicks this saves the link to file. */
    protected bool $titleLinkDownload = false;

    /** @var string|null The image to display, will be “big” and easy to see. */
    protected string|null $imageUrl = null;

    /** @var string|null Audio file to play, only supports what HTML audio does. */
    protected string|null $audioUrl = null;

    /** @var string|null Video file to play, only supports what HTML video does. */
    protected string|null $videoUrl = null;

    /** @var array An array of Attachment Field Objects. */
    protected array $fields = [];

    /**
     * RocketChatAttachment constructor.
     *
     * @param  array  $data
     */
    public function __construct(array $data = [])
    {
        $this->setPropertiesFromArray($data);
    }

    /**
     * Create a new instance of RocketChatAttachment.
     *
     * @param  array  $data
     *
     * @return RocketChatAttachment
     */
    public static function create(array $data = []): RocketChatAttachment
    {
        return new self($data);
    }

    /**
     * @param  string  $color
     *
     * @return RocketChatAttachment
     */
    public function color(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @param  string  $text
     *
     * @return RocketChatAttachment
     */
    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param  DateTimeInterface|string  $timestamp
     *
     * @return RocketChatAttachment
     */
    public function timestamp(DateTimeInterface|string $timestamp): self
    {
        if ($timestamp instanceof DateTimeInterface) {
            $timestamp = $timestamp->format(DateTimeInterface::RFC3339);
        }

        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @param  string  $thumbnailUrl
     *
     * @return RocketChatAttachment
     */
    public function thumbnailUrl(string $thumbnailUrl): self
    {
        $this->thumbnailUrl = $thumbnailUrl;

        return $this;
    }

    /**
     * @param  string  $messageLink
     *
     * @return RocketChatAttachment
     */
    public function messageLink(string $messageLink): self
    {
        $this->messageLink = $messageLink;

        return $this;
    }

    /**
     * @param  bool  $collapsed
     *
     * @return RocketChatAttachment
     */
    public function collapsed(bool $collapsed): self
    {
        $this->collapsed = $collapsed;

        return $this;
    }

    /**
     * @param  string  $name
     * @param  string  $link
     * @param  string  $icon
     *
     * @return RocketChatAttachment
     */
    public function author(string $name, string $link = '', string $icon = ''): self
    {
        $this->authorName($name);
        $this->authorLink($link);
        $this->authorIcon($icon);

        return $this;
    }

    /**
     * @param  string  $authorName
     *
     * @return RocketChatAttachment
     */
    public function authorName(string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * @param  string  $authorLink
     *
     * @return RocketChatAttachment
     */
    public function authorLink(string $authorLink): self
    {
        $this->authorLink = $authorLink;

        return $this;
    }

    /**
     * @param  string  $authorIcon
     *
     * @return RocketChatAttachment
     */
    public function authorIcon(string $authorIcon): self
    {
        $this->authorIcon = $authorIcon;

        return $this;
    }

    /**
     * @param  string  $title
     *
     * @return RocketChatAttachment
     */
    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param  string  $titleLink
     *
     * @return RocketChatAttachment
     */
    public function titleLink(string $titleLink): self
    {
        $this->titleLink = $titleLink;

        return $this;
    }

    /**
     * @param  bool  $titleLinkDownload
     *
     * @return RocketChatAttachment
     */
    public function titleLinkDownload(bool $titleLinkDownload): self
    {
        $this->titleLinkDownload = $titleLinkDownload;

        return $this;
    }

    /**
     * @param  string  $imageUrl
     *
     * @return RocketChatAttachment
     */
    public function imageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @param  string  $audioUrl
     *
     * @return RocketChatAttachment
     */
    public function audioUrl(string $audioUrl): self
    {
        $this->audioUrl = $audioUrl;

        return $this;
    }

    /**
     * @param  string  $videoUrl
     *
     * @return RocketChatAttachment
     */
    public function videoUrl(string $videoUrl): self
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    /**
     * @param  array  $fields
     *
     * @return RocketChatAttachment
     */
    public function fields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Get an array representation of the RocketChatAttachment.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'color' => $this->color,
            'text' => $this->text,
            'ts' => $this->timestamp,
            'thumb_url' => $this->thumbnailUrl,
            'message_link' => $this->messageLink,
            'collapsed' => $this->collapsed,
            'author_name' => $this->authorName,
            'author_link' => $this->authorLink,
            'author_icon' => $this->authorIcon,
            'title' => $this->title,
            'title_link' => $this->titleLink,
            'title_link_download' => $this->titleLinkDownload,
            'image_url' => $this->imageUrl,
            'audio_url' => $this->audioUrl,
            'video_url' => $this->videoUrl,
            'fields' => $this->fields,
        ]);
    }

    /**
     * Set attachment data from array.
     *
     * @param  array  $data
     *
     * @return void
     */
    private function setPropertiesFromArray(array $data): void
    {
        foreach ($data as $key => $value) {
            $method_name = Str::camel($key);

            if (! method_exists($this, $method_name)) {
                continue;
            }

            $this->{$method_name}($value);
        }
    }
}
