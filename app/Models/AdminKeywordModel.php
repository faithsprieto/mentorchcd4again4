<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminKeywordModel extends Model
{

    public function getKeywords()
    {
        $sql = <<<SQL
        SELECT
            keyword_id,
            keyword_tag
        FROM admin_keywords
        SQL;

        return $this->db->query($sql)->getResult();
    }

    public function createKeyword($tag)
    {
        $sql = <<<SQL
        INSERT INTO admin_keywords
        (keyword_tag)
        VALUES (?)
        SQL;

        return $this->db->query($sql,[$tag]);
    }

}