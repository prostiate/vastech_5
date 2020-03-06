<?php

namespace App\Http\Controllers;

use App\Model\construction\budget_plan_con;
use Illuminate\Http\Request;
use Validator;
use App\Model\construction\offering_letter_con;
use App\Model\construction\offering_letter_detail_con;
use App\Model\construction\project_con;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;

class ConProjectController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(project_con::get())
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" project_name="' . $data->name . '" project_number="' . $data->number . '" class="fa fa-edit edit btn btn-primary btn-sm"></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="fa fa-trash delete btn btn-danger btn-sm"></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.construction.project.index');
    }

    public function create()
    {
        return view('admin.construction.project.create');
    }

    public function store(Request $request)
    {
        $user                           = User::find(Auth::id());
        $rules = array(
            'name'                      => 'required',
            'number'                    => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $header = new project_con([
                'tenant_id'             => $user->tenant_id,
                'company_id'            => $user->company_id,
                'user_id'               => Auth::id(),
                'number'                => $request->number,
                'name'                  => $request->name,
                'status'                => 1,
            ]);
            $header->save();
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $header->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $header                             = project_con::find($id);
        return view('admin.construction.project.show', compact(['header']));
    }

    public function edit($id)
    {
        $header                             = offering_letter_con::find($id);
        $item                               = offering_letter_detail_con::with('other_status')->where('offering_letter_id', $id)->get();
        return view('admin.construction.offering_letter.edit', compact(['header', 'item']));
    }

    public function update(Request $request)
    {
        $rules = array(
            'name'                      => 'required',
            'number'                    => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id = $request->hidden_id;
            project_con::find($id)->update([
                'number'                => $request->number,
                'name'                  => $request->name,
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $header = project_con::find($id);
            $header->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
