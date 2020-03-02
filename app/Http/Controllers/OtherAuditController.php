<?php

namespace App\Http\Controllers;

use App\audit;

class OtherAuditController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(audit::get())
                ->make(true);
        }

        return view('admin.other.audits.index');
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update()
    {

    }

    public function destroy($id)
    {

    }
}
