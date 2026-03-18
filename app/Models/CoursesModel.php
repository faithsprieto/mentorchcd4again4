<?php

namespace App\Models;

use CodeIgniter\Model;

class CoursesModel extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'courses_id';
    protected $useAutoIncrement = false; // not marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'department_id',
        'course_title',
        'created_at',
        'is_deleted',
    ];

    protected $useTimestamps = true;
     //COURSES//
    public function getCoursesByDepartment($departmentId)
    {
        $sql = <<<SQL
        SELECT
            course_id,
            course_title,
            department_id
        FROM courses
        WHERE department_id = ?
        AND is_deleted='N'
        SQL;

        return $this->db->query($sql, [$departmentId])->getResult();
    }

    public function createCourse($departmentId,$title)
    {
        $sql = <<<SQL
        INSERT INTO courses
        (department_id,course_title)
        VALUES (?,?)
        SQL;

        return $this->db->query($sql,[$departmentId,$title]);
    }

}