<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['concert_id', 'ticket_type', 'price', 'quantity', 'available_quantity', 'description'];
    protected $useTimestamps = true;

    public function getTicketsByConcert($concertId)
    {
        return $this->select('tickets.*, concerts.name as concert_name')
                    ->join('concerts', 'concerts.id = tickets.concert_id')
                    ->where('tickets.concert_id', $concertId)
                    ->findAll();
    }

    public function getTicketsWithConcert()
    {
        return $this->select('tickets.*, concerts.name as concert_name, concerts.date as concert_date')
                    ->join('concerts', 'concerts.id = tickets.concert_id')
                    ->orderBy('concerts.date', 'ASC')
                    ->findAll();
    }
}