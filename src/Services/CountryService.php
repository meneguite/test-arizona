<?php

namespace Xuplau\Services;


use Silex\Application;

class CountryService
{
    protected $urlData = 'https://gist.githubusercontent.com/ivanrosolen/f8e9e588adf0286e341407aca63b5230/raw/99e205ea104190c5e09935f06b19c30c4c0cf17e/country';

    /**
     * @var Application
     */
    protected $application;

    public function __construct( Application $application )
    {
        $this->application = $application;
    }


    /**
     * Return List for all Countries
     * @return array
     */
    public function getListCountries( )
    {
        if ( $countries = $this->application['cache']->fetch('countries') ) {
            return json_decode($countries, true);
        }
        return $this->getRemoteListForCountries($this->application);
    }

    /**
     * @param Application $application
     * @return array
     */
    protected function getRemoteListForCountries( Application $application )
    {
        $countries = $this->extractArrayCountriesForResult( file($this->urlData) );
        $this->storeListForCountries($application, $countries);
        return $countries;
    }


    /**
     * @param array $countries
     * @param $format
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function getResponseForFormat(array $countries, $format )
    {
        switch ($format) {
            case 'view' :
                return $this->getResultView($this->application, $countries);
            case 'json' :
                return $this->getResultJson($this->application, $countries);
            case 'csv' :
                return $this->getResultCsv($this->application, $countries);
            default:
                return $this->application->json('Invalid Format');
        }
    }

    /**
     * @param Application $application
     * @param array $countries
     * @return mixed
     */
    protected function getResultView(Application $application, array $countries ) {
        return $application['twig']->render('countries/list.twig', [
            'countries' => $countries,
        ]);
    }

    /**
     * @param Application $application
     * @param array $countries
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function getResultJson(Application $application, array $countries )
    {
        return $application->json( $countries );
    }

    /**
     * @param Application $application
     * @param array $countries
     * @return null|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function getResultCsv(Application $application, array $countries )
    {
        if ( empty($countries) ) return null;

        $stream = function() use ($countries) {
            $output = fopen('php://output', 'w');
            foreach ($countries as $countryCode => $countryName) {

                fputcsv($output, [$countryCode, $countryName]);
            }
            fclose($output);
        };

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment; filename="countries.csv"',
        ];

        return $application->stream($stream, 200, $headers);
    }

    /**
     * @param array $countries
     * @return array
     */
    protected function formatArrayCountries(array $countries)
    {
        $formattedCountries = [];
        foreach ($countries as $countryCode => $countryName) {
            $formattedCountries[] = ['CountryCode' => $countryCode, 'CountryName' => $countryName];
        }
        return $formattedCountries;
    }

    /**
     * @param array $lines
     * @return array
     */
    protected function extractArrayCountriesForResult(array $lines )
    {
        $countries = [];
        foreach ($lines as $lineNumber => $lineContent) {
            // Ignore first lines
            if ( in_array( $lineNumber, [0, 1, 2] ) ) continue;

            $tmpCountries = explode('   ', $lineContent);
            $countries[$tmpCountries[0]] = ($tmpCountries[1]) ? rtrim($tmpCountries[1]) : '';
        }
        asort($countries);
        return $countries;
    }

    /**
     * @param Application $application
     * @param array $countries
     */
    protected function storeListForCountries( Application $application, array $countries )
    {
        $application['cache']->store('countries', json_encode($countries));
    }
}
