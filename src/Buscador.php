<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private $client;
    /**
     * @var Crawler
     */
    private $crawler;

    public function __construct(ClientInterface $client, Crawler $crawler)
    {
        $this->client = $client;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {
        $response = $this->client->request("GET", $url);
        $html = $response->getBody();
        $this->crawler->addHtmlContent($html);

        $cursos_elements = $this->crawler->filter("span.card-curso__nome");
        $cursos = [];

        foreach ($cursos_elements as $curso) {
            array_push($cursos, $curso->textContent);
        }
        return $cursos;
    }
}