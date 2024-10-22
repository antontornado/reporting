<?php

namespace App\Controllers;
use App\Models\linkappModel;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class repslik extends BaseController
{
    protected $linkappModel;
    public function index(){
        return(view('template/blank'));
    }
    public function generator(){
        $this->linkappModel= new linkappModel();
        if(!empty($this->request->getPost('posisiData'))){  
         // Generate file contents
        $file1_content = "File 1 content";
        $file2_content = "File 2 content";

        // Path to save files temporarily
        $temp_dir = WRITEPATH . 'uploads/';

        // Create FileWriter instance
         // Write content to files
        file_put_contents($temp_dir . '0103.601302.2024.04.D01.1.txt', $file1_content);
        file_put_contents($temp_dir . '0103.601302.2024.04.D02.1.txt', $file2_content);
        file_put_contents($temp_dir . '0103.601302.2024.04.F01.1.txt', $file2_content);
        file_put_contents($temp_dir . '0103.601302.2024.04.F02.1.txt', $file2_content);
        // Create zip archive
        $zip = new \ZipArchive();
        $zipFilename = $temp_dir . 'SLIK20240430.zip';
        $zip->open($zipFilename, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        // Add files to zip
        $zip->addFile($temp_dir . '0103.601302.2024.04.D01.1.txt', '0103.601302.2024.04.D01.1.txt');
        $zip->addFile($temp_dir . '0103.601302.2024.04.D02.1.txt', '0103.601302.2024.04.D02.1.txt');
        $zip->addFile($temp_dir . '0103.601302.2024.04.F01.1.txt', '0103.601302.2024.04.F01.1.txt');
        $zip->addFile($temp_dir . '0103.601302.2024.04.F02.1.txt', '0103.601302.2024.04.F02.1.txt');

        // Close zip
        $zip->close();

        // Set headers for zip file
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=SLIK20240430.zip');
        header('Content-Length: ' . filesize($zipFilename));
        readfile($zipFilename);

        // Delete temporary files
        unlink($temp_dir . '0103.601302.2024.04.D01.1.txt');
        unlink($temp_dir . '0103.601302.2024.04.D02.1.txt');
        unlink($temp_dir . '0103.601302.2024.04.F01.1.txt');
        unlink($temp_dir . '0103.601302.2024.04.F02.1.txt');
        unlink($zipFilename);
       }
      
        $data=[
            'title'=>'Create File Slik',
            'controller'=>'SLIK',
            'kantor'=>$this->linkappModel->listKantor(),
            'listFields'=>$this->linkappModel->namaFields()
        ];
        echo view('slikGenerator',$data);
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
        $zipFilename = $temp_dir . 'SLIK20240430.zip';
        $zip->open($zipFilename, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        // Add files to zip
        $zip->addFile($temp_dir . 'file1.txt', 'file1.txt');
        $zip->addFile($temp_dir . 'file2.txt', 'file2.txt');

        // Close zip
        $zip->close();

        // Set headers for zip file
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=SLIK20240430.zip');
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
        $zipFilename = $temp_dir . 'SLIK20240430.zip';
        $zip->open($zipFilename, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        // Add Excel files to zip
        $zip->addFile($temp_dir . 'excel1.xlsx', 'excel1.xlsx');
        $zip->addFile($temp_dir . 'excel2.xlsx', 'excel2.xlsx');

        // Close zip
        $zip->close();

        // Set headers for zip file
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=SLIK20240430.zip');
        header('Content-Length: ' . filesize($zipFilename));
        readfile($zipFilename);

        // Delete temporary files
        unlink($temp_dir . 'excel1.xlsx');
        unlink($temp_dir . 'excel2.xlsx');
        unlink($zipFilename);
    }
}
