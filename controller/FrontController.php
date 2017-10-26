<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 25.09.17
 * Time: 2:34
 */

namespace controller;


use core\Exceptions\Error404;
use core\Request;


class FrontController
{
    protected $title = '';
    protected $content = '';
    protected $menu;
    protected $sidebar;
    protected $texts;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __call($name, $arguments)
    {
        throw new Error404("Undefined action $name");
    }

    public function render()
    {
        echo $this->build('v_main', ['title' => $this->title, 'content' => $this->content, 'menu' => $this->menu, 'sidebar' => $this->sidebar, 'texts' => $this->texts]);
    }

    protected function build($fname, $params = [])
    {
        extract($params);

        ob_start();
        include "view/$fname.php";
        return ob_get_clean();
    }
}