<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use CodeIgniter\Database\ConnectionInterface;

class TestDb extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('concerts');
        $data = $builder->get()->getResult();

        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}
