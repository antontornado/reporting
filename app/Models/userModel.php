<?php 
namespace App\Models;
use App\Models\linkappModel;

class userModel extends linkappModel{
	public function Login($user,$password){
      $dbs2=db_connect('xrep');
      $sql="select * from tbluser where user_id='".$user."'";
      $rst=$dbs2->query($sql);
      $row=$rst->getResultArray();
      $pass='';
      $bpr='';
      $user='';
      foreach($row as $data){
        $pass=$data['user_password'];
        $bpr=$data['nama_bpr'];
        $user=$data['user_id'];
        $nama=$data['nama_user'];
      }
      if($password==$pass){
        $output=[$user,$bpr,$nama];
        return $output;
      }else{
        return 'gagal';
      }
      
    }
  public function GetMenu($user){
      $dbs2=db_connect('xrep');
      $sql="select * from tblmenu where user_id='".$user."'";
      $rst=$dbs2->query($sql);
      return $rst->getResultArray();
    }
}
?>