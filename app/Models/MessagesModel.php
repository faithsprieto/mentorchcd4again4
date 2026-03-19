<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table            = 'messages';
    protected $primaryKey       = 'messages_id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'chat_id',
        'sender_student_id',
        'message',
        'file_path',
        'timestamp',
    ];

    protected $useTimestamps = true;
    public function getPaginatedChatMessages($chatId, $perPage = 20)
    {
        return $this->select('
                messages.messages_id,
                messages.chat_id,
                messages.message,
                messages.file_path,
                messages.timestamp,
                user.student_id,
                user.first_name,
                user.last_name,
                user.profile_picture,
                user.user_type
            ')
            ->join('user', 'user.student_id = messages.sender_student_id')
            ->where('messages.chat_id', $chatId)
            ->orderBy('messages.timestamp', 'ASC')
            ->paginate($perPage);
    }
}