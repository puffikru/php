<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 18.10.17
 * Time: 20:14
 */

namespace model;


class Image extends BaseModel
{
    protected $file;
    protected $watermark = '';
    const JPG = 'jpg';
    const PNG = 'png';
    const GIF = 'gif';
    const BMP = 'bmp';
    const JPEG = 'jpeg';

    public function __construct($file, $watermark)
    {
        parent::__construct();
        $this->file = $file;
        $this->watermark = $watermark;
    }

    public function validationMap(){

    }

    public function canUpload(){
        if($this->file['name'] == ''){
            return 'Файл не выбран!';

        }elseif($this->file['size'] == 0){
            return 'Файл слишком большой!';
        }
        $getMime = explode('.', $this->file['name']);
        $mime = strtolower(end($getMime));
        $types = [self::JPG, self::PNG, self::GIF, self::BMP, self::JPEG];

        if(!in_array($mime, $types)){
            return 'Недопустимый тип файла!';
        }
        return true;
    }

    public function makeUpload(){
        $image_info = getimagesize($this->file['tmp_name']);
        $watermark_info = getimagesize($this->watermark);

        $format = strtolower(substr($image_info['mime'], strpos($image_info['mime'], '/') + 1));

        $imCrFunc = 'imagecreatefrom' . $format;
        $imSaveFunc = 'image' . $format;

        $img = $imCrFunc($this->file['tmp_name']);

        $watermark = imagecreatefrompng($this->watermark);

        $pos_x = ($image_info[0] - $watermark_info[0]) / 2;
        $pos_y = ($image_info[1] - $watermark_info[1]) / 2;

        imagecopy($img, $watermark, $pos_x, $pos_y, 0, 0, $watermark_info[0], $watermark_info[1]);

        $name = mt_rand(0, 10000) . $this->file['name'];
        $imSaveFunc($img, 'img/' . $name);
    }
}