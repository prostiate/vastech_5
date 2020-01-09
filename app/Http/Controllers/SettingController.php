<?php

namespace App\Http\Controllers;

use App\coa;
use App\company_logo;
use App\company_setting;
use App\default_account;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Image;
use File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as IlluminateFile;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public $path;
    public $dimensions;

    public function __construct()
    {
        $this->path = storage_path('app/public/images');
        $this->dimensions = ['300', '600'];
    }

    public function company_index()
    {
        $users = User::find(Auth::id());
        $roles = Role::pluck('name', 'name')->all();

        $cs = company_setting::where('company_id', $users->company_id)->first();
        //$logo = logo_uploaded::where('company_id', 1)->first();
        $logo = company_logo::where('company_id', $users->company_id)->latest()->first();

        return view('admin.settings.company', compact(['cs', 'users', 'roles', 'logo']));
    }

    public function company_store(Request $request)
    {
        try {
            $users                  = User::find(Auth::id());

            $is_logo                = $request->get('is_logo');
            if ($is_logo) {
                $is_logo            = 1;
            } else {
                $is_logo            = 0;
            }
            $cover                  = $request->file('logo');
            if ($cover) {
                $extension              = $cover->getClientOriginalExtension();
                //Storage::disk('public')->put($cover->getFilename() . '.' . $extension,  File::get($cover));
                $cover->move(public_path('/file_logo/'), $cover->getFilename() . '.' . $extension,  File::get($cover));

                company_logo::where('company_id', $users->company_id)->updateOrCreate([
                    'company_id'        => $users->company_id,
                    'user_id'           => Auth::id(),
                    'mime'              => $cover->getClientMimeType(),
                    'original_filename' => $cover->getClientOriginalName(),
                    'filename'          => $cover->getFilename() . '.' . $extension,
                ]);
            }

            company_setting::where('company_id', $users->company_id)->update([
                'company_id'        => $users->company_id,
                'user_id'           => Auth::id(),
                'is_logo'           => $is_logo,
                'name'              => $request->get('name'),
                'address'           => $request->get('address'),
                'shipping_address'  => $request->get('shipping_address'),
                'phone'             => $request->get('phone'),
                'fax'               => $request->get('fax'),
                'tax_number'        => $request->get('tax_number'),
                'website'           => $request->get('website'),
                'email'             => $request->get('email'),
            ]);

            // notifikasi dengan session
            \Session::flash('sukses', 'Data is successfully updated');

            // alihkan halaman kembali
            return redirect('/settings/company');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return redirect('/settings/company');
        }
    }
    public function company_store2(Request $request)
    {
        try {
            if (!File::isDirectory($this->path)) {
                File::makeDirectory($this->path);
            }

            $file = $request->file('logo');

            if ($file) {
                $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                Image::make($file)->save($this->path . '/' . $fileName);

                foreach ($this->dimensions as $row) {
                    $canvas = Image::canvas($row, $row);
                    $resizeImage  = Image::make($file)->resize($row, $row, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    if (!File::isDirectory($this->path . '/' . $row)) {
                        File::makeDirectory($this->path . '/' . $row);
                    }

                    $canvas->insert($resizeImage, 'center');
                    $canvas->save($this->path . '/' . $row . '/' . $fileName);
                }

                /*
                logo_uploaded::where('company_id', 1)->updateOrCreate([
                    'company_id' => 1,
                    'name' => $fileName,
                    'dimensions' => implode('|', $this->dimensions),
                    'path' => $this->path
                ]);
                */
            };

            //$is_logo = $request->get('show_logo_in_report');

            //if($is_logo)
            //    $is_logo = 1;
            // else
            //$is_logo = 0;

            company_setting::where('company_id', 1)->update([
                'company_id' => 1,
                'user_id' => 1,
                //'is_logo' => $is_logo,
                'name' => $request->get('name'),
                'address' => $request->get('address'),
                'shipping_address' => $request->get('shipping_address'),
                'phone' => $request->get('phone'),
                'fax' => $request->get('fax'),
                'tax_number' => $request->get('tax_number'),
                'website' => $request->get('website'),
                'email' => $request->get('email'),
            ]);

            return response()->json(['success' => 'Company is successfully updated']);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function select_account()
    {
        if (request()->ajax()) {
            $page = Input::get('page');
            $resultCount = 10;

            $offset = ($page - 1) * $resultCount;

            $breeds = coa::where('code', 'LIKE',  '%' . Input::get("term") . '%')->orWhere('name', 'LIKE',  '%' . Input::get("term") . '%')
                ->orderBy('code')
                ->skip($offset)
                ->take($resultCount)
                ->get(['id', DB::raw('name as text'), 'code']);

            $count = coa::count();
            $endCount = $offset + $resultCount;
            $morePages = $endCount > $count;

            $results = array(
                "results" => $breeds,
                "pagination" => array(
                    "more" => $morePages,
                ),
                "total_count" => $count,
            );

            return response()->json($results);
        }
    }

    public function account_index()
    {
        $def_acc                    = default_account::get();
        $sales_revenue              = $def_acc->where('name', 'default_sales_revenue')->first();
        $sales_discount             = $def_acc->where('name', 'default_sales_discount')->first();
        $sales_return               = $def_acc->where('name', 'default_sales_return')->first();
        $sales_shipping             = $def_acc->where('name', 'default_sales_shipping')->first();
        $unearned_revenue           = $def_acc->where('name', 'default_unearned_revenue')->first();
        $unbilled_sales             = $def_acc->where('name', 'default_unbilled_sales')->first();
        $unbilled_receivable        = $def_acc->where('name', 'default_unbilled_receivable')->first();
        $sales_tax_receiveable      = $def_acc->where('name', 'default_sales_tax_receiveable')->first();
        $purchase                   = $def_acc->where('name', 'default_purchase')->first();
        $purchase_shipping          = $def_acc->where('name', 'default_purchase_shipping')->first();
        $prepayment                 = $def_acc->where('name', 'default_prepayment')->first();
        $unbilled_payable           = $def_acc->where('name', 'default_unbilled_payable')->first();
        $purchase_tax_receivable    = $def_acc->where('name', 'default_purchase_tax_receivable')->first();
        $account_receivable         = $def_acc->where('name', 'default_account_receivable')->first();
        $account_payable            = $def_acc->where('name', 'default_account_payable')->first();
        $inventory                  = $def_acc->where('name', 'default_inventory')->first();
        $inventory_general          = $def_acc->where('name', 'default_inventory_general')->first();
        $inventory_waste            = $def_acc->where('name', 'default_inventory_waste')->first();
        $inventory_production       = $def_acc->where('name', 'default_inventory_production')->first();
        $opening_balance_equity     = $def_acc->where('name', 'default_opening_balance_equity')->first();
        $fixed_asset                = $def_acc->where('name', 'default_fixed_asset')->first();
        // dd($def_acc);
        return view('admin.settings.acc_mapping', compact([
            'def_acc',
        ]));
    }

    public function account_store(Request $request)
    {
        try {
            $users                      = User::find(Auth::id());
            $def_acc                    = default_account::get();
            $sales_revenue              = $def_acc->where('name', 'default_sales_revenue')->update([
                'account_id'            => $request->sales_revenue
            ]);
            $sales_discount             = $def_acc->where('name', 'default_sales_discount')->first();
            $sales_return               = $def_acc->where('name', 'default_sales_return')->first();
            $sales_shipping             = $def_acc->where('name', 'default_sales_shipping')->first();
            $unearned_revenue           = $def_acc->where('name', 'default_unearned_revenue')->first();
            $unbilled_sales             = $def_acc->where('name', 'default_unbilled_sales')->first();
            $unbilled_receivable        = $def_acc->where('name', 'default_unbilled_receivable')->first();
            $sales_tax_receiveable      = $def_acc->where('name', 'default_sales_tax_receiveable')->first();
            $purchase                   = $def_acc->where('name', 'default_purchase')->first();
            $purchase_shipping          = $def_acc->where('name', 'default_purchase_shipping')->first();
            $prepayment                 = $def_acc->where('name', 'default_prepayment')->first();
            $unbilled_payable           = $def_acc->where('name', 'default_unbilled_payable')->first();
            $purchase_tax_receivable    = $def_acc->where('name', 'default_purchase_tax_receivable')->first();
            $account_receivable         = $def_acc->where('name', 'default_account_receivable')->first();
            $account_payable            = $def_acc->where('name', 'default_account_payable')->first();
            $inventory                  = $def_acc->where('name', 'default_inventory')->first();
            $inventory_general          = $def_acc->where('name', 'default_inventory_general')->first();
            $inventory_waste            = $def_acc->where('name', 'default_inventory_waste')->first();
            $inventory_production       = $def_acc->where('name', 'default_inventory_production')->first();
            $opening_balance_equity     = $def_acc->where('name', 'default_opening_balance_equity')->first();
            $fixed_asset                = $def_acc->where('name', 'default_fixed_asset')->first();

            company_setting::where('company_id', $users->company_id)->update([
                'company_id'        => $users->company_id,
                'user_id'           => Auth::id(),
                'is_logo'           => $is_logo,
                'name'              => $request->get('name'),
                'address'           => $request->get('address'),
                'shipping_address'  => $request->get('shipping_address'),
                'phone'             => $request->get('phone'),
                'fax'               => $request->get('fax'),
                'tax_number'        => $request->get('tax_number'),
                'website'           => $request->get('website'),
                'email'             => $request->get('email'),
            ]);

            // notifikasi dengan session
            \Session::flash('sukses', 'Data is successfully updated');

            // alihkan halaman kembali
            return redirect('/settings/account');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return redirect('/settings/account');
        }
    }
}
