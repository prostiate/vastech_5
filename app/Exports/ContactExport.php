<?php

namespace App\Exports;

use App\Model\contact\contact;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ContactExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.contacts.export', [
            'contacts' => contact::get()
        ]);
    }
}

