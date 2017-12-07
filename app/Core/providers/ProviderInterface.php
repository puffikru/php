<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 23.11.2017
 * Time: 0:31
 */

namespace NTSchool\Phpblog\Core\providers;


use NTSchool\Phpblog\Core\ServiceContainer;

Interface ProviderInterface
{
    /**
     * @param \NTSchool\Phpblog\Core\ServiceContainer $container
     *
     * @return mixed
     */
    public function register(ServiceContainer &$container);
}