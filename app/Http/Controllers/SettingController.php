<?php

namespace App\Http\Controllers;

use App\company_setting;
use App\User;
use App\logo_uploaded;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Image;
use File;
use Illuminate\Support\Facades\Auth;

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

        return view('admin.settings.company', compact(['cs', 'users', 'roles']));
    }

    public function company_store(Request $request)
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

    public function account_index()
    {

        return view('admin.settings.acc_mapping');
    }
}
