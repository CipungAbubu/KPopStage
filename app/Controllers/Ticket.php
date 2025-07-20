<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\ConcertModel;
use CodeIgniter\Controller;

class Ticket extends Controller
{
    public function index($concertId)
    {
        $ticketModel = new TicketModel();
        $concertModel = new ConcertModel();

        $concert = $concertModel->find($concertId);

        if (!$concert) {
            return redirect()->back()->with('error', 'Konser tidak ditemukan.');
        }

        $tickets = $ticketModel->where('concert_id', $concertId)->findAll();

        return view('tickets/admin-ticket', [
            'concert' => $concert,
            'tickets' => $tickets
        ]);
    }

    public function create($concertId)
    {
        $concertModel = new ConcertModel();
        $concert = $concertModel->find($concertId);

        if (!$concert) {
            return redirect()->back()->with('error', 'Konser tidak ditemukan.');
        }

        return view('tickets/admin-ticket', [
            'concert' => $concert,
            'mode' => 'form'
        ]);
    }

    public function store($concertId)
    {
        $concertModel = new ConcertModel();
        $concert = $concertModel->find($concertId);

        if (!$concert) {
            return redirect()->back()->with('error', 'Konser tidak ditemukan.');
        }

        $ticketModel = new TicketModel();

        $data = [
            'concert_id' => $concertId,
            'category' => $this->request->getPost('category'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'description' => $this->request->getPost('description'),
        ];

        // Tangani upload gambar jika ada
        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $imageName = $imageFile->getRandomName();
            $imageFile->move(ROOTPATH . 'public/uploads/', $imageName);
            $data['image'] = base_url('uploads/' . $imageName);
        }

        $ticketModel->insert($data);
        return redirect()->to('/ticket/index/' . $concertId);
    }

    public function delete($ticketId)
    {
        $ticketModel = new TicketModel();
        $ticket = $ticketModel->find($ticketId);
        if ($ticket) {
            $ticketModel->delete($ticketId);
            return redirect()->to('/ticket/index/' . $ticket['concert_id']);
        } else {
            return redirect()->back()->with('error', 'Tiket tidak ditemukan.');
        }
    }
}
