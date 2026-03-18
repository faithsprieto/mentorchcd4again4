<?php

namespace App\Models;

use CodeIgniter\Model;

class Activity_LogsModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'activity_log_id';
    protected $useAutoIncrement = false; // not marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'activity_log_id',
        'operation_type',
        'timestamp'
    ];

    protected $useTimestamps = true;
    
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