<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 05.12.2017
 * Time: 18:18
 */

namespace NTSchool\Phpblog\Core\providers;


use NTSchool\Phpblog\Core\Http\Session;
use NTSchool\Phpblog\Core\ServiceContainer;

class SessionProvider implements ProviderInterface
{
    /**
     * @param \NTSchool\Phpblog\Core\ServiceContainer $container
     */
    public function register(ServiceContainer &$container)
    {
        $container->register('http.session', function(){
            return Session::instance();
        });
    }
}