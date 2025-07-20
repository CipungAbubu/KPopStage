<?php

namespace App\Controllers;

use App\Models\ConcertModel;

class Home extends BaseController
{
    public function index()
    {
         $concertModel = new ConcertModel();

        $concerts = $concertModel->orderBy('created_at', 'ASC')->findAll(); // tampilkan semua

        return view('templates/header') . view('admin-home', ['concerts' => $concerts]);
    }

    public function manageKonser()
    {
        $concertModel = new ConcertModel();

        // Ambil semua konser
        $concerts = $concertModel->orderBy('created_at', 'ASC')->findAll();

        return view('templates/header') . view('admin-manage-concerts', ['concerts' => $concerts]);
    }

    public function saveConcert()
{
    $concertModel = new \App\Models\ConcertModel();

    // Ambil data dari form
    $name = $this->request->getPost('name');
    $location = $this->request->getPost('location');
    $date = $this->request->getPost('date');
    $description = $this->request->getPost('description');
    $image = $this->request->getFile('image');

    // Cek jika semua field wajib diisi
    if (!$name || !$location || !$date || !$image->isValid()) {
        return redirect()->back()->with('error', 'Semua field wajib diisi!');
    }

    // Simpan gambar
    $imageName = $image->getRandomName();
    $image->move('uploads/', $imageName); // pastikan folder ini ada

    // Simpan ke database
    $concertModel->insert([
        'name' => $name,
        'location' => $location,
        'date' => $date,
        'description' => $description,
        'image' => $imageName,
    ]);

    return redirect()->to('/manage')->with('success', 'Konser berhasil ditambahkan!');
}

public function adminTicket()
{
    $concertModel = new \App\Models\ConcertModel();
    $concerts = $concertModel->findAll();

    return view('admin-ticket', ['concerts' => $concerts]);
}

}
