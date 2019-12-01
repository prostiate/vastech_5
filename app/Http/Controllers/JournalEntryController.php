<?php

namespace App\Http\Controllers;

use App\coa;
use App\journal_entry;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JournalEntryController extends Controller
{

    public function index()
    {
        return view('admin.accounts.index');
    }

    public function create()
    {
        $number = journal_entry::max('number');
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;
        $today  = Carbon::today()->toDateString();
        $coa    = coa::get();
        return view('admin.journal_entries.create', compact(['today', 'trans_no', 'coa']));
    }

    public function store(Request $request)
    {
        
    }

    public function show()
    {
        return view('admin.journal_entries.show');
    }

    public function edit()
    {
        $number = journal_entry::max('number');
        if ($number == 0)
            $number = 10000;
        $trans_no = $number + 1;
        $today  = Carbon::today()->toDateString();
        $coa    = coa::get();
        return view('admin.journal_entries.edit', compact(['today', 'trans_no', 'coa']));
    }


    public function update(Request $request)
    {
        
    }


    public function destroy($id)
    {
        
    }
}
