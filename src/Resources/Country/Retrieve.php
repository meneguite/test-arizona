<?php
/**
 * This file is part of api silex skeleton
 *
 * PHP version 7
 *
 * @category  PHP
 * @package   Xuplau
 * @author    Ivan Rosolen <ivanrosolen@gmail.com>
 * @author    William Espindola <oi@williamespindola.com.br>
 * @copyright 2016 Xuplau
 * @license   MIT
 * @link      https://github.com/ivanrosolen/api-silex-skeleton
 */

namespace Xuplau\Resources\Country;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Xuplau\Services\CountryService;

/**
 * Resource that list users
 *
 * @version 1.0.0
 *
 * @package Xuplau\Resources\Country
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 * @author  Ronaldo Meneguite <ronaldo@fireguard.com.br>
 */
class Retrieve
{
    protected $urlData = 'https://gist.githubusercontent.com/ivanrosolen/f8e9e588adf0286e341407aca63b5230/raw/99e205ea104190c5e09935f06b19c30c4c0cf17e/country';

    /**
     * Invokes route
     *
     * @param Application $application Application instance
     * @param string $format
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke( Application $application, $format )
    {
        $countries = $this->getListCountries($application);

        return $this->getResultForFormat($application, $countries, $format);
    }

    protected function getResultForFormat( Application $application, array $countries, $format )
    {
        switch ($format) {
            case 'view' :
                return $this->getResultView($application, $countries);
            case 'json' :
                return $this->getResultJson($application, $countries);
            case 'csv' :
                return 'csv';
            default:
                return $application->json('Invalid Format');
        }
    }

    protected function getResultView( Application $application, array $countries ) {
        return $application['twig']->render('countries/list.twig', [
            'countries' => $countries,
        ]);
    }

    protected function getResultJson( Application $application, array $countries )
    {
        return $application->json( $this->formatArrayCountries($countries) );
    }

    protected function formatArrayCountries(array $countries)
    {
        $formattedCountries = [];
        foreach ($countries as $countryCode => $countryName) {
            $formattedCountries[] = ['CountryCode' => $countryCode, 'CountryName' => $countryName];
        }
        return $formattedCountries;
    }

    /**
     * @param Application $application
     * @return array|mixed
     */
    protected function getListCountries( Application $application )
    {
        if ( $countries = $application['cache']->fetch('countries') ) {
            return json_decode($countries, true);
        }
        return $this->getRemoteListForCountries($application);
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
        asort($result);
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
