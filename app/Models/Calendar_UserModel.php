<?php

namespace App\Models;

use CodeIgniter\Model;

class Calendar_UserModel extends Model
{
    protected $table            = 'calendar_user';
    protected $primaryKey       = 'calendar_user_id';
    protected $useAutoIncrement = true; // marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'calendar_id',
        'student_id',
    ];

}