<?php

namespace App\Models;

use CodeIgniter\Model;

class Subject_TaggingModel extends Model
{
    protected $table            = 'subject_tagging';
    protected $primaryKey       = 'tag_id';
    protected $useAutoIncrement = true; // not marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'subject_id',
        'keyword_id',
    ];

 
}