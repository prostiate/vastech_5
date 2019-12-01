<?php

namespace App\Imports;

use App\product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new product([
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
        ]);
    }
    public function startRow(): int
    {
        return 13;
    }
}
