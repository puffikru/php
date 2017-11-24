<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 25.11.2017
 * Time: 1:35
 */

namespace NTSchool\Phpblog\Core;


class Image
{
    protected $errors = [];
    protected $types = [];

    public function can_upload($file)
    {
        if(!$this->checkFile($file)){
            return false;
        }

        $this->types = ['jpg', 'png', 'gif', 'bmp', 'jpeg'];
        $mime = $this->getMimeType($file);

        if(!in_array($mime, $this->types)) {
            $this->errors[] = 'Недопустимый тип файла';
            return false;
        }

        return true;
    }

    public function make_upload($file)
    {
        $name = mt_rand(0, 10000) . $file['name'];
        copy($file['tmp_name'], 'public/images/' . $name);
    }

    public function checkFile($file)
    {
        if($file['name'] == '') {
            $this->errors[] = 'Вы не выбрали файл.';
            return false;
        }

        if($file['size'] == 0) {
            $this->errors[] = 'Файл слишком большой.';
            return false;
        }

        return true;
    }

    public function getMimeType($file)
    {
        $getMime = explode('.', $file['name']);

        return strtolower(end($getMime));
    }

    public function errors()
    {
        return $this->errors;
    }
}