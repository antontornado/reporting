<?php 
namespace App\Models;
use App\Models\userModel;

class depoModel extends userModel{
    public function getOTDepoShinhan($kriteria){
      $asli=['@tgl1','@tgl2','@kantor'];
      $sql= str_replace($asli,$kriteria,file_get_contents(WRITEPATH.'sql/templateot.sql'));;
      $rst=$this->dbs->query($sql);
      return $rst->getResultArray();
    }
    public function getBilyetDepo(){
      $rst=$this->dbs->query(file_get_contents(WRITEPATH.'sql/nama_deposan.sql'));
      foreach($rst->getResultArray() as $data){
        $rec[]=$data['nomor_rekening'];
      }
      return $rec;
    }
}
?>
