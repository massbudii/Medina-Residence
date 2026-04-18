<?php

namespace App\Http\Controllers;

use App\Models\Supplier;


class SupplierController extends Controller
{
    public function index()
        {
            $supplier = Supplier::all();
            return view('admin.supplier.index', compact('supplier'));
        }

}
