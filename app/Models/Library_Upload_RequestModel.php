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
    public function processUpload(array $data): array
    {
        $db = \Config\Database::connect();

        try {
            $db->transStart();

            // 1. insert activity log
            $activityLogId = $this->insertActivityLog($db, [
                'operation_type' => 'upload',
            ]);

            // 2. insert upload request
            $libraryFileId = $this->insertUploadRequest($db, [
                'student_id' => $data['student_id'],
                'title'      => $data['title'],
                'file_name'  => $data['file_name'],
                'file_path'  => $data['file_path'],
                'status'     => 'pending',
            ]);

            // 3. insert library tagging for each keyword
            foreach ($data['keyword_ids'] as $keywordId) {
                $this->insertLibraryTagging($db, [
                    'library_file_id' => $libraryFileId,
                    'keyword_id'      => $keywordId,
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return [
                    'status'  => false,
                    'message' => 'Database transaction failed.',
                ];
            }

            return [
                'status' => true,
                'message' => 'Upload transaction completed successfully.',
                'data' => [
                    'activity_log_id' => $activityLogId,
                    'library_file_id' => $libraryFileId,
                ]
            ];

        } catch (\Throwable $e) {
            if ($db->transStatus() !== false) {
                $db->transRollback();
            }

            return [
                'status'  => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    protected function insertActivityLog($db, array $data): int
    {
        $sql = <<<SQL
            INSERT INTO activity_logs (
                operation_type,
                timestamp
            ) VALUES (
                ?,
                NOW()
            )
        SQL;

        $db->query($sql, [
            $data['operation_type'],
        ]);

        return $db->insertID();
    }

    protected function insertUploadRequest($db, array $data): int
    {
        $sql = <<<SQL
            INSERT INTO library_upload_request (
                student_id,
                title,
                file_name,
                file_path,
                status,
                updated_on,
                upload_date
            ) VALUES (
                ?,
                ?,
                ?,
                ?,
                ?,
                NOW(),
                NOW()
            )
        SQL;

        $db->query($sql, [
            $data['student_id'],
            $data['title'],
            $data['file_name'],
            $data['file_path'],
            $data['status'],
        ]);

        return $db->insertID();
    }

    protected function insertLibraryTagging($db, array $data): void
    {
        $sql = <<<SQL
            INSERT INTO library_tagging (
                library_file_id,
                keyword_id
            ) VALUES (
                ?,
                ?
            )
        SQL;

        $db->query($sql, [
            $data['library_file_id'],
            $data['keyword_id'],
        ]);
    }
    public function getFilesWithTags($studentId = null): array
    {
        $db = \Config\Database::connect();

        if (!empty($studentId)) {
            $sql = <<<SQL
                SELECT
                    lur.request_id,
                    lur.student_id,
                    lur.title,
                    lur.file_name,
                    lur.file_path,
                    lur.status,
                    lur.updated_on,
                    lur.upload_date,
                    k.keyword_id,
                    k.keyword_tag
                FROM library_upload_request lur
                LEFT JOIN library_tagging lt
                    ON lt.library_file_id = lur.request_id
                LEFT JOIN keywords k
                    ON k.keyword_id = lt.keyword_id
                WHERE lur.student_id = ?
                ORDER BY lur.upload_date DESC, k.keyword_tag ASC
            SQL;

            $query = $db->query($sql, [$studentId]);
        } else {
            $sql = <<<SQL
                SELECT
                    lur.request_id,
                    lur.student_id,
                    lur.title,
                    lur.file_name,
                    lur.file_path,
                    lur.status,
                    lur.updated_on,
                    lur.upload_date,
                    k.keyword_id,
                    k.keyword_tag
                FROM library_upload_request lur
                LEFT JOIN library_tagging lt
                    ON lt.library_file_id = lur.request_id
                LEFT JOIN keywords k
                    ON k.keyword_id = lt.keyword_id
                ORDER BY lur.upload_date DESC, k.keyword_tag ASC
            SQL;

            $query = $db->query($sql);
        }

        $rows = $query->getResultArray();
        $grouped = [];

        foreach ($rows as $row) {
            $requestId = $row['request_id'];

            if (!isset($grouped[$requestId])) {
                $grouped[$requestId] = [
                    'request_id'  => $row['request_id'],
                    'student_id'  => $row['student_id'],
                    'title'       => $row['title'],
                    'file_name'   => $row['file_name'],
                    'file_path'   => $row['file_path'],
                    'status'      => $row['status'],
                    'updated_on'  => $row['updated_on'],
                    'upload_date' => $row['upload_date'],
                    'tags'        => [],
                ];
            }

            if (!empty($row['keyword_id'])) {
                $grouped[$requestId]['tags'][] = [
                    'keyword_id'  => $row['keyword_id'],
                    'keyword_tag' => $row['keyword_tag'],
                ];
            }
        }

        return array_values($grouped);
    }
}