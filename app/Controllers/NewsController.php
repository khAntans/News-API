<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Apis\FetchNewsApi;
use App\Response;

class NewsController
{
    public function index(): Response
    {
        if (isset($_GET['everything']) && $_GET['everything'] == 'on') {
            $articles = (new  FetchNewsApi())->fetchEverything();
        } else {
            $articles = (new  FetchNewsApi())->fetchTopHeadlines();
        }


        $itemCount = $articles->getTotalResults();
        $pages = ceil($itemCount / 21);
        $currentPage = $_GET["page"] ?? 1;
        $baseUri = preg_replace("/&page=\d+/", "", $_SERVER["REQUEST_URI"]);

        return new Response('index', [
            'articles' => $articles->getArticles(),
            'itemCount' => $itemCount,
            'pages' => $pages,
            'currentPage' => $currentPage,
            'baseUri' => $baseUri
        ]);
    }

}