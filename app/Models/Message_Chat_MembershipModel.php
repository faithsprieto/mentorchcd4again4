<?php

namespace App\Models;

use CodeIgniter\Model;

class Message_Chat_MembershipModel extends Model
{
    protected $table            = 'message_chat_membership';
    protected $primaryKey       = 'membership_id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'channel_id',
        'student_id',
        'role',
        'joined_at',
        'left_at',
        'is_archived',
    ];

    protected $useTimestamps = true;
}