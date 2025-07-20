<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['concert_id', 'category', 'price', 'stock', 'description', 'image'];
    protected $useTimestamps = true;
}
