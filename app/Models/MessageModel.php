<?php

namespace App\Models;

use CodeIgniter\Model;

class MessagesModel extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'messages_id';

    public function getChatMessages($chatId, $limit, $offset)
    {
        $db = \Config\Database::connect();

        $sql = <<<SQL
        SELECT
            m.messages_id,
            m.chat_id,
            m.sender_student_id,
            m.message,
            m.file_path,
            m.timestamp,
            u.first_name,
            u.last_name,
            u.profile_picture,
            u.user_type
        FROM messages m
        JOIN user u
            ON m.sender_student_id = u.student_id
        WHERE m.chat_id = ?
        ORDER BY m.timestamp ASC
        LIMIT ? OFFSET ?
        SQL;

        $query = $db->query($sql, [$chatId, $limit, $offset]);

        return $query->getResultArray();
    }
}
