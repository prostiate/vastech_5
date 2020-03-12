<?php

namespace App\Imports;

use App\Model\contact\contact;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Validator;

class ContactImport implements ToCollection, WithStartRow, WithMultipleSheets
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
            ])->validate();

            if ($row[10] == 1) {
                $limit_balance              = $row[11];
            } else {
                $limit_balance              = 0;
            }

            $contact = new contact([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'company_name'              => $row[1],
                'display_name'              => $row[2],
                'billing_address'           => $row[3],
                'shipping_address'          => $row[4],
                'handphone'                 => $row[5],
                'telephone'                 => $row[6],
                'account_receivable_id'     => $row[7],
                'account_payable_id'        => $row[8],
                'term_id'                   => $row[9],
                'type_vendor'               => $row[10],
                'type_customer'             => $row[11],
                'type_other'                => $row[12],
                'type_employee'             => $row[13],
                'is_limit'                  => $row[14],
                'limit_balance'             => $limit_balance,
                'current_limit_balance'     => $limit_balance,
            ]);
            $contact->save();
        }
        return 'sukses';
    }

    public function startRow(): int
    {
        return 12;
    }

    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
}
