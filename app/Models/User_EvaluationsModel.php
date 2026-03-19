<?php

namespace App\Models;

use CodeIgniter\Model;

class User_EvaluationsModel extends Model
{
    protected $table            = 'user_evaluations';
    protected $primaryKey       = 'evaluation_id';
    protected $useAutoIncrement = true; 

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'student_id',
        'category',
        'score',
        'created_at',
        'is_deleted',
    ];

    protected $useTimestamps = true;
}