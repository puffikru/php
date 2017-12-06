<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 14.11.2017
 * Time: 22:04
 */

namespace NTSchool\Phpblog\Core\Forms;


use NTSchool\Phpblog\Core\Request;

abstract class Form
{
    protected $form_name;
    protected $action;
    protected $method;
    protected $fields;
    protected $values;

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

        foreach($this->getFields() as $key => $field) {
            if(!isset($field['name'])) {
                continue;
            }

            $name = $field['name'];

            if($request->post()->get($name) !== null) {
                $this->fields[$key]['value'] = $request->post()->get($name);
                $fields[$name] = $request->post()->get($name);
            }
        }

        if($request->post()->get('sign') !== null && $this->getSign() !== $request->post()->get('sign')) {
            die('Формы не совпадают!');
        }

        if($request->post()->get('remember') !== 'on'){
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

    public function saveValues(array $params)
    {
        if(!empty($params)){
            foreach($params as $key => $value){
                $this->values[$key] = $value;
            }
        }

        return true;
    }

    public function getValues()
    {
        return $this->values;
    }
}