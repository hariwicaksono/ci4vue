<?php 
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ImageUpload extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\Media_Model';

	public function create()
    {
        $gambar = $this->request->getFile('foto');
        $fileName = $gambar->getRandomName();
        if ($gambar !== "") {
            $path = "images/";
            $moved = $gambar->move($path, $fileName);
            if ($moved) {
                $simpan = $this->model->save([
                    'media_path' => $path . $fileName
                ]);
                if ($simpan) {
                    return $this->respond(["status" => true, "message" => "Berhasil upload Gambar", "data" => $this->model->getInsertID()], 200);
                } else {
                    return $this->respond(["status" => false, "message" => "Gagal upload gambar", "data" => []], 200);
                }
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal upload gambar',
                'data' => []
            ];
            return $this->respond($response, 200);
        }
    }
    
}