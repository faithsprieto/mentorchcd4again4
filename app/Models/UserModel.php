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
    public function registerUser(array $data)
    {
        // Check duplicate email
        if ($this->where('school_email', $data['school_email'])->first()) {
            return [
                'status'  => false,
                'message' => 'School email already exists.'
            ];
        }

        // Check duplicate student ID
        if ($this->where('student_id', $data['student_id'])->first()) {
            return [
                'status'  => false,
                'message' => 'Student ID already exists.'
            ];
        }

        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Auto date
        $data['register_date'] = date('Y-m-d H:i:s');

        // Insert
        if (!$this->insert($data)) {
            return [
                'status'  => false,
                'message' => 'Registration failed.',
                'errors'  => $this->errors()
            ];
        }

        return [
            'status'  => true,
            'message' => 'User registered successfully.',
            'user_id' => $this->getInsertID()
        ];
    }
}