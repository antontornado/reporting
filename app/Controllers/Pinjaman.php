<?php
namespace App\Controllers;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\pinjamanModel;


class Pinjaman extends Home{
    protected $pinjamanModel;
    function __construct(){
            $this->session = session();
            $this->pinjamanModel= new pinjamanModel();
    }
    public function nominatifPinjaman(){
        if(!empty($this->session->namaUser)){
            if(!empty($this->request->getPost('posisiData'))){  
            $totkantor=count($this->request->getPost('kantor'));
            $kantorModel=$this->pinjamanModel->getKantor($this->request->getPost('kantor'));
            $record=$kantorModel->getResult('array');
            foreach($record as $baris){
                $namaKantor[]=ucwords(strtolower($baris['nama_kantor']));
            }
            $listKantor= implode(", ", $namaKantor);
            if(count($this->request->getPost('kantor'))==1){
                $namaKantor=$listKantor;
            }elseif(count($this->request->getPost('kantor'))<$this->pinjamanModel->jumlahKantor()){
                $namaKantor='Konsolidasi ('.$listKantor.')';
            }else{
                $namaKantor='Konsolidasi (ALL)';
            }
                
        
            $pinjaman=$this->pinjamanModel->getPinjaman($this->request->getPost('posisiData'),$this->request->getPost('kantor'));
            $judul = $pinjaman->getFieldNames();
            $record=$pinjaman->getResult('array');
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->getStyle('N:O')->getNumberFormat()->setFormatCode('dd-mmm-yyyy');    
            $sheet->getStyle('E:I')->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('S:X')->getNumberFormat()->setFormatCode('#,##0.00');
            $sheet->getStyle('AA:AA')->getNumberFormat()->setFormatCode('#,##0.00');        
            $sheet->getStyle('M:M')->getNumberFormat()->setFormatCode('0.00%');       
            $sheet->getStyle('1:3')->getFont()->setBold(true);
            $sheet->getStyle('A3:AB3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A3:AB3')->getFill()->getStartColor()->setRGB('c6eaf2');
            $sheet->getStyle('A1')->getFont()->setSize(16);
            $sheet->setCellValue('A1','Nominatif Pinjaman '.$namaKantor);
            $sheet->setCellValue('A2', 'Posisi Data:'. date("j F Y", strtotime($this->request->getPost('posisiData'))));
            //atur lebar kolom
            $columnWidths = [16,13,16,36,20,20,20,20,20,12,12,20,15,15,15,15,25,20,20,20,20,20,20,20,20,20,20,20];
            $col=1;
            foreach ($judul as $fieldname){
            $sheet->setCellValue([$col,3], $fieldname);
            $sheet->getColumnDimensionByColumn($col)->setWidth($columnWidths[$col-1]);
            $col++;
            }
            $line=4;
            foreach($record as $baris){
                $col=1;
                foreach ($judul as $fieldname){
                    $sheet->setCellValue([$col,$line], $baris[$fieldname]);
                    $col++;
                }
                $line++;
            }
            $sheet->getStyle('A3:AB'.$line-1)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle('A3:AB'.$line-1)->getBorders()->getAllBorders()->getColor()->setRGB('000000'); 
            $writer = new Xlsx($spreadsheet);
        
            // Mengatur header HTTP untuk membuat file diunduh
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="NominatifPinjaman' . $this->request->getPost('posisiData') . '.xlsx"');
            header('Cache-Control: max-age=0');

            // Output file ke output buffer
            $writer->save('php://output');
            }
            $menu=$this->pinjamanModel->GetMenu($this->session->namaUser);
            $data=[
                'namaUser'=>$this->session->nama,
                'title'=>'Download Data Nominatif Pinjaman',
                'controller'=>'Nominatif Pinjaman',
                'kantor'=>$this->pinjamanModel->listKantor(),
                'listFields'=>$this->pinjamanModel->namaFields(),
                'namabpr'=>$this->session->namaBPR,
                'menu'=>$menu
            ];
            echo view('nominatifkredit',$data);
        }
        else{
            return redirect()->to(base_url()); 
        }
    
    }
    public function rekKoran(){
        $rec=$this->pinjamanModel->getRekKoran();
        dd($rec->getResultArray());
    }

}
?>