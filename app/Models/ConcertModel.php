<?php

namespace App\Models;

use CodeIgniter\Model;

class ConcertModel extends Model
{
    protected $table = 'concerts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'location', 'date', 'image', 'description'];
    protected $useTimestamps = true;
}