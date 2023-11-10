<?php


namespace App\Apis;

use App\models\Article;
use App\models\ArticleCollection;
use Dotenv\Dotenv;
use GuzzleHttp\Client;

class FetchNewsApi
{
    private const BASE_URL = "https://newsapi.org/v2/";
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchTopHeadlines(): ArticleCollection
    {
        if (!isset($_GET['country'])) {
            $_GET['country'] = 'us';
        }

        $params = [
            "q" => $_GET['search'] ?? "",
            "country" => $_GET['country'],
            "from" => $_GET['from'] ?? "",
            "to" => $_GET['to'] ?? "",
            "category" => $_GET['category'] ?? "",
            "pageSize" => 21,
            "page" => $_GET['page'] ?? "1"
        ];

        $url = self::BASE_URL . 'top-headlines?' . http_build_query($params);


        return $this->baseFetch($url);

    }

    public function fetchEverything()
    {
        $params = [
            "q" => $_GET['search'] ?? " ",
            "from" => $_GET['from'] ?? "",
            "to" => $_GET['to'] ?? "",
            "pageSize" => 21,
            "page" => $_GET['page'] ?? "1"
        ];

        $url = self::BASE_URL . 'everything?' . http_build_query($params);


        return $this->baseFetch($url);
    }

    public function baseFetch(string $url)
    {

        $dotenv = Dotenv::createImmutable('../');
        $dotenv->load();

        $url .= '&apiKey=' . $_ENV['API_KEY'];

        $result = $this->client->get($url);
        $articles = json_decode($result->getBody()->getContents());
        $resultCount = $articles->totalResults;
        $articles = $articles->articles;

        $articleCollection = new ArticleCollection($resultCount);
        foreach ($articles as $article) {
            if ($article->source->name == '[Removed]') continue;
            $articleCollection->add(new Article(
                $article->source->name,
                $article->author,
                $article->title,
                $article->description,
                $article->url,
                $article->urlToImage,
                $article->publishedAt));
        }
        return $articleCollection;
    }
}