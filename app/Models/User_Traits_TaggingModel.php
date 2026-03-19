<?php

namespace App\Models;

use CodeIgniter\Model;

class User_Traits_TaggingModel extends Model
{
    protected $table            = 'user_traits_tagging';
    protected $primaryKey       = 'trait_id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'student_id',
        'keyword_id',
        'trait_type',
        'created_at',
        'is_deleted',
    ];

    protected $useTimestamps = true;
}