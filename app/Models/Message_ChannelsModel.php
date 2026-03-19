<?php

namespace App\Models;

use CodeIgniter\Model;

class Message_ChannelsModel extends Model
{
    protected $table            = 'message_channels';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false; // not marked AUTO_INCREMENT in dump

    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'channel_type',
    ];

    
}