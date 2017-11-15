<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 15.11.2017
 * Time: 3:57
 */

namespace tags;


class PairTag extends Tag
{
    protected $inner_html;

    public function __construct($name)
    {
        parent::__construct($name);
        $this->pattern .= '%html%</%name%>';
    }

    public function html($str){
        $this->inner_html = $str;
    }
}