<?php

namespace App\Models;

use CodeIgniter\Model;

class User_ProgressModel extends Model
{
    protected $table            = 'user_progress';
    protected $primaryKey       = 'progress_id';
    protected $useAutoIncrement = true; 

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'student_id',
        'keyword_id',
        'progress_percent',
        'updated_at',
        'is_deleted',
    ];

    protected $useTimestamps = true;
}