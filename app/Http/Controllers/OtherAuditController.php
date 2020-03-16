<?php

namespace App\Http\Controllers;

use App\Model\other\audit;

class OtherAuditController extends Controller
{
    public function index()
    {
        /*if (request()->ajax()) {
            return datatables()->of(audit::with('user')->get())
                ->make(true);
        }*/
        $audits     = audit::with('user')->orderBy('created_at', 'desc')->paginate('15');

        return view('admin.other.audits.index', compact(['audits']));
    }

    public function create()
    { }

    public function store()
    { }

    public function show($id)
    { }

    public function edit($id)
    { }

    public function update()
    { }

    public function destroy($id)
    { }
}
