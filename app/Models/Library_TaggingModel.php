<?php

namespace App\Models;

use CodeIgniter\Model;

class Library_TaggingModel extends Model
{
    protected $table            = 'library_tagging';
    protected $primaryKey       = 'tag_id';
    protected $useAutoIncrement = true; // not marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'library_file_id',
        'keyword_id',
    ];


}