<?php
namespace App\Controllers;
use App\Models\userModel;
class Users extends Home{
	public function login(){
        if (!empty($this->request->getPost('namauser'))){
            $user= new userModel();
            $rec=$user->login($this->request->getPost('namauser'),hash('sha256',$this->request->getPost('password')));
            if($rec!='gagal'){
                $this->session = session();
                $this->session->set('namaUser',$rec[0]);
                $this->session->set('namaBPR',$rec[1]);
                $this->session->set('nama',$rec[2]);
                return redirect()->to(base_url()); 
            }else{
                $data=['statusError'=>'Login Gagal'];
                echo view('login',$data);
            }
        }
        
    }
    public function logout(){
        $this->session = session();
        $this->session->remove('namaUser');
        $this->session->remove('namaBPR');
        $this->session->remove('nama');
        return redirect()->to(base_url()); 
    }
}