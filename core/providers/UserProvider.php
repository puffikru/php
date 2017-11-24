<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 23.11.2017
 * Time: 0:41
 */

namespace core\providers;

use core\ServiceContainer;
use core\User;

class UserProvider implements ProviderInterface
{
    public function register(ServiceContainer &$container)
    {
        $container->register('service.user', function($request) use ($container){
            return new User(
                $container->get('models', 'Users'),
                $container->get('models', 'Sessions'),
                $request
            );
        });
    }
}