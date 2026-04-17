<?php

namespace App\Http\Controllers;

use App\Models\Supplier;


class SupplierController extends Controller
{
    public function supplier()
    {
        $supplier = Supplier::all();
        return view('admin.supplier.index', compact($supplier));
    }
}
