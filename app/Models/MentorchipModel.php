<?php

namespace App\Models;

use CodeIgniter\Model;

class MentorchipModel extends Model
{
    protected $table            = 'mentorchip';
    protected $primaryKey       = 'mentorch_id';
    protected $useAutoIncrement = true; 

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'mentor_id',
        'mentee_id',
        'status',
        'created_at',
        'requested_by',
        'request_type',
        'responded_at',
    ];

    protected $useTimestamps = true;

    public function getAllMentorchips()
    {
        $sql = <<<SQL
        SELECT 
            m.mentorch_id,
            m.mentor_id,
            m.mentee_id,
            m.status,
            m.created_at,
            m.requested_by,
            m.request_type,
            m.responded_at,

            mentor.first_name AS mentor_first_name,
            mentor.last_name AS mentor_last_name,

            mentee.first_name AS mentee_first_name,
            mentee.last_name AS mentee_last_name

        FROM mentorchip m
        LEFT JOIN user mentor ON mentor.student_id = m.mentor_id
        LEFT JOIN user mentee ON mentee.student_id = m.mentee_id
        ORDER BY m.created_at DESC
        SQL;

        return $this->db->query($sql)->getResultArray();
    }
}