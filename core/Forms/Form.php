<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 14.11.2017
 * Time: 22:04
 */

namespace core\Forms;


use core\Request;

abstract class Form
{
    protected $form_name;
    protected $action;
    protected $method;
    protected $fields;

    public function getName()
    {
        return $this->form_name;
    }

    public function getAction()
    {
        return $this->action();
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getFields()
    {
        return new \ArrayIterator($this->fields);
    }

    public function handleRequest(Request $request)
    {
        $fields = [];

        foreach($this->getFields() as $field) {
            if(!isset($field['name'])) {
                continue;
            }

            $name = $field['name'];

            if($request->post($name) !== null) {
                $fields[$name] = $request->post($name);
            }
        }

        if($request->post('sign') !== null && $this->getSign() !== $request->post('sign')) {
            die('Формы не совпадают!');
        }

        if($request->post('remember') !== 'on'){
            unset($fields['remember']);
        }

        return $fields;
    }

    public function getSign()
    {
        $string = '';
        foreach($this->getFields() as $field) {
            if(isset($field['name'])) {
                $string .= FORM_SIGN . $field['name'];
            }
        }

        return md5($string);
    }

    public function addErrors(array $errors)
    {
        foreach($this->fields as $key => $field) {
            $name = $field['name'] ?? null;
            if(isset($errors[$name])){
                $this->fields[$key]['errors'] = $errors[$name];
            }
        }
    }
}