<?php

namespace App\Http\Controllers;

use App\Model\other\other_payment_method;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;

class OtherPaymentMethodController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            //return datatables()->of(Product::all())
            return datatables()->of(other_payment_method::get())
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.other.payment_methods.index');
    }

    public function create()
    {
        return view('admin.other.payment_methods.create');
    }

    public function store(Request $request)
    {
        $user               = User::find(Auth::id());
        $rules = array(
            'name'       => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $share = new other_payment_method([
                'company_id'        => $user->company_id,
                'user_id'                   => Auth::id(),
                'name'   => $request->get('name'),
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
        $unit = other_payment_method::find($id);

        return view('admin.other.payment_methods.show', compact(['unit']));
    }

    public function edit($id)
    {
        $unit = other_payment_method::find($id);

        return view('admin.other.payment_methods.edit', compact(['unit']));
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
            other_payment_method::whereId($id)->update($form_data);
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
            $data = other_payment_method::findOrFail($id);
            if (
                $data->sale_payment()->exists()
                or $data->purchase_payment()->exists()
            ) {
                DB::rollBack();
                return response()->json(['errors' => 'Cannot delete payment method with transactions!']);
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
