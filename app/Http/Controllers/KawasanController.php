<?php

namespace App\Http\Controllers;

use App\Models\Kawasan;


class KawasanController extends Controller
{
    public function index() {
        $kawasan = Kawasan::all();
        return view('admin.kawasan.index', compact('kawasan'));
    }
}
