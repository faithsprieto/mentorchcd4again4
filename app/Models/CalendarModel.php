<?php

namespace App\Models;

use CodeIgniter\Model;

class CalendarModel extends Model
{
    protected $table = 'calendar';
    protected $primaryKey = 'calendar_id';

    public function getStudentCalendar($studentId)
{
    $db = \Config\Database::connect();

    $db->transStart();

    $sql = <<<SQL
    SELECT
        c.calendar_id,
        c.student_id,
        c.title,
        c.date_time,
        c.duration,
        c.status,
        c.description,
        c.sync_with,
        'owner' as event_type
    FROM calendar c
    WHERE c.student_id = ?

    UNION

    SELECT
        c.calendar_id,
        c.student_id,
        c.title,
        c.date_time,
        c.duration,
        c.status,
        c.description,
        c.sync_with,
        'shared' as event_type
    FROM calendar c
    JOIN calendar_user cu
        ON cu.calendar_id = c.calendar_id
    WHERE cu.student_id = ?

    UNION

    SELECT
        cs.calendar_sync_id as calendar_id,
        cs.owner_id as student_id,
        cs.event as title,
        cs.date_time,
        NULL as duration,
        cs.permission as status,
        cs.description,
        NULL as sync_with,
        'synced' as event_type
    FROM calendar_sync cs
    WHERE cs.owner_id = ?
    SQL;

    $query = $db->query($sql, [$studentId, $studentId, $studentId]);
    $result = $query->getResult();

    $db->transComplete();

    return $result;
}
}