<?php

namespace App\Models;

use CodeIgniter\Model;

class Library_Upload_RequestModel extends Model
{
    protected $table            = 'library_upload_request';
    protected $primaryKey       = 'request_id';
    protected $useAutoIncrement = true;

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
    
    //FETCH DATA
    $sqlFetch = <<<SQL
        SELECT *
        FROM library_upload_request
        WHERE request_id = ?
        AND status = 'pending'
    SQL;

    $request = $this->db->query($sqlFetch, [$requestId])->getRowArray();

    if (!$request) {
        throw new \Exception("Request not found or already processed.");
    }

    // INSERT DATA INTO LIBRARY
    $sqlInsert = <<<SQL
        INSERT INTO library_upload (
            student_id,
            title,
            file_name,
            file_path,
            badges,
            file_type,
            file_size
        )
        VALUES (?, ?, ?, ?, '', '', 0)
    SQL;

    $this->db->query($sqlInsert, [
        $request['student_id'],
        $request['title'],
        $request['file_name'],
        $request['file_path']
    ]);

    // UPDATE 
    $sqlUpdate = <<<SQL
        UPDATE library_upload_request
        SET status = 'accepted',
            updated_on = NOW()
        WHERE request_id = ?
    SQL;

    return $this->db->query($sqlUpdate, [$requestId]);
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