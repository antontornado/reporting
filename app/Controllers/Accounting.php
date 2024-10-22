<?php

namespace App\Controllers;
use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Accounting extends Home
{
    public function index(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1','Laporan Keuangan');
        $sheet->setCellValue([1,3], 'kolom 1 baris 3');
        $writer = new Xlsx($spreadsheet);
      // Mengatur header HTTP untuk membuat file diunduh
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="Laporan Keuangan.xlsx"');
      header('Cache-Control: max-age=0');
      $writer->save('php://output');

    }
 }
?>