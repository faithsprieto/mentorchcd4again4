<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'student_id';
    protected $useAutoIncrement = false; // not marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'school_email',
        'first_name',
        'last_name',
        'profile_picture',
        'school_name',
        'department',
        'course_program',
        'year_level',
        'password',
        'register_date',
        'user_type',
    ];

    protected $useTimestamps = false;


    


   

    //ANNOUNCEMENTS//
    


}