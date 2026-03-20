<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartmentsModel extends Model
{
    protected $table            = 'departments';
    protected $primaryKey       = 'departments_id';
    protected $useAutoIncrement = false; // not marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'department_title',
        'created_at',
        'is_deleted',
    ];

    protected $useTimestamps = true;
    
    //DEPARTMENTS//
    public function getDepartments()
    {
        $sql = <<<SQL
        SELECT
            department_id,
            department_title,
            created_at
        FROM departments
        WHERE is_deleted = 'N'
        ORDER BY department_title
        SQL;

        return $this->db->query($sql)->getResult();
    }

    public function createDepartments($title)
    {
        $sql = <<<SQL
        INSERT INTO departments
        (department_title)
        VALUES (?)
        SQL;

        return $this->db->query($sql, [$title]);
    }

    public function deleteDepartments($id)
    {
        $sql = <<<SQL
        UPDATE departments
        SET is_deleted='Y'
        WHERE department_id=?
        SQL;

        return $this->db->query($sql, [$id]);
    }
}