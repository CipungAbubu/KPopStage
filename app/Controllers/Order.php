<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\TicketModel;
use CodeIgniter\RESTful\ResourceController;

class Order extends ResourceController
{
    protected $modelName = OrderModel::class;
    protected $format = 'json';

    public function index()
    {
        $orders = $this->model->getOrdersWithDetails();
        return $this->respond($orders);
    }

    public function show($id = null)
    {
        $order = $this->model->find($id);
        if (!$order) {
            return $this->failNotFound('Order not found');
        }
        return $this->respond($order);
    }

    public function create()
    {
        $validationRule = [
            'customer_name' => 'required|min_length[3]',
            'customer_email' => 'required|valid_email',
            'customer_phone' => 'required',
            'ticket_id' => 'required|integer',
            'quantity' => 'required|integer|greater_than[0]'
        ];

        if (!$this->validate($validationRule)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $ticketModel = new TicketModel();
        $ticket = $ticketModel->find($this->request->getVar('ticket_id'));
        
        if (!$ticket) {
            return redirect()->to('/manage-orders')->with('error', 'Tiket tidak ditemukan!');
        }

        $quantity = $this->request->getVar('quantity');
        
        // Check availability
        if ($ticket['available_quantity'] < $quantity) {
            return redirect()->to('/manage-orders')->with('error', 'Stok tiket tidak mencukupi!');
        }

        $totalPrice = $ticket['price'] * $quantity;

        $data = [
            'customer_name' => $this->request->getVar('customer_name'),
            'customer_email' => $this->request->getVar('customer_email'),
            'customer_phone' => $this->request->getVar('customer_phone'),
            'ticket_id' => $this->request->getVar('ticket_id'),
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'order_date' => date('Y-m-d H:i:s')
        ];

        $this->model->insert($data);

        // Update available quantity
        $ticketModel->update($ticket['id'], [
            'available_quantity' => $ticket['available_quantity'] - $quantity
        ]);

        return redirect()->to('/manage-orders')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function update($id = null)
    {
        $order = $this->model->find($id);
        if (!$order) {
            return redirect()->to('/manage-orders')->with('error', 'Pesanan tidak ditemukan!');
        }

        $input = $this->request->getPost();
        
        $data = [
            'customer_name' => $input['customer_name'] ?? $order['customer_name'],
            'customer_email' => $input['customer_email'] ?? $order['customer_email'],
            'customer_phone' => $input['customer_phone'] ?? $order['customer_phone'],
            'status' => $input['status'] ?? $order['status'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->model->update($id, $data);
        return redirect()->to('/manage-orders')->with('success', 'Pesanan berhasil diupdate!');
    }

    public function delete($id = null)
    {
        $order = $this->model->find($id);
        if (!$order) {
            return $this->failNotFound('Order not found');
        }

        // Return ticket quantity if order is cancelled
        if ($order['status'] !== 'cancelled') {
            $ticketModel = new TicketModel();
            $ticket = $ticketModel->find($order['ticket_id']);
            if ($ticket) {
                $ticketModel->update($ticket['id'], [
                    'available_quantity' => $ticket['available_quantity'] + $order['quantity']
                ]);
            }
        }

        $this->model->delete($id);
        return redirect()->to('/manage-orders')->with('success', 'Pesanan berhasil dihapus!');
    }
}