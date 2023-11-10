<?php

declare(strict_types=1);

namespace App\models;

use Carbon\Carbon;

class Article
{
    private ?string $source;
    private ?string $author;
    private ?string $title;
    private ?string $description;
    private ?string $url;
    private ?string $urlToImage;
    private ?Carbon $publishedAt;

    public function __construct(?string $source,
                                ?string $author,
                                ?string $title,
                                ?string $description,
                                ?string $url,
                                ?string $urlToImage,
                                ?string $publishedAt
    )
    {
        $this->source = $source;
        $this->author = $author;
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->urlToImage = $urlToImage ?? "https://placekitten.com/200/200";
        $this->publishedAt = Carbon::parse($publishedAt);
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getUrlToImage(): ?string
    {
        return $this->urlToImage;
    }

    public function getPublishedAt(): ?string
    {
        return $this->publishedAt->format("d/m/y");
    }
}