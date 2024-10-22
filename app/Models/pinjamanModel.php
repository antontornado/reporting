<?php 
namespace App\Models;
use App\Models\userModel;

class pinjamanModel extends userModel{
    public function getPinjaman($posisiData,$kantor){
      $sql= $this->SQLPinjaman(date("Ymd", strtotime($posisiData)),$kantor);
      $rst=$this->dbs->query($sql);
      return $rst;
    }

    public function namaFields(){
        $sql= $this->SQLPinjaman(date("Ymd"),array("001"));
        $rst=$this->dbs->query($sql);
        return $rst->getFieldNames();
    }

    protected function SQLPinjaman($posisiData,$kantor){
      $listKantor= "'" . implode("','", $kantor) . "'";
      $sql=str_replace('@posisiData',$posisiData,file_get_contents(WRITEPATH.'sql/nominatif_pinjaman.sql'));
      $sql.= " where kode_kantor in(".$listKantor.")";
      $sql.=" order by kode_kantor,nama_debitur";
      return $sql;
    }
}
?>
