<?php 
namespace App\Models;
use App\Models\userModel;

class nasabahModel extends userModel{
    public function getHistory($kriteria){
      $asli=['@noReg','@jenisNasabah','@posisiData1','@posisiData2'];
      $sql= str_replace($asli,$kriteria,file_get_contents(WRITEPATH.'sql/sqlhistorinasabah.sql'));;
      $rst=$this->dbs->query($sql);
      return $rst;
    }
    public function getIndividual(){
      $sql= "select CONCAT(nomor_registrasi,'-',nama_depan)nama from tblindividual where nomor_registrasi in(select nomor_registrasi from tbltabungan where is_individual=1 union select nomor_registrasi from tbldeposito where is_individual=1 union select nomor_registrasi from tblpinjaman where is_individual=1) order by nama_depan";
      $rst=$this->dbs->query($sql);
      foreach($rst->getResultArray() as $data){
        $rec[]=$data['nama'];
      }
      return $rec;
    }
    public function getInstitusi(){
      $sql= "select CONCAT(nomor_registrasi,'-',nama_institusi)nama from tblinstitusi where nomor_registrasi in(select nomor_registrasi from tbltabungan where is_individual=0 union select nomor_registrasi from tbldeposito where is_individual=0 union select nomor_registrasi from tblpinjaman where is_individual=0) order by nama_institusi";
      $rst=$this->dbs->query($sql);
      foreach($rst->getResultArray() as $data){
        $rec[]=$data['nama'];
      }
      return $rec;
    }
    public function insertSpesimen($data){
      $dbs2=db_connect('xrep');
      $dbs2->query("insert into tblspesimen (jenis_rekening,nomor_rekening,nama_file,user_id) values('".$data['jenis_rekening']."','".$data['nomor_rekening']."','".$data['nama_file']."','".$data['user_id']."')");
      return $dbs2->affectedRows();
    }
    public function hapusSpesimen($id){
    	$dbs2=db_connect('xrep');
    	$dbs2->query("delete from tblspesimen where id='".$id."'");
    	return $dbs2->affectedRows();
    }
    
    public function getSpesimen($bpr){
      $dbs2=db_connect('xrep');
      $query=$dbs2->query("select * from tblspesimen where user_id in(select user_id from tbluser where nama_bpr='".$bpr."')");
      return $query->getResultArray();
    }
}
