<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['customer_name', 'customer_email', 'customer_phone', 'ticket_id', 'quantity', 'total_price', 'status', 'order_date'];
    protected $useTimestamps = true;

    public function getOrdersWithDetails()
    {
        return $this->select('orders.*, tickets.ticket_type, tickets.price, concerts.name as concert_name, concerts.date as concert_date')
                    ->join('tickets', 'tickets.id = orders.ticket_id')
                    ->join('concerts', 'concerts.id = tickets.concert_id')
                    ->orderBy('orders.created_at', 'DESC')
                    ->findAll();
    }

    public function getOrdersByStatus($status = null)
    {
        $builder = $this->select('orders.*, tickets.ticket_type, tickets.price, concerts.name as concert_name, concerts.date as concert_date')
                        ->join('tickets', 'tickets.id = orders.ticket_id')
                        ->join('concerts', 'concerts.id = tickets.concert_id');
        
        if ($status) {
            $builder->where('orders.status', $status);
        }
        
        return $builder->orderBy('orders.created_at', 'DESC')->findAll();
    }
}