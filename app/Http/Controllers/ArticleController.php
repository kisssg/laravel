<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ArticleController extends Controller
{
	//show article https://phpinternals.news/4
    public function show($id){
    /* 
     * Simple sample
    	$spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	$sheet->setCellValue('A1', 'Hello World !');
    	
    	$writer = new Xlsx($spreadsheet);
    	$writer->save('hello world.xlsx'); */
    	
    	return view('article/show')->withArticle(Article::with('hasManyComments')->find($id));
    }
}
