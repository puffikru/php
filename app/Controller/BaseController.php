<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 25.09.17
 * Time: 2:34
 */

namespace NTSchool\Phpblog\Controller;


use NTSchool\Phpblog\Core\Exceptions\Error404;
use NTSchool\Phpblog\Core\Request;
use NTSchool\Phpblog\Core\ServiceContainer;


class BaseController
{
    protected $title = '';
    protected $content = '';
    protected $menu;
    protected $sidebar;
    protected $texts;

    protected $request;
    protected $container;

    public function __construct(Request $request, ServiceContainer $container)
    {
        $this->request = $request;
        $this->container = $container;
    }

    public function __call($name, $arguments)
    {
        throw new Error404("Undefined action $name");
    }

    public function render()
    {
        echo $this->build('v_main', ['title' => $this->title, 'content' => $this->content, 'menu' => $this->menu, 'sidebar' => $this->sidebar, 'texts' => $this->texts]);
    }

    public function redirect($dest){
        header('Location:' . $dest);
    }

    protected function build($fname, $params = [])
    {
        extract($params);

        ob_start();
        include "app/View/$fname.php";
        return ob_get_clean();
    }
}