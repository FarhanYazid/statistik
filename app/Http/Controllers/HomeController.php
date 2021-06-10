<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function PHPUnit\Framework\returnSelf;

class HomeController extends Controller
{
    public function index() //Menampilkan halaman home
    {
        $tittle = "Mata Kuliah Statistik";
        return view('home', compact('tittle'));
    }
}
