<?php

namespace App\Services;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class WebScraperService
{
    public function WebScraper($url)
    {
        $client  = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

        $titles = $crawler->filter('.listResults h2')->each(function ($node) {
            return $node->text();
        });

        $links = $crawler->filter('.listResults a.s-link')->each(function($node){
            $href  = 'https://stackoverflow.com' . $node->attr('href');
            $title = $node->attr('title');
            $text  = $node->text();
            return compact('href', 'title', 'text');
        });

        $tags = $crawler->filter('.ps-relative.d-inline-block')->each(function($node){
            return $node->filter('a.post-tag')->each(function($nested_node){
                $href  = 'https://stackoverflow.com' . $nested_node->attr('href');
                $title = $nested_node->attr('title');
                $text  = $nested_node->text();
                return compact('href', 'title', 'text');
            });
        });

        $location = $crawler->filter('.listResults h3')->each(function ($node) {
            return $node->text();
        });

        $time = $crawler->filter('div.fs-caption div.grid--cell:first-child')->each(function ($node) {
            return $node->text();
        });

        return compact('titles', 'location', 'time', 'links', 'tags');
    }
}
