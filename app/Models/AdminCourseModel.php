<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminCourseModel extends Model
{

    public function getCoursesByDepartment($departmentId)
    {
        $sql = <<<SQL
        SELECT
            course_id,
            course_title,
            department_id
        FROM admin_course
        WHERE department_id = ?
        AND is_deleted='N'
        SQL;

        return $this->db->query($sql, [$departmentId])->getResult();
    }

    public function createCourse($departmentId,$title)
    {
        $sql = <<<SQL
        INSERT INTO admin_course
        (department_id,course_title)
        VALUES (?,?)
        SQL;

        return $this->db->query($sql,[$departmentId,$title]);
    }

}