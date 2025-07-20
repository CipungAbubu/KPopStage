<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\ConcertModel;
use CodeIgniter\RESTful\ResourceController;

class Ticket extends ResourceController
{
    protected $modelName = TicketModel::class;
    protected $format = 'json';

    public function index()
    {
        $tickets = $this->model->getTicketsWithConcert();
        return $this->respond($tickets);
    }

    public function show($id = null)
    {
        $ticket = $this->model->find($id);
        if (!$ticket) {
            return $this->failNotFound('Ticket not found');
        }
        return $this->respond($ticket);
    }

    public function byConcert($concertId)
    {
        $tickets = $this->model->getTicketsByConcert($concertId);
        return $this->respond($tickets);
    }

    public function create()
    {
        $validationRule = [
            'concert_id' => 'required|integer',
            'ticket_type' => 'required|min_length[3]',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'permit_empty'
        ];

        if (!$this->validate($validationRule)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'concert_id' => $this->request->getVar('concert_id'),
            'ticket_type' => $this->request->getVar('ticket_type'),
            'price' => $this->request->getVar('price'),
            'quantity' => $this->request->getVar('quantity'),
            'available_quantity' => $this->request->getVar('quantity'), // Initially same as quantity
            'description' => $this->request->getVar('description')
        ];

        $this->model->insert($data);
        return redirect()->to('/manage-tickets')->with('success', 'Tiket berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        $ticket = $this->model->find($id);
        if (!$ticket) {
            return redirect()->to('/manage-tickets')->with('error', 'Tiket tidak ditemukan!');
        }

        $input = $this->request->getPost();
        
        $data = [
            'concert_id' => $input['concert_id'] ?? $ticket['concert_id'],
            'ticket_type' => $input['ticket_type'] ?? $ticket['ticket_type'],
            'price' => $input['price'] ?? $ticket['price'],
            'quantity' => $input['quantity'] ?? $ticket['quantity'],
            'available_quantity' => $input['available_quantity'] ?? $ticket['available_quantity'],
            'description' => $input['description'] ?? $ticket['description'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->model->update($id, $data);
        return redirect()->to('/manage-tickets')->with('success', 'Tiket berhasil diupdate!');
    }

    public function delete($id = null)
    {
        $ticket = $this->model->find($id);
        if (!$ticket) {
            return $this->failNotFound('Ticket not found');
        }

        $this->model->delete($id);
        return redirect()->to('/manage-tickets')->with('success', 'Tiket berhasil dihapus!');
    }
}