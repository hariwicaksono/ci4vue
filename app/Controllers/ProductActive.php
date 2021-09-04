<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ProductActive extends ResourceController
{
    protected $format       = 'json';
    protected $modelName    = 'App\Models\Product_Model';

    public function update($id = NULL)
    {
        
        if($this->request->getJSON()) {
            $json = $this->request->getJSON();
            $data = [
                'active' => $json->active,
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'active' => $input['active']
            ];
        }
    
        if ($data > 0) {
            $this->model->update($id, $data);

            $response = [
                'status' => true,
                'message' => 'Berhasil memperbarui data',
                'data' => []
            ];
            return $this->respond($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal memperbarui data',
                'data' => []
            ];
            return $this->respond($response, 200);
        }
            
        
    }

}
