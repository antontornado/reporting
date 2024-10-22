<?php 
namespace App\Models;
use CodeIgniter\Model;
class linkappModel extends Model
{
    protected $dbs;
    function __construct(){
        $session=session();
        $namaBPR=$session->namaBPR;
        switch($namaBPR){
            case 'BPR Gita':
              $this->dbs=db_connect('gita');
              break;
            case 'BPR Pantura Abadi':
              $this->dbs=db_connect('pantura');
              break;  
            default:
              $this->dbs=db_connect('default');
              break;
        }
    }
    public function getRekKoran(){
        $dbs2=db_connect('xsigma');
        $sql= $this->SQLhistoriloan('0101100476','20110101','20181231');
        $rst1=$dbs2->query("SET @total=0;" );
        $rst=$dbs2->query($sql);
        return $rst;
    }
    public function getNPL(){
      $bulanLalu = strtotime("last month"); // Mendapatkan timestamp untuk bulan lalu
      $akhirBulanLalu = strtotime("last day of", $bulanLalu); // Mendapatkan timestamp untuk akhir bulan lalu
      // Format tanggal akhir bulan lalu sesuai kebutuhan
      $tanggalAkhirBulanLalu = date("Ymd", $akhirBulanLalu);     
       $query=$this->dbs->query($this->SQLNPL());
       $row=$query->getResultArray();
       $pembilang=0;
       $penyebut=1;
       foreach($row as $data){
          $pembilang=$data['npl'];
       }
       $query=$this->dbs->query("select saldo_akhir from tblsaldoacct where no_rek_pembukuan=13100 and 
                                 tgl_posting<= $tanggalAkhirBulanLalu and kode_kantor='999' ORDER BY tgl_posting DESC LIMIT 1");
       $row=$query->getResultArray();
       foreach($row as $data){
          $penyebut=$data['saldo_akhir'];
       }

       return ($pembilang/$penyebut *100);
    }
    public function getsaldoGL($posisi,$kodeGL){    
       $sql="select sum(saldo_akhir)saldo_akhir from tblsaldoacct where no_rek_pembukuan in($kodeGL) and tgl_posting<= $posisi and kode_kantor='999' group by tgl_posting ORDER BY tgl_posting DESC LIMIT 1 ";
       $query=$this->dbs->query($sql);
       $row=$query->getResultArray();
       foreach($row as $data){
          $saldo=$data['saldo_akhir'];
       }
       return $saldo;
    }
    public function getKantor($kantor){
      $listKantor= "'" . implode("','", $kantor) . "'";
      $rst=$this->dbs->query("select kode_kantor,nama_kantor from tblkantor where kode_kantor in(".$listKantor.")");
      return $rst;
    } 
    public function jumlahKantor(){
      return count($this->listKantor());
    } 
    public function listKantor(){
      $rst=$this->dbs->query("select kode_kantor,nama_kantor from tblkantor");
      return $rst->getResultArray();
    } 


    public function grafik($coa){
        $sql=str_replace('@coa',$coa,file_get_contents(WRITEPATH.'sql/card_grafik.sql'));
        $rst=$this->dbs->query($sql);
        return $rst;
    } 

    protected function SQLNPL(){
      $bulanLalu = strtotime("last month"); // Mendapatkan timestamp untuk bulan lalu
      $akhirBulanLalu = strtotime("last day of", $bulanLalu); // Mendapatkan timestamp untuk akhir bulan lalu
      $sql=str_replace('@posisiData',date("Ymd", $akhirBulanLalu),file_get_contents(WRITEPATH.'sql/card_npl.sql'));
      return $sql;
    }
}
?>
