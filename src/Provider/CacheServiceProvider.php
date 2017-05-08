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

namespace Xuplau\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Xuplau\Validation\Rules\UserCreateInput;
use Xuplau\Validation\Rules\UserUpdateInput;
use Xuplau\Validation\Rules\UserDeleteInput;
use Xuplau\Validation\Rules\LoginInput;
use Xuplau\Validation\Rules\AuthRenewInput;

/**
 * Serivice to provide all validators for the application
 *
 * @version 1.0.0
 *
 * @package Xuplau\Provider
 * @author  Ivan Rosolen <ivanrosolen@gmail.com>
 * @author  William Espindola <oi@williamespindola.com.br>
 * @author  Ronaldo Meneguite <ronaldo@fireguard.com.br>
 *
 */
class CacheServiceProvider implements ServiceProviderInterface
{
    /**
     * Register all validators
     *
     * @param Container $container Container instance
     * @return Void
     */
    public function register(Container $container)
    {
        $container->register(new \Moust\Silex\Provider\CacheServiceProvider(), array(
            'cache.options' => array(
                'driver'    => 'file',
                'cache_dir' => './../data/cache'
            )
        ));
    }

    /**
     * Boot
     *
     * @param Container $container Container instance
     * @return Void
     */
    public function boot(Container $container)
    {
        // Nothing here
    }
}
