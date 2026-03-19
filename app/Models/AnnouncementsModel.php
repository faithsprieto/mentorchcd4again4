<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementsModel extends Model
{
    protected $table            = 'announcements';
    protected $primaryKey       = 'announcement_id';
    protected $useAutoIncrement = false; // not marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'announcement_id',
        'department_id',
        'title',
        'description',
        'image',
        'created_at',
        'is_deleted'
    ];

    protected $useTimestamps = true;
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
}