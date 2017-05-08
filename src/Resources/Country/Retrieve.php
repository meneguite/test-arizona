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


        return $application->json($countries);
    }


    /**
     * @param Application $application
     * @return array|mixed
     */
    protected function getListCountries(Application $application )
    {
        if ( $countries = $application['cache']->fetch('countries') ) {
            return json_decode($countries);
        }
        return $this->getRemoteListForCountries($application);
    }

    /**
     * @param Application $application
     * @return array
     */
    protected function getRemoteListForCountries( Application $application )
    {
        $countries = [];
        $this->storeListForCountries($application, $countries);
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
