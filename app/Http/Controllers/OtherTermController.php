<?php

namespace App\Http\Controllers;

use App\contact;
use App\expense;
use App\other_term;
use App\purchase_delivery;
use App\purchase_invoice;
use App\purchase_order;
use App\purchase_quote;
use App\sale_delivery;
use App\sale_invoice;
use App\sale_order;
use App\sale_quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;

class OtherTermController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(other_term::get())
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.other.terms.index');
    }

    public function create()
    {
        return view('admin.other.terms.create');
    }

    public function store(Request $request)
    {
        $user               = User::find(Auth::id());
        $rules = array(
            'name'               => 'required',
            'length'             => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $share = new other_term([
                'company_id'        => $user->company_id,
                'user_id'           => Auth::id(),
                'name'              => $request->get('name'),
                'length'            => $request->get('length'),
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
        $term = other_term::find($id);

        return view('admin.other.terms.show', compact(['term']));
    }

    public function edit($id)
    {
        $term = other_term::find($id);

        return view('admin.other.terms.edit', compact(['term']));
    }

    public function update(Request $request)
    {
        $rules = array(
            'name'               => 'required',
            'length'             => 'required',
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
                'length'                  => $request->get('length'),
            );
            other_term::whereId($id)->update($form_data);
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
            $data = other_term::findOrFail($id);
            if (
                $data->sale_invoice()->exists()
                or $data->sale_order()->exists() or $data->sale_quote()->exists()
                or $data->purchase_invoice()->exists()
                or $data->purchase_order()->exists() or $data->purchase_quote()->exists()
                or $data->contact()->exists() or $data->expense()->exists()
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
