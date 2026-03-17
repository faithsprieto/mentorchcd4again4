<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'student_id';
    protected $useAutoIncrement = false;

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


    // DEPARTMENTS
    public function getDepartments()
    {
        $sql = <<<SQL
        SELECT
            department_id,
            department_title,
            created_at
        FROM departments
        WHERE is_deleted = 'N'
        ORDER BY department_title ASC
        SQL;

        return $this->db->query($sql)->getResult();
    }

    public function createDepartment($title)
    {
        $sql = <<<SQL
        INSERT INTO departments
        (department_title)
        VALUES (?)
        SQL;

        return $this->db->query($sql, [$title]);
    }

    public function deleteDepartment($id)
    {
        $sql = <<<SQL
        UPDATE departments
        SET is_deleted = 'Y'
        WHERE department_id = ?
        SQL;

        return $this->db->query($sql, [$id]);
    }


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


    // ANNOUNCEMENTS
    public function getAnnouncements()
    {
        $sql = <<<SQL
        SELECT
            announcement_id,
            department_id,
            title,
            description,
            image,
            created_at
        FROM announcements
        WHERE is_deleted = 'N'
        ORDER BY created_at DESC
        SQL;

        return $this->db->query($sql)->getResult();
    }

    public function createAnnouncement($dept, $title, $desc, $image)
    {
        $sql = <<<SQL
        INSERT INTO announcements
        (department_id, title, description, image)
        VALUES (?, ?, ?, ?)
        SQL;

        return $this->db->query($sql, [$dept, $title, $desc, $image]);
    }


    // ORGANISATIONS
    public function getOrganisations()
    {
        $sql = <<<SQL
        SELECT
            org_id,
            org_title,
            file_path,
            description,
            created_at
        FROM organisations
        WHERE is_deleted = 'N'
        ORDER BY org_title ASC
        SQL;

        return $this->db->query($sql)->getResult();
    }

    public function createOrganisation($title, $file, $desc)
    {
        $sql = <<<SQL
        INSERT INTO organisations
        (org_title, file_path, description)
        VALUES (?, ?, ?)
        SQL;

        return $this->db->query($sql, [$title, $file, $desc]);
    }


    // KEYWORDS
    public function getKeywords()
    {
        $sql = <<<SQL
        SELECT
            keyword_id,
            keyword_tag
        FROM keywords
        ORDER BY keyword_tag ASC
        SQL;

        return $this->db->query($sql)->getResult();
    }

    public function createKeyword($tag)
    {
        $sql = <<<SQL
        INSERT INTO keywords
        (keyword_tag)
        VALUES (?)
        SQL;

        return $this->db->query($sql, [$tag]);
    }

}
