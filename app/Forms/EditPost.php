<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 23.11.2017
 * Time: 12:17
 */

namespace NTSchool\Phpblog\Forms;


use NTSchool\Phpblog\Core\Forms\Form;

class EditPost extends Form
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
                'type' => 'submit',
                'value' => 'Сохранить',
                'tag' => 'input'
            ]
        ];

        $this->form_name = 'edit-post';
        $this->method  = 'POST';
    }
}