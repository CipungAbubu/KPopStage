<?php

namespace App\Controllers;

use App\Models\VenueModel;
use CodeIgniter\RESTful\ResourceController;

class Venue extends ResourceController
{
    protected $modelName = VenueModel::class;
    protected $format = 'json';

    public function index()
    {
        $venues = $this->model->findAll();
        return $this->respond($venues);
    }

    public function show($id = null)
    {
        $venue = $this->model->find($id);
        if (!$venue) {
            return $this->failNotFound('Venue not found');
        }
        return $this->respond($venue);
    }

    public function create()
    {
        helper(['form']);

        $validationRule = [
            'name' => 'required|min_length[3]',
            'address' => 'required',
            'city' => 'required',
            'capacity' => 'required|integer',
            'facilities' => 'permit_empty',
            'contact_info' => 'permit_empty',
            'image' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]'
        ];

        if (!$this->validate($validationRule)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move(ROOTPATH . 'public/uploads/venues/', $imageName);

        $data = [
            'name' => $this->request->getVar('name'),
            'address' => $this->request->getVar('address'),
            'city' => $this->request->getVar('city'),
            'capacity' => $this->request->getVar('capacity'),
            'facilities' => $this->request->getVar('facilities'),
            'contact_info' => $this->request->getVar('contact_info'),
            'image' => base_url('uploads/venues/' . $imageName)
        ];

        $this->model->insert($data);
        return redirect()->to('/manage-venues')->with('success', 'Venue berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        $venue = $this->model->find($id);
        if (!$venue) {
            return redirect()->to('/manage-venues')->with('error', 'Venue tidak ditemukan!');
        }

        $input = $this->request->getPost();

        $data = [
            'name' => $input['name'] ?? $venue['name'],
            'address' => $input['address'] ?? $venue['address'],
            'city' => $input['city'] ?? $venue['city'],
            'capacity' => $input['capacity'] ?? $venue['capacity'],
            'facilities' => $input['facilities'] ?? $venue['facilities'],
            'contact_info' => $input['contact_info'] ?? $venue['contact_info'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = time() . '_' . $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/venues/', $newName);
            $data['image'] = base_url('uploads/venues/' . $newName);

            if (!empty($venue['image'])) {
                $oldPath = str_replace(base_url(), ROOTPATH . 'public/', $venue['image']);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
        } else {
            $data['image'] = $venue['image'];
        }

        $this->model->update($id, $data);
        return redirect()->to('/manage-venues')->with('success', 'Venue berhasil diupdate!');
    }

    public function delete($id = null)
    {
        $venue = $this->model->find($id);
        if (!$venue) {
            return $this->failNotFound('Venue not found');
        }

        if (!empty($venue['image'])) {
            $imagePath = str_replace(base_url(), ROOTPATH . 'public/', $venue['image']);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $this->model->delete($id);
        return redirect()->to('/manage-venues')->with('success', 'Venue berhasil dihapus!');
    }
}