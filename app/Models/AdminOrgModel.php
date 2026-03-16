<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminOrgModel extends Model
{

    public function getOrgs()
    {
        $sql = <<<SQL
        SELECT
            org_id,
            org_title,
            description,
            file_path,
            created_at
        FROM admin_orgs
        WHERE is_deleted='N'
        SQL;

        return $this->db->query($sql)->getResult();
    }

    public function createOrg($title,$file,$desc)
    {
        $sql = <<<SQL
        INSERT INTO admin_orgs
        (org_title,file_path,description)
        VALUES (?,?,?)
        SQL;

        return $this->db->query($sql,[$title,$file,$desc]);
    }

}