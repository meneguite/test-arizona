<?php

namespace Xuplau\Test\Functional;

use Xuplau\Test\TestCase;

class HomePageTest extends TestCase
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

    public function testIfExistLinkForViewCountries()
    {

        $crawler = $this->client->request('GET', '/');

        $actionLink = $crawler->filter('.actions a.show-countries-view')->first()->attr('href');

        $this->assertEquals('/countries', $actionLink);
    }

    public function testIfExistLinkForCsvCountries()
    {

        $crawler = $this->client->request('GET', '/');

        $actionLink = $crawler->filter('.actions a.show-countries-csv')->first()->attr('href');

        $this->assertEquals('/countries/csv', $actionLink);
    }

    public function testIfExistLinkForJsonCountries()
    {

        $crawler = $this->client->request('GET', '/');

        $actionLink = $crawler->filter('.actions a.show-countries-json')->first()->attr('href');

        $this->assertEquals('/countries/json', $actionLink);
    }

}
