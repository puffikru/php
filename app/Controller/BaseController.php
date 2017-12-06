<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 25.09.17
 * Time: 2:34
 */

namespace NTSchool\Phpblog\Controller;


use NTSchool\Phpblog\Core\Exceptions\Error404;
use NTSchool\Phpblog\Core\Http\Response;
use NTSchool\Phpblog\Core\Http\Request;
use NTSchool\Phpblog\Core\ServiceContainer;


class BaseController
{
    protected $title = '';
    protected $content = '';
    protected $menu;
    protected $sidebar;
    protected $texts;

    protected $request;
    protected $response;
    protected $container;

    public function __construct(Request $request, Response $response, ServiceContainer $container)
    {
        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
    }

    public function __call($name, $arguments)
    {
        throw new Error404("Undefined action $name");
    }

    public function staticAction($message)
    {
        $this->content = $message;
    }

    public function render()
    {
        echo $this->build('v_main', ['title' => $this->title, 'content' => $this->content, 'menu' => $this->menu, 'sidebar' => $this->sidebar, 'texts' => $this->texts]);
    }

    protected function build($fname, $params = [])
    {
        extract($params);

        ob_start();
        include "app/View/$fname.php";
        return ob_get_clean();
    }

    public function getFullTemplate()
    {
        return $this->build(
            'v_main',
            [
                'title' => $this->title,
                'content' => $this->content,
                'menu' => $this->menu,
                'sidebar' => $this->sidebar,
                'texts' => $this->texts
            ]
        );
    }
}