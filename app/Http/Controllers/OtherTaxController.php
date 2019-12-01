<?php

namespace App\Http\Controllers;

use App\cashbank_item;
use App\other_tax;
use Illuminate\Http\Request;
use Validator;
use App\coa;
use App\purchase_delivery_item;
use App\purchase_invoice_item;
use App\purchase_order_item;
use App\purchase_quote_item;
use App\sale_delivery_item;
use App\sale_invoice_item;
use App\sale_order_item;
use App\sale_quote_item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OtherTaxController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(other_tax::with('coa_sell', 'coa_buy')->where('id', '>', 0)->get())
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.other.taxes.index');
    }

    public function create()
    {
        $coa            = coa::where('coa_category_id', [10, 13, 16, 14, 17])->get();
        $coa2            = coa::where('coa_category_id', [2, 13, 16, 14, 17])->get();
        return view('admin.other.taxes.create', compact(['coa', 'coa2']));
    }

    public function store(Request $request)
    {
        $rules = array(
            'name'                       => 'required',
            'effective_rate'             => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            if ($request->has('witholding')) {
                $witholding = 1;
            } else {
                $witholding = 0;
            };

            $share = new other_tax([
                'user_id'                   => Auth::id(),
                'name'                  => $request->get('name'),
                'rate'                  => $request->get('effective_rate'),
                'sell_tax_account'      => $request->get('sell_tax_account'),
                'buy_tax_account'       => $request->get('buy_tax_account'),
            ]);
            $share->save();
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $share->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $tax = other_tax::find($id);

        return view('admin.other.taxes.show', compact(['tax']));
    }

    public function edit($id)
    {
        $tax = other_tax::find($id);

        return view('admin.other.taxes.edit', compact(['tax']));
    }

    public function update(Request $request)
    {
        $rules = array(
            'name'                       => 'required',
            'effective_rate'             => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id = $request->hidden_id;
            if ($request->has('witholding')) {
                $witholding = 1;
            } else {
                $witholding = 0;
            };

            $form_data = array(
                'name'                  => $request->get('name'),
                'rate'                  => $request->get('effective_rate'),
                'witholding'            => $witholding,
                'sell_tax_account'      => $request->get('sell_tax_account'),
                'buy_tax_account'       => $request->get('buy_tax_account'),
            );
            other_tax::whereId($id)->update($form_data);
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = other_tax::findOrFail($id);
            if (
                sale_delivery_item::find($id) or sale_invoice_item::find($id)
                or sale_order_item::find($id) or sale_quote_item::find($id)
                or purchase_delivery_item::find($id) or purchase_invoice_item::find($id)
                or purchase_order_item::find($id) or purchase_quote_item::find($id)
                or cashbank_item::find($id) or coa::find($id)
            ) {
                DB::rollBack();
                return response()->json(['errors' => 'Cannot delete product with transactions!']);
            }
            $data->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
