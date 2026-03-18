<?php

namespace App\Models;

use CodeIgniter\Model;

class Library_Upload_RequestModel extends Model
{
    protected $table            = 'library_upload_request';
    protected $primaryKey       = 'request_id';
    protected $useAutoIncrement = false; // not marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'student_id',
        'title',
        'file_name',
        'file_path',
        'status',
        'updated_on',
        'upload_date',
    ];

    protected $useTimestamps = true;
    public function getPendingLibraryUploads()
    {
        $sql = <<<SQL
        SELECT
            r.request_id,
            r.student_id,
            u.first_name,
            u.last_name,
            r.title,
            r.file_name,
            r.upload_date
        FROM library_upload_request r
        JOIN user u
        ON r.student_id=u.student_id
        WHERE r.status='pending'
        ORDER BY r.upload_date DESC
        SQL;

        return $this->db->query($sql)->getResult();
    }
    public function approveLibraryUpload($requestId)
    {
        $sql = <<<SQL
        UPDATE library_upload_request
        SET status = 'accepted',
            updated_on = NOW()
        WHERE request_id = ?
        SQL;

        return $this->db->query($sql, [$requestId]);
    }

    public function rejectLibraryUpload($requestId)
    {
        $sql = <<<SQL
        UPDATE library_upload_request
        SET status = 'rejected',
            updated_on = NOW()
        WHERE request_id = ?
        SQL;

        return $this->db->query($sql, [$requestId]);
    }
}