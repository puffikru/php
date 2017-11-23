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
        foreach($this->form->getFields() as $field) {

            if($field['tag'] === 'input') {
                $inputs[] = $this->input($field);
            }elseif($field['tag'] === 'textarea'){
                $label = $field['label'] . ':' ?? '';
                $span = (new PairTag('span'))->html($label)->render();
                $textarea = (new PairTag('textarea'))->attr('name', 'content')->attr('placeholder', $field['placeholder'])->attr('rows', '8')->render();
                $tag_label = (new PairTag('label'))->attr('class', 'textarea')->html($span . $textarea)->render();
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

    public function input(array $attributes)
    {
        $errors = '';

        if(isset($attributes['errors'])) {
            $class = $attributes['class'] ?? '';
            $attributes['class'] = trim(sprintf('%s error', $class));
            $errors = $attributes['errors'];
            unset($attributes['errors']);
            //$errors = '<div>' . implode('</div><div>', $errors) . '</div>';
            $errors = '<div class="login-error">' . $errors . '</div>';
        }
        $label = '';
        if(isset($attributes['label'])){
            $label = $attributes['label'] . ':' ?? '';
            unset($attributes['label']);
        }
        unset($attributes['tag']);

        return sprintf('<label><span>%s</span><input %s></label>%s', $label, $this->buildAttributes($attributes), $errors);
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