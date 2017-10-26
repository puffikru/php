<?php

namespace core;

class Validation
{
    protected $clean = [];
    protected $errors = [];
    protected $rules = [];

    public function execute($obj)
    {
        foreach($obj as $k => $v) {
            $value = trim(strip_tags($v));

            if(in_array($k, $this->rules['not_empty']) && $value == '') {
                $this->errors[] = "Заполните поле $k!";
            }elseif(isset($this->rules['min_length'][$k]) && $this->minLength($value, $k)) {
                $this->errors[] = "Длина поля $k не может быть меньше {$this->rules['min_length'][$k]}";
            }else {
                $this->clean[$k] = $value;
            }
        }
    }

    public function setRules($rules)
    {
        return $this->rules = $rules;
    }

    private function minLength($obj, $rule): bool
    {
        $length = mb_strlen($obj, CHARSET) < $this->rules['min_length'][$rule] ? true : false;
        return $length;
    }

    public function success()
    {
        return count($this->errors) == 0;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function clean()
    {
        return $this->clean;
    }

}