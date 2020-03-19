<?php

namespace App\Http\Controllers;

use App\Model\other\other_product_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;

class OtherProductCategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            //return datatables()->of(Product::all())
            return datatables()->of(other_product_category::get())
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.other.product_categories.index');
    }

    public function create()
    {
        return view('admin.other.product_categories.create');
    }

    public function store(Request $request)
    {
        $user               = User::find(Auth::id());
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
            $share = new other_product_category([
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'name'                  => $request->get('name'),
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
        $unit = other_product_category::find($id);

        return view('admin.other.product_categories.show', compact(['unit']));
    }

    public function edit($id)
    {
        $unit = other_product_category::find($id);

        return view('admin.other.product_categories.edit', compact(['unit']));
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
            other_product_category::whereId($id)->update($form_data);
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $user       = User::find(Auth::id());
        $cs         = company_setting::where('company_id', $user->company_id)->first();
        if ($cs->company_id == 5) {
            if(Auth::id() != 999999){
                return redirect('/dashboard');
            }
        }
        DB::beginTransaction();
        try {
            $data = other_product_category::findOrFail($id);
            if (
                $data->product()->exists()
            ) {
                DB::rollBack();
                return response()->json(['errors' => 'Cannot delete product category with transactions!']);
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
