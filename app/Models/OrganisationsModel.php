<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganisationsModel extends Model
{
    protected $table            = 'organisations';
    protected $primaryKey       = 'org_id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'org_title',
        'file_path',
        'description',
        'created_at',
        'is_deleted',
    ];

    protected $useTimestamps = true;
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
}