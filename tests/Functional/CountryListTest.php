<?php

namespace Xuplau\Test\Functional;


use Xuplau\Test\TestCase;

class CountryListTest extends TestCase
{
    /**
     * @var \Symfony\Component\BrowserKit\Client
     */
    protected $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = $this->createClient();
    }

    public function testListCountriesView()
    {
        $crawler = $this->client->request('GET', '/countries');

        $this->assertTrue(
            $crawler->filter('tbody > tr')->count() > 1,
            'A number greater than one of the records in the table was expected'
        );

        $this->assertTrue($crawler->filter('tbody > tr > td:contains("Afghanistan")')->count() === 1);
    }

    public function testListCountriesCsv()
    {
        $client = static::createClient();

        $client->request('GET', '/countries/csv');

        $this->assertContains('text/csv', $client->getResponse()->headers->get('Content-Type'),
            'the "Content-Type" header is "text/csv"'
        );

        // TODO Add Test for StreamedResponse
        //$this->assertContains('Afghanistan', $response);
    }

    public function testListCountriesJson()
    {
        $client = static::createClient();

        $client->request('GET', '/countries/json');

        $this->assertEquals('application/json', $client->getResponse()->headers->get('Content-Type'),
            'the "Content-Type" header is "application/json"'
        );


        $this->assertContains('Afghanistan', $client->getResponse()->getContent());
    }

}
