<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelPegawai;
class Pegawai extends BaseController
{
    use ResponseTrait;
    function __construct()
    {
        $this->model = new ModelPegawai();
    }
    public function index()
    {
        $data = $this->model->orderBy('nama','asc')->findAll();
        return $this->respond($data, 200);
    }

    public function show ($id=null)
    {
        $data = $this->model->where('id',$id)->findAll();
        if($data){
            return $this->respond($data,200);
        }else{
            return $this->failNotFound("Data tidak ditemukan untuk id $id");
        }
    }

    public function create(){
        // $data=[
        //     'nama'=>$this->request->getVar('nama'),
        //     'email'=>$this->request->getVar('email'),
        // ];
        $data=$this->request->getPost();
        // print_r($data);die();
               // $this->model->save($data);
        if(!$this->model->save($data)){
            return $this->fail($this->model->errors());
        }
        $response=[
            'status'=>200,
            'error'=>null,
            'messeges'=>[
                'success'=>'Berhasil memasukan data pegawai'
            ],
        ];
        return $this->respond($response); 
    }
    public function update($id=null)
    {
        $data=$this->request->getRawInput();
       
        $data['id']=$id;
         
        $isExists = $this->model->where('id',$id)->findAll();
        // print_r($isExists);die();
        if(!$isExists){
            return $this->failNotFound("Data tidak ditemukan untuk id $id");
        }

        if(!$this->model->save($data)){ //kalo ada error
            return $this->fail($this->model->errors());
        }
        $response =[
            'status'=>200,
            'error'=>null,
            'messages'=>[
                'success'=>"dapa pegawai dengan id $id berhasil di update"
            ]
            ];
            return $this->respond($response);
    }

    public function delete($id=null){
          $isExists = $this->model->where('id',$id)->findAll();
         if($isExists){
           $this->model->delete($id);
           $response=[
            'status'=>200,
            'error'=>null,
            'messages'=>[
                'success'=>"data berhasil dihapus"
            ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Data tidak ditmukan'); 
        }
    }
}
