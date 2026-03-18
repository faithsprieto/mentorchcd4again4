<?php

namespace App\Models;

use CodeIgniter\Model;

class User_GoalsModel extends Model
{
    protected $table            = 'user_goals';
    protected $primaryKey       = 'goal_id';
    protected $useAutoIncrement = false; // not marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'student_id',
        'title',
        'description',
        'progress_percent',
        'target_date',
        'status',
        'created_at',
        'is_deleted',
    ];

    protected $useTimestamps = true;
}