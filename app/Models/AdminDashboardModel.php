<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminDashboardModel extends Model
{

    public function getUserStats()
    {
        $sql = <<<SQL
        SELECT
            (SELECT COUNT(*) FROM user WHERE user_type=1) AS total_admins,
            (SELECT COUNT(*) FROM user WHERE user_type=2) AS total_users,
            (SELECT COUNT(*) FROM user WHERE user_type=3) AS total_grads,

            (SELECT COUNT(*) FROM admin_course WHERE is_deleted='N') AS total_courses,
            (SELECT COUNT(*) FROM admin_department WHERE is_deleted='N') AS total_departments,

            (SELECT COUNT(*) FROM mentorchip WHERE status='accepted') AS mentor_matches
        SQL;

        return $this->db->query($sql)->getRow();
    }


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

    public function getActivityLogs()
    {
        $sql = <<<SQL
        SELECT
            activity_log_id,
            operation_type,
            timestamp
        FROM activity_logs
        ORDER BY timestamp DESC
        LIMIT 100
        SQL;

        return $this->db->query($sql)->getResult();
    }

}