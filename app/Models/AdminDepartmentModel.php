<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminDepartmentModel extends Model
{
    public function getDepartments()
    {
        $sql = <<<SQL
        SELECT
            department_id,
            department_title,
            created_at
        FROM admin_department
        WHERE is_deleted = 'N'
        ORDER BY department_title
        SQL;

        return $this->db->query($sql)->getResult();
    }

    public function createDepartment($title)
    {
        $sql = <<<SQL
        INSERT INTO admin_department
        (department_title)
        VALUES (?)
        SQL;

        return $this->db->query($sql, [$title]);
    }

    public function deleteDepartment($id)
    {
        $sql = <<<SQL
        UPDATE admin_department
        SET is_deleted='Y'
        WHERE department_id=?
        SQL;

        return $this->db->query($sql, [$id]);
    }
}