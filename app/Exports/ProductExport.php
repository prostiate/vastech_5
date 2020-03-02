<?php

namespace App\Exports;

use App\Model\product\product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.products.products.export', [
            'products' => product::get()
        ]);
    }
}
