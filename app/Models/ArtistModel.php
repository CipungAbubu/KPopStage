<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtistModel extends Model
{
    protected $table = 'artists';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'genre', 'country', 'debut_year', 'image', 'description', 'social_media'];
    protected $useTimestamps = true;
}