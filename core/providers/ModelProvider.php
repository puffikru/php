<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 23.11.2017
 * Time: 0:28
 */

namespace core\providers;


use core\ServiceContainer;
use model\Messages;
use model\Sessions;
use model\Texts;
use model\Users;

class ModelProvider implements ProviderInterface
{
    public function register(ServiceContainer &$container)
    {
        $container->register('model.post', function(){
            return new Messages();
        });

        $container->register('model.user', function(){
            return new Users();
        });

        $container->register('model.session', function(){
            return new Sessions();
        });

        $container->register('model.texts', function(){
            return new Texts();
        });
    }
}