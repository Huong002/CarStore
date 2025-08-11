<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
   public function index()
   {
      // lay thong tin cua cac bai blog truyen xuong blog (views)
      return view('blog');
   }
   
   

   
}
