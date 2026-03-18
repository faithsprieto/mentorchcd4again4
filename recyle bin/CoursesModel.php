<?php

namespace App\Models;

use CodeIgniter\Model;

class CoursesModel extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'course_id';
    protected $useAutoIncrement = false;

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'department_id',
        'course_title',
        'created_at',
        'is_deleted',
    ];

    // COURSES
    public function getCoursesByDepartment($departmentId)
    {
        $sql = <<<SQL
        SELECT
            course_id,
            department_id,
            course_title,
            created_at
        FROM courses
        WHERE department_id = ?
        AND is_deleted = 'N'
        ORDER BY course_title ASC
        SQL;

        return $this->db->query($sql, [$departmentId])->getResult();
    }

    public function createCourses($departmentId, $title)
    {
        $sql = <<<SQL
        INSERT INTO courses
        (department_id, course_title)
        VALUES (?, ?)
        SQL;

        return $this->db->query($sql, [$departmentId, $title]);
    }

}
