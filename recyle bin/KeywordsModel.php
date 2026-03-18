<?php

namespace App\Models;

use CodeIgniter\Model;

class KeywordsModel extends Model
{
    protected $table            = 'keywords';
    protected $primaryKey       = 'keyword_id';
    protected $useAutoIncrement = false;

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'keyword_tag',
    ];

    

}
