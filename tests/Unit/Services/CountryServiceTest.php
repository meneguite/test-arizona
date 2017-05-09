<?php

namespace Xuplau\Test\Unit\Services;



use Symfony\Component\DomCrawler\Crawler;
use Xuplau\Application;
use Xuplau\Services\CountryService;
use Xuplau\Test\TestCase;

class CountryServiceTest extends TestCase
{
    /**
     * @var CountryService
     */
    protected $service;

    /**
     * @var Application
     */
    protected $app;

    public function setUp()
    {
        parent::setUp();
        $this->service = new CountryService($this->app);
    }

    public function testGetListCountries()
    {
        $list = $this->service->getListCountries();

        $this->assertArrayHasKey('AL', $list);

        $this->assertEquals($list['AL'], 'Albania');
    }

    public function testIfSaveCacheForGetListCountries()
    {
        $list = $this->service->getListCountries();

        $cachedList = json_decode($this->app['cache']->fetch('countries'), true);

        $this->assertEquals($list, $cachedList);
    }

    public function testGetListCountriesWithoutCache()
    {
        $this->app['cache']->clear();

        $list = $this->service->getListCountries();

        $this->assertArrayHasKey('AL', $list);

        $this->assertEquals($list['AL'], 'Albania');
    }

    public function testGetListCountriesForView()
    {
        $list = $this->service->getListCountries();

        $html = $this->service->getResponseForFormat($list, 'view');

        $crawler = new Crawler($html);

        $this->assertTrue(
            $crawler->filterXPath('descendant-or-self::tbody/tr')->count() > 1,
            'A number greater than one of the records in the table was expected'
        );
    }

    public function testGetListCountriesForCsv()
    {
        $list = $this->service->getListCountries();

        $csv = $this->service->getResponseForFormat($list, 'csv');

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\StreamedResponse::class, $csv);

        $this->assertEquals('text/csv', $csv->headers->get('Content-Type'));

        ob_start();
            $csv->sendContent();
            $content = ob_get_contents();
        ob_end_clean();

        $this->assertContains('AQ,Antarctica', $content);
    }

    public function testGetListCountriesForJson()
    {
        $list = $this->service->getListCountries();

        $json = $this->service->getResponseForFormat($list, 'json');

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\JsonResponse::class, $json);

        $this->assertEquals('application/json', $json->headers->get('Content-Type'));

        $data = json_decode($json->getContent(), true);

        $this->assertTrue(count($data) > 1, 'A number larger than one was expected in the result' );

        $this->assertArrayHasKey('AL', $data);
    }

    public function testGetListCountriesForInvalidFormat()
    {
        $list = $this->service->getListCountries();

        $result = $this->service->getResponseForFormat($list, 'invalid-format');

        $this->assertEquals('"Invalid Format"', $result->getContent());
    }


}
