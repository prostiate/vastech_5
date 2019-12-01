<?php

namespace App\Http\Controllers;

use App\other_transaction;
use Illuminate\Http\Request;

class OtherTransactionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            //return datatables()->of(Product::all())
            return datatables()->of(other_transaction::with('status', 'ot_contact')->get())
                ->make(true);
        }

        return view('admin.other.transactions.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(other_transaction $other_transaction)
    {
        //
    }

    public function edit(other_transaction $other_transaction)
    {
        //
    }

    public function update(Request $request, other_transaction $other_transaction)
    {
        //
    }
    
    public function destroy(other_transaction $other_transaction)
    {
        //
    }
}
