<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 15.11.2017
 * Time: 3:57
 */

namespace NTSchool\Phpblog\Core\Tags;


class PairTag extends Tag
{
    /**
     * @var
     */
    protected $inner_html;

    /**
     * PairTag constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        parent::__construct($name);
        $this->pattern .= '%html%</%name%>';
    }

    /**
     * @param $str
     *
     * @return $this
     */
    public function html($str){
        $this->inner_html = $str;
        return $this;
    }

    /**
     * @return mixed
     */
    public function render(){
        $str = parent::render();
        return str_replace('%html%', $this->inner_html, $str);
    }
}