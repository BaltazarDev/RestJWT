<?php
 
namespace App\Controllers;
 
use App\Models\HistorialModel;
use CodeIgniter\RESTful\ResourceController;
 
class Historial extends ResourceController
{
 
    protected $modelName = 'App\Models\HistorialModel';
    protected $format = 'json';
 
    public function index()
    {
        return $this->genericResponse($this->model->findAll(), null, 200);
    }
 
    public function show($id = null)
    {
        if($id == null){
            return $this->genericResponse(null, "ID no fue encontrado", 500);
        }

        $pedido = $this->model->find($id);

        if(!$pedido){
            return $this->genericResponse(null, "El pedido no existe", 500);
        }
        else{
            return $this->genericResponse($this->model->find($id), null, 200);
        }
    }
 
    public function delete($id = null)
    {
 
        $pedido = new HistorialModel();
        $pedido->delete($id);
 
        return $this->genericResponse("Pedido No.$id eliminado", null, 200);
    }
 
    public function create()
    {
 
        $pedido = new HistorialModel();
 
        if ($this->validate('pedidos')) {
 
            $id = $pedido->insert([
                'descripcion' => $this->request->getPost('descripcion'),
                'npedimento' => $this->request->getPost('npedimento'),
                'psalida' => $this->request->getPost('psalida'),
				'pdestino' => $this->request->getPost('pdestino'),
				'estatus' => $this->request->getPost('estatus'),
				'fechapedido' => $this->request->getPost('fechapedido'),
				'hora' => $this->request->getPost('hora'),
				'image_url' => $this->request->getPost('image_url'),
            ]);
 
            return $this->genericResponse($this->model->find($id), null, 200);
        }
 
        $validation = \Config\Services::validation();
 
        return $this->genericResponse(null, $validation->getErrors(), 500);
    }
 
    public function update($id = null)
    {
 
        $pedido = new HistorialModel();

        $pedido = $this->model->find($id);

        if(!$pedido){
            return $this->genericResponse(null, "Pedido no existe", 500);
        }
 
        $data = $this->request->getRawInput();
 
        if ($this->validate('pedidos')) {
 
            if (!$pedido->get($id)) {
                return $this->genericResponse(null, array("pedido_id" => "Pedido no existe"), 500);
            }
 
            $pedido->update($id, [
                'descripcion' => $data['descripcion'],
                'npedimento' => $data['npedimento'],
                'psalida' => $data['psalida'],
				'pdestino' => $data['pdestino'],
				'estatus' => $data['estatus'],
				'fechapedido' => $data['fechapedido'],
				'hora' => $data['hora'],
				'image_url' => $data['image_url'],
            ]);
 
            return $this->genericResponse($this->model->find($id), null, 200);
        }
 
        $validation = \Config\Services::validation();
 
        return $this->genericResponse(null, $validation->getErrors(), 500);
    }
 
    private function genericResponse($data, $msj, $code)
    {
 
        if ($code == 200) {
			return $this->respond($data);
            /* return $this->respond(array(
                "data" => $data,
                "code" => $code
            ));  */
			//, 404, "No hay nada"
        } else {
            return $this->respond(array(
                "msj" => $msj,
                "code" => $code
            ));
        }
    }
}