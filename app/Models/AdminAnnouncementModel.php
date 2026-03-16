<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminAnnouncementModel extends Model
{

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
        FROM admin_announcement
        WHERE is_deleted='N'
        ORDER BY created_at DESC
        SQL;

        return $this->db->query($sql)->getResult();
    }

    public function createAnnouncement($dept,$title,$desc,$image)
    {
        $sql = <<<SQL
        INSERT INTO admin_announcement
        (department_id,title,description,image)
        VALUES (?,?,?,?)
        SQL;

        return $this->db->query($sql,[$dept,$title,$desc,$image]);
    }

}