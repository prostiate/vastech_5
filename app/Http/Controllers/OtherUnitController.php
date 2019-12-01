<?php

namespace App\Http\Controllers;

use App\other_unit;
use App\product;
use App\purchase_delivery_item;
use App\purchase_invoice_item;
use App\purchase_order_item;
use App\purchase_quote_item;
use App\sale_delivery_item;
use App\sale_invoice_item;
use App\sale_order_item;
use App\sale_quote_item;
use App\wip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;

class OtherUnitController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(other_unit::get())
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.other.units.index');
    }

    public function create()
    {
        return view('admin.other.units.create');
    }

    public function store(Request $request)
    {
        $rules = array(
            'name'               => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $share = new other_unit([
                'user_id'                   => Auth::id(),
                'name'                      => $request->get('name'),
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
        $unit = other_unit::find($id);

        return view('admin.other.units.show', compact(['unit']));
    }

    public function edit($id)
    {
        $unit = other_unit::find($id);

        return view('admin.other.units.edit', compact(['unit']));
    }

    public function update(Request $request)
    {
        $rules = array(
            'name'               => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id = $request->hidden_id;
            $form_data = array(
                'name'                  => $request->get('name'),
            );
            other_unit::whereId($id)->update($form_data);
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
            $data = other_unit::findOrFail($id);
            if (
                sale_delivery_item::find($id) or sale_invoice_item::find($id)
                or sale_order_item::find($id) or sale_quote_item::find($id)
                or purchase_delivery_item::find($id) or purchase_invoice_item::find($id)
                or purchase_order_item::find($id) or purchase_quote_item::find($id)
                or cashbank_item::find($id) or product::find($id) or wip::find($id)
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
