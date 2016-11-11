<?php
namespace GibertJeune;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class Api
{
    /**
     * @var null|string
     */
    private $barcode = null;

    /**
     * @var string
     */
    private $entrypoint;

    /**
     * Scraper constructor.
     * @param Client|null $client
     * @param null $entrypoint
     */
    public function __construct(Client $client = null, $entrypoint = null)
    {
        $this->client = $client ?: new Client();
        $this->entrypoint = $entrypoint ?: 'https://www.gibertjeune.fr/recherche/?q=';
    }

    /**
     * @param mixed $barcode
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;
    }

    /**
     * @return array
     */
    public function getProduct()
    {
        if (!$this->barcode) {
            throw new \InvalidArgumentException(sprintf('Parameter barcode is missing.'));
        }

        $resource = $this->createResource();
        $crawler = $this->client->request('GET', $resource);

        $product = $crawler->filter('.product-offers .col-md-4')->each(function (Crawler $node) {


            $titleNode = $node->filter('.yellow-box');
            $title = $this->formatTitle($titleNode->text());

            $prices = $node->filter('li')->each(function (Crawler $nodeCol) {

                $priceNode = $nodeCol->filter('strong');
                $priceText = $priceNode->text();

                $stateNode = $nodeCol->filter('.uppercase');
                $state = $stateNode->text();
                $price = $this->formatPrice($priceText);

                return [
                    'state' => $state,
                    'price' => $price
                ];
            });

            return [
                'title' => $title,
                'prices' => $prices
            ];
        });

        return $product;
    }

    /**
     * @return string
     */
    public function createResource()
    {
        return $this->entrypoint . $this->barcode;
    }

    /**
     * @param $priceText
     * @return float
     */
    public function formatPrice($priceText)
    {
        $price = str_replace([',', '€'], ['.', ''], $priceText);

        return (float)trim($price);
    }

    /**
     * @param $text
     * @return string
     */
    public function formatTitle($text)
    {
        $text = trim(str_replace("\n", '', $text));
        return $text;
    }
}