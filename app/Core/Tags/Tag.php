<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 15.11.2017
 * Time: 3:47
 */

namespace NTSchool\Phpblog\Core\Tags;


abstract class Tag
{
    /**
     * @var
     */
    protected $name;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var string
     */
    protected $pattern = "<%name% %attr%>";

    /**
     * Tag constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return $this
     */
    public function attr($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function render()
    {
        $tag = str_replace('%name%', $this->name, $this->pattern);
        $pairs = [];
        if(count($this->attributes) === 0){
            $str_pair = '';
        }else{
            foreach($this->attributes as $key => $value){
                $pairs[] = "$key=\"$value\"";
            }

            $str_pair = ' ' . implode(' ', $pairs);
        }

        $tag = str_replace('%attr%', $str_pair, $tag);

        return $tag;
    }
}