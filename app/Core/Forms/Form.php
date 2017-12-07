<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 14.11.2017
 * Time: 22:04
 */

namespace NTSchool\Phpblog\Core\Forms;


use NTSchool\Phpblog\Core\Http\Request;

abstract class Form
{
    /**
     * @var
     */
    public $form_name;

    /**
     * @var
     */
    protected $action;

    /**
     * @var
     */
    protected $method;

    /**
     * @var
     */
    protected $fields;

    /**
     * @var
     */
    protected $values;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->form_name;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action();
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return \ArrayIterator
     */
    public function getFields()
    {
        return new \ArrayIterator($this->fields);
    }

    /**
     * @param \NTSchool\Phpblog\Core\Http\Request $request
     *
     * @return array
     */
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

    /**
     * @return string
     */
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

    /**
     * @param array $errors
     */
    public function addErrors(array $errors)
    {
        foreach($this->fields as $key => $field) {
            $name = $field['name'] ?? null;
            if(isset($errors[$name])){
                $this->fields[$key]['errors'] = $errors[$name];
            }
        }
    }

    /**
     * @param array $params
     *
     * @return bool
     */
    public function saveValues(array $params)
    {
        if(!empty($params)){
            foreach($params as $key => $value){
                $this->values[$key] = $value;
            }
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getValues()
    {
        return $this->values;
    }
}