<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 23.11.2017
 * Time: 0:28
 */

namespace core\providers;

use core\ServiceContainer;

class ModelProvider implements ProviderInterface
{
    public function register(ServiceContainer &$container)
    {
        $container->register('models', function($name){
            $model = 'model\\' . $name;
            return new $model();
        });
    }
}