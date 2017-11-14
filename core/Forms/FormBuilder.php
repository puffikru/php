<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 14.11.2017
 * Time: 22:36
 */

namespace core\Forms;


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

            $inputs[] = $this->input($field);

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
            $errors = '<div>' . implode('</div><div>', $errors) . '</div>';
        }

        $label = $attributes['label'] ?? null;

        return sprintf('%s <input %s>%s', $label, $this->buildAttributes($attributes), $errors);
    }

    public function inputSign()
    {
        return $this->input(['type' => 'hidden', 'name' => 'sign', 'value' => $this->form->getSign()]);
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