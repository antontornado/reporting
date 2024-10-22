<?php

namespace App\Controllers;
use App\Models\userModel;

class Home extends BaseController
{
    protected $linkappModel;
    public $session;
    function __construct(){
            $this->session = session();
            $this->linkappModel= new userModel();
    }
    public function index(){
        if (!empty($this->session->namaUser)){
            $menu=$this->linkappModel->GetMenu($this->session->namaUser);
            $nasabah=0;
            $bulanLalu = strtotime("last month"); // Mendapatkan timestamp untuk bulan lalu
            $akhirBulanLalu = strtotime("last day of", $bulanLalu);
            $npl=$this->linkappModel->getNPL();
            $laba=$this->linkappModel->getsaldoGL(date("Ymd", $akhirBulanLalu),30602);
            $kredit=$this->linkappModel->getsaldoGL(date("Ymd", $akhirBulanLalu),'13110,13120,13130');
            $dpk=$this->linkappModel->getsaldoGL(date("Ymd", $akhirBulanLalu),'20411,20420,20510,20520');
            $closed=0;
            $data=[
                
                'namaUser'=>$this->session->nama,
                'title'=>'Dashboard',
                'controller'=>'Dashboard',
                'nasabah'=>$nasabah,
                'namabpr'=>$this->session->namaBPR,
                'kredit'=>number_format($kredit/1000000000,2),
                'dpk'=>number_format($dpk/1000000000,2),
                'laba'=>number_format($laba/1000000000,2),
                'npl'=>number_format($npl,2),
                'menu'=>$menu,
                'closed'=>$closed
            ];
            echo view('dashboard',$data);
            //dd ($this->session->namaUser) ;
        }else{
            return(view('login'));
        }
    }
    public function starter(){
            if (!empty($this->session->namaUser)){
                $menu=$this->linkappModel->GetMenu($this->session->namaUser);
                $rec=$this->linkappModel->grafik(13100);
                $judul = $rec->getFieldNames();
                $record=$rec->getResult('array');
                $rec=$this->linkappModel->grafik(20000);
                $record2=$rec->getResult('array');
                $nasabah=0;
                $npl=$this->linkappModel->getNPL();
                $laba=$this->linkappModel->getsaldoGL(20240630,30602);
                $closed=0;
                $data=[
                    'title'=>'Dashboard',
                    'controller'=>'Dashboard',
                    'listFields'=>$judul,
                    'saldo'=>$record,
                    'saldo2'=>$record2,
                    'nasabah'=>$nasabah,
                    'bpr'=>$this->session->namaBPR,
                    'laba'=>number_format($laba/1000000,2),
                    'npl'=>number_format($npl,2),
                    'menu'=>$menu,
                    'closed'=>$closed
                ];
                echo view('home',$data);
                //dd ($this->session->namaUser) ;
            }else{
                return(view('login'));
            }
    }
    public function rekKoran(){
        $rec=$this->linkappModel->getRekKoran();
        dd($rec->getResultArray());
    }

    public function blank(){
        return(view('template/index'));
    }
    
    public function bacapath(){
        $data=str_replace('$tanggalAkhirBulanLalu',20240630,file_get_contents(WRITEPATH.'sql\card_npl.sql'));
        return $data;
    }

    public function genZip()
    {
         // Generate file contents
        $file1_content = "File 1 content";
        $file2_content = "File 2 content";

        // Path to save files temporarily
        $temp_dir = WRITEPATH . 'uploads/';

        // Create FileWriter instance
         // Write content to files
        file_put_contents($temp_dir . 'file1.txt', $file1_content);
        file_put_contents($temp_dir . 'file2.txt', $file2_content);
        // Create zip archive
        $zip = new \ZipArchive();
        $zipFilename = $temp_dir . 'files.zip';
        $zip->open($zipFilename, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        // Add files to zip
        $zip->addFile($temp_dir . 'file1.txt', 'file1.txt');
        $zip->addFile($temp_dir . 'file2.txt', 'file2.txt');

        // Close zip
        $zip->close();

        // Set headers for zip file
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=files.zip');
        header('Content-Length: ' . filesize($zipFilename));
        readfile($zipFilename);

        // Delete temporary files
        unlink($temp_dir . 'file1.txt');
        unlink($temp_dir . 'file2.txt');
        unlink($zipFilename);
    }
}
?>
