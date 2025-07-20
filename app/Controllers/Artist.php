<?php

namespace App\Controllers;

use App\Models\ArtistModel;
use CodeIgniter\RESTful\ResourceController;

class Artist extends ResourceController
{
    protected $modelName = ArtistModel::class;
    protected $format = 'json';

    public function index()
    {
        $artists = $this->model->findAll();
        return $this->respond($artists);
    }

    public function show($id = null)
    {
        $artist = $this->model->find($id);
        if (!$artist) {
            return $this->failNotFound('Artist not found');
        }
        return $this->respond($artist);
    }

    public function create()
    {
        helper(['form']);

        $validationRule = [
            'name' => 'required|min_length[2]',
            'genre' => 'required',
            'country' => 'required',
            'debut_year' => 'required|integer',
            'description' => 'permit_empty',
            'social_media' => 'permit_empty',
            'image' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]'
        ];

        if (!$this->validate($validationRule)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move(ROOTPATH . 'public/uploads/artists/', $imageName);

        $data = [
            'name' => $this->request->getVar('name'),
            'genre' => $this->request->getVar('genre'),
            'country' => $this->request->getVar('country'),
            'debut_year' => $this->request->getVar('debut_year'),
            'description' => $this->request->getVar('description'),
            'social_media' => $this->request->getVar('social_media'),
            'image' => base_url('uploads/artists/' . $imageName)
        ];

        $this->model->insert($data);
        return redirect()->to('/manage-artists')->with('success', 'Artis berhasil ditambahkan!');
    }

    public function update($id = null)
    {
        $artist = $this->model->find($id);
        if (!$artist) {
            return redirect()->to('/manage-artists')->with('error', 'Artis tidak ditemukan!');
        }

        $input = $this->request->getPost();

        $data = [
            'name' => $input['name'] ?? $artist['name'],
            'genre' => $input['genre'] ?? $artist['genre'],
            'country' => $input['country'] ?? $artist['country'],
            'debut_year' => $input['debut_year'] ?? $artist['debut_year'],
            'description' => $input['description'] ?? $artist['description'],
            'social_media' => $input['social_media'] ?? $artist['social_media'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = time() . '_' . $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/artists/', $newName);
            $data['image'] = base_url('uploads/artists/' . $newName);

            if (!empty($artist['image'])) {
                $oldPath = str_replace(base_url(), ROOTPATH . 'public/', $artist['image']);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
        } else {
            $data['image'] = $artist['image'];
        }

        $this->model->update($id, $data);
        return redirect()->to('/manage-artists')->with('success', 'Artis berhasil diupdate!');
    }

    public function delete($id = null)
    {
        $artist = $this->model->find($id);
        if (!$artist) {
            return $this->failNotFound('Artist not found');
        }

        if (!empty($artist['image'])) {
            $imagePath = str_replace(base_url(), ROOTPATH . 'public/', $artist['image']);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $this->model->delete($id);
        return redirect()->to('/manage-artists')->with('success', 'Artis berhasil dihapus!');
    }
}