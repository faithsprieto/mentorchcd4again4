<?php

namespace App\Models;

use CodeIgniter\Model;

class User_ProgressModel extends Model
{
    protected $table            = 'user_progress';
    protected $primaryKey       = 'progress_id';
    protected $useAutoIncrement = false; // not marked AUTO_INCREMENT in dump

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