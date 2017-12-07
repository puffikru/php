<?php

namespace NTSchool\Phpblog\Core;

class Validation
{
    /**
     * @var array
     */
    protected $clean = [];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @param $obj
     */
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

    /**
     * @param $rules
     *
     * @return mixed
     */
    public function setRules($rules)
    {
        return $this->rules = $rules;
    }

    /**
     * @param $obj
     * @param $rule
     *
     * @return bool
     */
    private function minLength($obj, $rule): bool
    {
        $length = mb_strlen($obj, CHARSET) < $this->rules['min_length'][$rule] ? true : false;
        return $length;
    }

    /**
     * @return bool
     */
    public function success()
    {
        return count($this->errors) == 0;
    }

    /**
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function clean()
    {
        return $this->clean;
    }

    /**
     * @param array $obj
     *
     * @return bool
     */
    public function validateCaptcha(array $obj)
    {
        if(isset($obj['randStr'])) {
            return $obj['randStr'] === $obj['answer'];
        }

        return false;
    }

}