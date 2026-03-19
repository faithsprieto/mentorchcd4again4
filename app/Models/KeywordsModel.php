<?php

namespace App\Models;

use CodeIgniter\Model;

class KeywordsModel extends Model
{
    protected $table            = 'keywords';
    protected $primaryKey       = 'keyword_id';
    protected $useAutoIncrement = true; 

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'keyword_tag',
    ];

 
    // KEYWORDS
    public function getKeywords()
    {
        $sql = <<<SQL
        SELECT
            keyword_id,
            keyword_tag
        FROM keywords
        ORDER BY keyword_tag ASC
        SQL;

        return $this->db->query($sql)->getResult();
    }

    public function createKeyword($tag)
    {
        $sql = <<<SQL
        INSERT INTO keywords
        (keyword_tag)
        VALUES (?)
        SQL;

        return $this->db->query($sql, [$tag]);
    }
}