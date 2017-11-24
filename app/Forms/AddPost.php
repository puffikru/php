<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 23.11.2017
 * Time: 6:20
 */

namespace NTSchool\Phpblog\Forms;

use NTSchool\Phpblog\Core\Forms\Form;

class AddPost extends Form
{
    public function __construct()
    {
        $this->fields = [
            [
                'name' => 'title',
                'type' => 'text',
                'placeholder' => 'Введите заголовок',
                'label' => 'Название',
                'tag' => 'input'
            ],
            [
                'name' => 'content',
                'placeholder' => 'Введите содержание новости',
                'label' => 'Контент',
                'tag' => 'textarea'
            ],
            [
                'name' => 'img',
                'type' => 'file',
                'label' => 'Загрузить изображение',
                'tag' => 'input'
            ],
            [
                'type' => 'submit',
                'value' => 'Отправить',
                'tag' => 'input'
            ]
        ];

        $this->form_name = 'add-post';
        $this->method  = 'POST';
    }
}