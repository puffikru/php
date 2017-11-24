<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 24.11.2017
 * Time: 3:32
 */

namespace NTSchool\Phpblog\Forms;


use NTSchool\Phpblog\Core\Forms\Form;

class AddText extends Form
{
    public function __construct()
    {
        $this->fields = [
            [
                'name' => 'alias',
                'type' => 'text',
                'placeholder' => 'Введите алиас',
                'label' => 'Название',
                'tag' => 'input'
            ],
            [
                'name' => 'content',
                'placeholder' => 'Введите текст',
                'label' => 'Контент',
                'tag' => 'textarea'
            ],
            [
                'type' => 'submit',
                'value' => 'Добавить',
                'tag' => 'input'
            ]
        ];

        $this->form_name = 'add-text';
        $this->method  = 'POST';
    }
}