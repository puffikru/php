<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 23.11.2017
 * Time: 0:31
 */

namespace core\providers;


use core\ServiceContainer;

Interface ProviderInterface
{
    public function register(ServiceContainer &$container);
}