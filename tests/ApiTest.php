<?php

namespace UrbanComics\tests;

use Goutte\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;

use GibertJeune\Api;

class ScraperTest extends \PHPUnit_Framework_TestCase
{
    private $client;

    public function setUp()
    {
        $fixtures = file_get_contents(__DIR__ . '/fixtures/product.html');

        $response = new Response(200, [], $fixtures);
        $mock     = new MockHandler([$response]);

        $handler      = HandlerStack::create($mock);
        $guzzleClient = new \GuzzleHttp\Client(['handler' => $handler]);

        $this->client = new Client();
        $this->client->setClient($guzzleClient);
    }

    public function testScraperWithInvalidParameters()
    {
        $this->expectException(InvalidArgumentException::class);

        $api = new Api($this->client);

        $api->getProduct();
    }

    public function testScraper()
    {
        $api = new Api($this->client);
        $api->setBarcode('9782344009505');

        $product = $api->getProduct();

        $mustReturn = [
            'prices' => [
                0 => [
                    'title'  => 'Réservation',
                    'prices' => [
                        0 => [
                            'state' => 'Neuf',
                            'price' => 0.0
                        ],
                        1 => [
                            'state' => 'Occasion',
                            'price' => 0.0
                        ]
                    ]
                ],
                1 => [
                    'title'  => 'Expédition',
                    'prices' => [
                        0 => [
                            'state' => 'Neuf',
                            'price' => 22.5
                        ],
                        1 => [
                            'state' => 'Occasion',
                            'price' => 0.0
                        ]
                    ]
                ],
                2 => [
                    'title'  => 'E-Book',
                    'prices' => [
                        0 => [
                            'state' => 'Numérique',
                            'price' => 0.0
                        ]
                    ]
                ]
            ],
            'shops'  => [
                'secondhand' => [],
                'new'        => [],
            ]
        ];

        $this->assertSame($mustReturn, $product);
    }
}