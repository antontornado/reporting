<?php

namespace App\Controllers;
use App\Models\linkappModel;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends BaseController
{
    protected $linkappModel;
    public function index(){
        return(view('template/blank'));
    }
    public function nominatifPinjaman(){
        $this->linkappModel= new linkappModel();
        if(!empty($this->request->getPost('posisiData'))){  
        $totkantor=count($this->request->getPost('kantor'));
        $kantorModel=$this->linkappModel->getKantor($this->request->getPost('kantor'));
        $record=$kantorModel->getResult('array');
        foreach($record as $baris){
            $namaKantor[]=ucwords(strtolower($baris['nama_kantor']));
        }
        $listKantor= implode(", ", $namaKantor);
        if(count($this->request->getPost('kantor'))==1){
            $namaKantor=$listKantor;
        }elseif(count($this->request->getPost('kantor'))<$this->linkappModel->jumlahKantor()){
            $namaKantor='Konsolidasi ('.$listKantor.')';
        }else{
            $namaKantor='Konsolidasi (ALL)';
        }
              
        
        $pinjaman=$this->linkappModel->getPinjaman($this->request->getPost('posisiData'),$this->request->getPost('kantor'));
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
      
        $data=[
            'title'=>'Download Data Nominatif Pinjaman',
            'controller'=>'Nominatif Pinjaman',
            'kantor'=>$this->linkappModel->listKantor(),
            'listFields'=>$this->linkappModel->namaFields()
        ];
        echo view('nominatifkredit',$data);
    }
    public function tespost(){
        dd ($this->request->getPost());
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
    public function genZip2(){
     // Generate Excel files
        $spreadsheet1 = new Spreadsheet();
        $sheet1 = $spreadsheet1->getActiveSheet();
        $sheet1->setCellValue('A1', 'Hello');
        $sheet1->setCellValue('B1', 'World');
        
        $spreadsheet2 = new Spreadsheet();
        $sheet2 = $spreadsheet2->getActiveSheet();
        $sheet2->setCellValue('A1', 'Foo');
        $sheet2->setCellValue('B1', 'Bar');

        // Path to save files temporarily
        $temp_dir = WRITEPATH . 'uploads/';

        // Write Excel files to temporary folder
        $xlsxWriter = new Xlsx($spreadsheet1);
        $xlsxWriter->save($temp_dir . 'excel1.xlsx');

        $xlsxWriter = new Xlsx($spreadsheet2);
        $xlsxWriter->save($temp_dir . 'excel2.xlsx');

        // Create zip archive
        $zip = new \ZipArchive();;
        $zipFilename = $temp_dir . 'files.zip';
        $zip->open($zipFilename, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        // Add Excel files to zip
        $zip->addFile($temp_dir . 'excel1.xlsx', 'excel1.xlsx');
        $zip->addFile($temp_dir . 'excel2.xlsx', 'excel2.xlsx');

        // Close zip
        $zip->close();

        // Set headers for zip file
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=files.zip');
        header('Content-Length: ' . filesize($zipFilename));
        readfile($zipFilename);

        // Delete temporary files
        unlink($temp_dir . 'excel1.xlsx');
        unlink($temp_dir . 'excel2.xlsx');
        unlink($zipFilename);
    }
}
