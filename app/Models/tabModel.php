<?php 
namespace App\Models;
use App\Models\userModel;

class tabModel extends userModel{
    public function getTabungan(){
      $rst=$this->dbs->query(file_get_contents(WRITEPATH.'sql/nama_penabung.sql'));
      foreach($rst->getResultArray() as $data){
        $rec[]=$data['nomor_rekening'];
      }
      return $rec;
    }
}
?>
