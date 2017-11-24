<?php

namespace model;


class Texts extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'texts';
        $this->pk = 'id_text';
    }

    public function getTexts()
    {
        $query = $this->db->query("SELECT * FROM {$this->table}");
        $texts = [];
        while($row = $query->fetch()) {
            $texts[$row['title']] = $row['content'];
        }
        return $texts;
    }

    public function validationMap(){
        return [
            'fields' => ['title', 'content'],
            'not_empty' => ['title', 'content']
        ];
    }

}