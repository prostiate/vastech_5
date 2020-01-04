<?php

namespace App\Imports;

use App\contact;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Validator;

class ContactImport implements ToCollection, WithStartRow
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
                'account_receivable_id'     => $row[3],
                'account_payable_id'        => $row[4],
                'term_id'                   => $row[5],
                'type_vendor'               => $row[6],
                'type_customer'             => $row[7],
                'type_other'                => $row[8],
                'type_employee'             => $row[9],
                'is_limit'                  => $row[10],
                'limit_balance'             => $limit_balance,
                'current_limit_balance'     => $limit_balance,
            ]);
            $contact->save();
        }
    }

    public function startRow(): int
    {
        return 12;
    }
}
