<?php

declare(strict_types=1);

namespace App\models;

class ArticleCollection
{
    private array $articles = [];
    private int $totalResults = 0;

    public function __construct(int $totalResults)
    {
        $this->totalResults = $totalResults;
    }

    public function add(Article $article)
    {
        $this->articles[] = $article;
    }

    public function getArticles(): array
    {
        return $this->articles;
    }

    public function getTotalResults(): int
    {
        return $this->totalResults;
    }
}