<?php 
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Media extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\Media_Model';

	public function create()
    {
        $gambar = $this->request->getFile('productImage');
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

    public function delete($id = null)
    {
        $hapus = $this->model->find($id);
        if ($hapus) {
            $this->model->delete($id);
            unlink($hapus['media_path']);
            
            $response = [
                'status' => true,
                'message' => 'Gambar berhasil dihapus',
                'data' => [],
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal menghapus',
                'data' => [],
            ];
            return $this->respond($response, 200);
        }
    }
    
}