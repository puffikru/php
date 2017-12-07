<?php

namespace NTSchool\Phpblog\Model;


class Texts extends BaseModel
{
    /**
     * Texts constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = 'texts';
        $this->pk = 'id_text';
    }

    /**
     * @return array
     */
    public function getTexts()
    {
        $query = $this->db->query("SELECT * FROM {$this->table}");
        $texts = [];
        while($row = $query->fetch()) {
            $texts[$row['alias']] = $row['content'];
        }
        return $texts;
    }

    /**
     * @return array
     */
    public function validationMap(){
        return [
            'fields' => ['alias', 'content'],
            'not_empty' => ['alias', 'content']
        ];
    }

}