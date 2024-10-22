<?php
namespace App\Controllers;
use App\Models\nasabahModel;
use App\Models\depoModel;
use App\Models\tabModel;
class Nasabah extends Home{
	public function historiTransaksiNasabah(){
        if(!empty($this->session->namaUser)){
            $nasabah= new nasabahModel();
            $rec=[];
            $postingan=['periode'=>'','namaNasabah'=>'','jenisNasabah'=>'2'];
            if(!empty($this->request->getPost('namaNasabah'))&&!empty($this->request->getPost('periode'))){ 
                $cif=explode('-',$this->request->getPost('namaNasabah'));
                $jenisNasabah=$this->request->getPost('jenisNasabah');
                $periode=explode('-',$this->request->getPost('periode'));
                $tgl1=trim($periode[0]);
                $tgl2=trim($periode[1]);
                $kriteria=[$cif[0],$jenisNasabah,$tgl1,$tgl2];
                $rec=$nasabah->getHistory($kriteria)->getResultArray();
                $postingan=$this->request->getPost();
            }
            $menu=$nasabah->GetMenu($this->session->namaUser);
            $data=[
                'namaUser'=>$this->session->nama,
                'namabpr'=>$this->session->namaBPR,
                'title'=>'Histori Transaksi Nasabah',
                'controller'=>'Nasabah',
                'kantor'=>$nasabah->listKantor(),
                'menu'=>$menu,
                'individual'=>$nasabah->getIndividual(),
                'institusi'=>$nasabah->getInstitusi(),
                'rec'=>$rec,
                'postingan'=>$postingan
            ];
            echo view('rekapTxNasabah',$data);
        }else{
                 return redirect()->to(base_url()); 
        }
        
    }
    public function spesimenNasabah(){
        if(!empty($this->session->namaUser)){
        $nasabah= new nasabahModel();
        $depo= new depoModel();
        $tab=new tabModel();
        $menu=$nasabah->GetMenu($this->session->namaUser);
        $data=[
                'namaUser'=>$this->session->nama,
                'namabpr'=>$this->session->namaBPR,
                'controller'=>'Nasabah',
                'title'=>'Spesimen Nasabah',
                'menu'=>$menu,
                'depo'=>$depo->getBilyetDepo(),
                'tab'=>$tab->getTabungan(),
                'spesimen'=>$nasabah->getSpesimen($this->session->namaBPR)
            ];
        echo view('spesimenNasabah',$data);
        }else{
           return redirect()->to(base_url()); 
        }
    }
    public function hapusSpesimen($id=''){
    	$nasabah= new nasabahModel();
    	$hapus=$nasabah->hapusSpesimen($id);
    	return redirect()->to(base_url('/Nasabah/SpesimenNasabah'));
    }
    public function uploadSpesimen()
    {
        $response = ['success' => false, 'message' => ''];

        $jenisRekening = $this->request->getPost('JenisRekening');
        $nomorRekening = $this->request->getPost('nomorRekening');
        $file = $this->request->getFile('file');

        if ($file->isValid() && !$file->hasMoved()) {
            $noRek = explode('-', $nomorRekening);
            $rek = $noRek[0];
            
            // Gunakan timestamp dan nomor rekening untuk nama file
            $timestamp = date('Ymdhms');
            $extension = $file->getExtension();
            $newName = $rek. '_' . $timestamp . '.' . $extension;
            $uploadPath = FCPATH . 'uploads/spesimen/'.$this->session->namaBPR.'/'. $jenisRekening . '/';
            //$uploadPath = '/home/SHARE/spesimen/'.$this->session->namaBPR.'/'. $jenisRekening . '/';

            if ($file->move($uploadPath, $newName)) {
                $filePath = 'uploads/spesimen/' .$this->session->namaBPR.'/'. $jenisRekening . '/' . $newName;
                //$filePath = '/home/SHARE/spesimen/' .$this->session->namaBPR.'/'. $jenisRekening . '/' . $newName;


                // Save to database
                $spesimenModel = new nasabahModel();
                $data = [
                    'jenis_rekening' => $jenisRekening,
                    'nomor_rekening' => $nomorRekening,
                    'nama_file' => $filePath, // Simpan hanya nama file
                    'user_id'=>$this->session->namaUser
                ];

                if ($spesimenModel->insertSpesimen($data)) {
                    $response['success'] = true;
                    $response['message'] = 'File berhasil diupload dan disimpan.';
                } else {
                    $response['message'] = 'Gagal menyimpan data ke database.';
                }
            } else {
                $response['message'] = 'Gagal mengunggah file.';
            }
        } else {
            $response['message'] = 'File tidak valid.';
        }
        
        return redirect()->to(base_url('/Nasabah/SpesimenNasabah'));
    }
    public function starter(){
        $nasabah= new nasabahModel();
        $menu=$nasabah->GetMenu($this->session->namaUser);
        $data=[
                'title'=>'Starter',
                'menu'=>$menu,
            ];
        echo view('template/dashboard',$data);
    }
}
?>
