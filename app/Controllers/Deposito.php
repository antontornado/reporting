<?php
namespace App\Controllers;
use App\Models\depoModel;
class Deposito extends Home{
	public function listOTShinhan(){
        if(!empty($this->session->namaUser)){
            $deposito= new depoModel();
            $rec=[];
            if(!empty($this->request->getPost('periode'))){ 
             
                $periode=explode('-',$this->request->getPost('periode'));
                $kantor=$this->request->getPost('kodeKantor');
                $tgl1=trim($periode[0]);
                $tgl2=trim($periode[1]);
                $kriteria=[$tgl1,$tgl2,$kantor];
                $rec=$deposito->getOTDepoShinhan($kriteria);
                //dd($kriteria);
            }
            $menu=$deposito->GetMenu($this->session->namaUser);
            $data=[
                'title'=>'List Order Transfer Bunga Deposito- Bank Shinhan',
                'controller'=>'Deposito',
                'menu'=>$menu,
                'rec'=>$rec,
                'namaUser'=>$this->session->nama,
                'namabpr'=>$this->session->namaBPR,
            ];
            
            echo view('viewOTShinhan',$data);
            /*$kriteria=[20240828,20240831];
            $rec=$deposito->getOTDepoShinhan($kriteria);
            dd($rec);*/
        }else{
                 return redirect()->to(base_url()); 
        }
        
    }
}
?>