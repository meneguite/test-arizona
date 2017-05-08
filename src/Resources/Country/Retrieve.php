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

/**
 * Resource that list users
 *
 * @version 1.0.0
 *
 * @package Xuplau\Resources\Country
 * @author Ronaldo Meneguite <ronaldo@fireguard.com.br>
 */
class Retrieve
{
    /**
     * Invokes route
     *
     * @param Application $application Application instance
     * @param Request $request Request instance
     * @param string $format
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke(
        Application $application,
        Request $request,
        $format = 'view'
    ) {

//        if (!is_null($page)) {
//            $qtd    = $application['apipagelimit'];
//            $page   = (!empty((int)$page)) ? $page : 1;
//            $offset = ($page == 1) ? '0' : ($page*$qtd)-$qtd;
//
//            $users = $application['user']->fetchPage($qtd, $offset);
//            // colocar rmm4 links
//
//            return $application->json($users);
//        }
//
//        $users = $application['user']->fetchAll($qtd, $offset);
//        // colocar rmm4 links

        return $application->json($format);
    }
}
