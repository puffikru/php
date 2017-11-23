<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 14.11.2017
 * Time: 22:36
 */

namespace core\Forms;


use core\tags\PairTag;

class FormBuilder
{
    public $form;

    public function __construct(Form &$form)
    {
        $this->form = $form;
    }

    public function method()
    {
        $method = $this->form->getMethod();

        if($method === null) {
            $method = 'GET';
        }

        return sprintf('method=%s', $method);
    }

    public function fields()
    {
        $inputs = [];
        foreach($this->form->getFields() as $field) {

            if($field['tag'] === 'input') {
                $inputs[] = $this->input($field, $this->form->getValues()['title']);
            }elseif($field['tag'] === 'textarea'){

                $tag_label = $this->textArea($field);
                if(isset($field['errors'])){
                    $errors = $field['errors'];
                    unset($field['errors']);
                    $errors = '<div class="login-error">' . $errors . '</div>';
                    $inputs[] = $tag_label . $errors;
                }else {
                    $inputs[] = $tag_label;
                }
            }

        }

        return $inputs;
    }

    public function input(array $attributes, $value = '')
    {
        $errors = '';

        if(isset($attributes['errors'])) {
            $class = $attributes['class'] ?? '';
            $attributes['class'] = trim(sprintf('%s error', $class));
            $errors = $attributes['errors'];
            unset($attributes['errors']);

            $errors = '<div class="login-error">' . $errors . '</div>';
        }
        $label = '';
        if(isset($attributes['label'])){
            $label = $attributes['label'] . ':' ?? '';
            unset($attributes['label']);
        }
        unset($attributes['tag']);

        if($attributes['type'] !== 'submit' && $attributes['type'] !== 'hidden') {
            $attributes['value'] = $value;
        }

        return sprintf('<label><span>%s</span><input %s></label>%s', $label, $this->buildAttributes($attributes), $errors);
    }

    public function textArea($field)
    {
        $label = $field['label'] . ':' ?? '';

        $span = (new PairTag('span'))->html($label)->render();

        $textarea = (new PairTag('textarea'))->attr('name', 'content')->attr('placeholder', $field['placeholder'])->attr('rows', '8')->html($this->form->getValues()['content'])->render();

        return $tag_label = (new PairTag('label'))->attr('class', 'textarea')->html($span . $textarea)->render();
    }

    public function inputSign()
    {
        return $this->input([
            'type' => 'hidden',
            'name' => 'sign',
            'value' => $this->form->getSign()
        ]);
    }

    public function buildAttributes(array $attributes)
    {
        $arr = [];
        foreach($attributes as $attribute => $value) {
            $arr[] = sprintf('%s="%s"', $attribute, $value);
        }

        return implode(' ', $arr);
    }

}