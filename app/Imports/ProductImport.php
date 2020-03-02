<?php

namespace App\Imports;

use App\Model\product\product;
use App\User;
use App\Model\warehouse\warehouse;
use App\Model\warehouse\warehouse_detail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Validator;

class ProductImport implements ToCollection, WithStartRow, WithMultipleSheets
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $user                                       = User::find(Auth::id());
        foreach ($rows as $row) {
            Validator::make($rows->toArray(), [
                '*.1' => 'required',
                '*.2' => 'required',
                '*.3' => 'required',
                '*.4' => 'required',
                '*.5' => 'required',
                '*.6' => 'required',
                '*.7' => 'required',
                '*.8' => 'required',
                '*.9' => 'required',
                '*.10' => 'required',
                '*.11' => 'required',
                '*.12' => 'required',
                '*.13' => 'required',
                '*.14' => 'required',
                '*.15' => 'required',
                '*.16' => 'required',
            ])->validate();

            $product = new product([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'code'                      => $row[1],
                'name'                      => $row[2],
                'other_product_category_id' => $row[3],
                'other_unit_id'             => $row[4],
                'desc'                      => $row[5],
                'is_buy'                    => $row[6],
                'buy_price'                 => $row[7],
                'buy_tax'                   => $row[8],
                'buy_account'               => $row[9],
                'is_sell'                   => $row[10],
                'sell_price'                => $row[11],
                'sell_tax'                  => $row[12],
                'sell_account'              => $row[13],
                'is_track'                  => $row[14],
                'min_qty'                   => $row[15],
                'default_inventory_account' => $row[16],
            ]);
            $product->save();

            $check_warehouse                    = warehouse::get();
            foreach ($check_warehouse as $cw) {
                warehouse_detail::create([
                    'warehouse_id'              => $cw->id,
                    'product_id'                => $product->id,
                    'qty_in'                    => 0,
                    'qty_out'                   => 0,
                    'type'                      => 'initial qty',
                ]);
            }
        }

        /*return new product([
            'code' => $row[1],
            'name' => $row[2],
            'other_product_category_id' => $row[3],
            'other_unit_id' => $row[4],
            'desc' => $row[5],
            'is_buy' => $row[6],
            'buy_price' => $row[7],
            'buy_tax' => $row[8],
            'buy_account' => $row[9],
            'is_sell' => $row[10],
            'sell_price' => $row[11],
            'sell_tax' => $row[12],
            'sell_account' => $row[13],
            'is_track' => $row[14],
            'min_qty' => $row[15],
            'default_inventory_account' => $row[16],
        ]);*/
    }

    public function startRow(): int
    {
        return 14;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
}
