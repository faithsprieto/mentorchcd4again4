<?php

namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model
{
    protected $table            = 'subject';
    protected $primaryKey       = 'subject_id';
    protected $useAutoIncrement = false; // not marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'subject_tag',
    ];

    protected $useTimestamps = true;
}