<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
class TestController extends Controller{
	public function show($id){
		return view("404");
	}
}