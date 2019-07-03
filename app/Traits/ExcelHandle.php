<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Traits;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Description of ArrayToExcel
 *
 * @author Sucre.xu
 */
trait ExcelHandle
{
    /**
     * input data to excel file and output for download
     * @param  Array $data
     * data to be input to excel
     * @param  String $fileName
     * name for excel file to be output
     * @param  Array $title
     * excel title, first row of the excel file
     * @param String $startCell
     * data fill start at this cell
     * @return void
     */
    public function arrayToExcel(Array $data, $fileName = 'data', Array $title = [], $startCell = 'A1')
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)->fromArray($title)
                ->fromArray($data, null, $startCell);
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

}
