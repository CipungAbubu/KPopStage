<?php

namespace App\Controllers;

use App\Models\ConcertModel;
use CodeIgniter\RESTful\ResourceController;

class Concert extends ResourceController
{
    protected $modelName = ConcertModel::class;
    protected $format    = 'json';

    // GET /concert
    public function index()
    {
        $concerts = $this->model->findAll();
        return $this->respond($concerts);
    }

    // GET /concert/{id}
    public function show($id = null)
    {
        $concert = $this->model->find($id);
        if (!$concert) {
            return $this->failNotFound('Concert not found');
        }
        return $this->respond($concert);
    }

    // POST /concert
    public function create()
{
    helper(['form']);

    $validationRule = [
        'name' => 'required|min_length[3]',
        'location' => 'required',
        'date' => 'required|valid_date',
        'description' => 'permit_empty',
        'image' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]'
    ];

    if (!$this->validate($validationRule)) {
        return $this->failValidationErrors($this->validator->getErrors());
    }

    $image = $this->request->getFile('image');

    $imageName = $image->getRandomName();
    $image->move(ROOTPATH . 'public/uploads/', $imageName);

    $data = [
        'name'        => $this->request->getVar('name'),
        'location'    => $this->request->getVar('location'),
        'date'        => $this->request->getVar('date'),
        'description' => $this->request->getVar('description'),
        'image'       => base_url('uploads/' . $imageName)
    ];

    $this->model->insert($data);

    session()->setFlashdata('success', 'Konser berhasil disimpan!');

     return redirect()->to('/manage');
}

    // PUT /concert/{id}
    public function update($id = null)
{
    $concert = $this->model->find($id);
    if (!$concert) {
        return redirect()->to('/manage')->with('error', 'Konser tidak ditemukan!');
    }

    $input = $this->request->getPost();

    $data = [
        'name'        => $input['name']        ?? $concert['name'],
        'location'    => $input['location']    ?? $concert['location'],
        'date'        => $input['date']        ?? $concert['date'],
        'description' => $input['description'] ?? $concert['description'],
        'updated_at'  => date('Y-m-d H:i:s'),
    ];

    $image = $this->request->getFile('image');
    if ($image && $image->isValid() && !$image->hasMoved()) {
        $newName = time() . '_' . $image->getRandomName();
        $image->move(ROOTPATH . 'public/uploads/', $newName);
        $data['image'] = base_url('uploads/' . $newName);

        if (!empty($concert['image'])) {
            $oldPath = str_replace(base_url(), ROOTPATH . 'public/', $concert['image']);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
    } else {

        $data['image'] = $concert['image'];
    }

    $this->model->update($id, $data);

    return redirect()->to('/manage')->with('success', 'Konser berhasil diupdate!');
}

    // DELETE /concert/{id}
public function delete($id = null)
{
    $concert = $this->model->find($id);
    if (!$concert) {
        return $this->failNotFound('Concert not found');
    }

    // Hapus gambar dari folder (jika ada)
    if (!empty($concert['image'])) {
        $imagePath = str_replace(base_url(), ROOTPATH . 'public/', $concert['image']);
        if (file_exists($imagePath)) {
            unlink($imagePath); // hapus file
        }
    }

    $this->model->delete($id);

    // Jika kamu ingin redirect (bukan JSON) karena ini via form biasa:
    return redirect()->to('/manage')->with('success', 'Konser berhasil dihapus!');
}
}