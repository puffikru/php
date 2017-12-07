<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 23.11.2017
 * Time: 0:28
 */

namespace NTSchool\Phpblog\Core\providers;

use NTSchool\Phpblog\Core\ServiceContainer;

class ModelProvider implements ProviderInterface
{
    /**
     * @param \NTSchool\Phpblog\Core\ServiceContainer $container
     */
    public function register(ServiceContainer &$container)
    {
        $container->register('models', function($name){
            $model = 'NTSchool\Phpblog\Model\\' . $name;
            return new $model();
        });
    }
}