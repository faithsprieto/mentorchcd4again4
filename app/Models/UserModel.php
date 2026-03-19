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

    protected $useTimestamps = true;
    
    public function getUserStats()
    {
        $sql = <<<SQL
        SELECT
            (SELECT COUNT(*) FROM user WHERE user_type=1) AS total_admins,
            (SELECT COUNT(*) FROM user WHERE user_type=2) AS total_users,
            (SELECT COUNT(*) FROM user WHERE user_type=3) AS total_grads,

            (SELECT COUNT(*) FROM admin_course WHERE is_deleted='N') AS total_courses,
            (SELECT COUNT(*) FROM admin_department WHERE is_deleted='N') AS total_departments,

            (SELECT COUNT(*) FROM mentorchip WHERE status='accepted') AS mentor_matches
        SQL;

        return $this->db->query($sql)->getRow();
    }
}