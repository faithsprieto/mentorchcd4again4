<?php

namespace App\Models;

use CodeIgniter\Model;

class MessagesModel extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'messages_id';
    protected $returnType = 'array';

    
}