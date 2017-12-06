<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 06.12.2017
 * Time: 6:52
 */

namespace NTSchool\Phpblog\Controller;


class PageController extends BaseController
{
    public function error($e = '')
    {
        $this->title = 'Ошибка';
        $this->sidebar = $this->build('v_left');
        $this->texts = $this->container->get('models', 'Texts')->getTexts() ?? null;
        $this->content = $this->build('v_error', ['errorMessage' => $e->getMessage(), 'errorStackTrace' => $e->getTraceAsString(), 'dev' => true]);
    }
}