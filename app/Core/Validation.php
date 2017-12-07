<?php

namespace NTSchool\Phpblog\Core;

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
                $this->errors[$k] = "Заполните поле!";
            }elseif(isset($this->rules['min_length'][$k]) && $this->minLength($value, $k)) {
                $this->errors[$k] = "Длина поля $k не может быть меньше {$this->rules['min_length'][$k]} символов!";
            }else {
                $this->clean[$k] = $value;
            }
        }

        if(isset($obj['answer']) && $this->validateCaptcha($obj) == false) {
            $this->errors['answer'] = "Капча введена неверно!";
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

    public function validateCaptcha(array $obj)
    {
        if(isset($obj['randStr'])) {
            return $obj['randStr'] === $obj['answer'];
        }

        return false;
    }

}