<?php

namespace App\Models;

use CodeIgniter\Model;

class Message_ChatModel extends Model
{
    protected $table            = 'message_chat';
    protected $primaryKey       = 'chat_id';
    protected $useAutoIncrement = false; // not marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'channel_id',
        'created_by',
        'mentor_owner',
        'chat_title',
        'timestamp',
    ];

    protected $useTimestamps = true;
}