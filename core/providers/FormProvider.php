<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 24.11.2017
 * Time: 5:49
 */

namespace core\providers;


use core\Forms\FormBuilder;
use core\ServiceContainer;

class FormProvider implements ProviderInterface
{
    public function register(ServiceContainer &$container)
    {
        $container->register('formbuilder', function($name){
            $form = new $name();
            return new FormBuilder($form);
        });

    }
}