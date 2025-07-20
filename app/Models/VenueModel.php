<?php

namespace App\Models;

use CodeIgniter\Model;

class VenueModel extends Model
{
    protected $table = 'venues';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'address', 'city', 'capacity', 'facilities', 'image', 'contact_info'];
    protected $useTimestamps = true;
}