<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users              = User::all();
        $roles              = Role::pluck('name', 'name')->all();
        $permissions        = Permission::all()->pluck('name', 'name');

        return view('admin.settings.user_management.index', compact(['users', 'roles', 'permissions']));
    }

    public function store(Request $request)
    {
        $rules = array(
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'      => ['required', 'string', 'min:6', 'confirmed'],
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        try {
            if ($error->fails()) {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $user = User::create([
                'name'      => $request->get('name'),
                'email'     => $request->get('email'),
                'password'  => Hash::make($request->get('password')),
            ]);
            $user->assignRole($request->role);
            $user->givePermissionTo($request->permission);

            return response()->json(['success' => 'User is successfully added']);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.settings.user_management.edit', compact(['user']));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'          => 'required|string|max:100',
            'email'         => 'required|email|exists:users,email',
            'password'      => 'nullable|min:6',
        ]);

        $user = User::findOrFail($id);
        $password = !empty($request->password) ? bcrypt($request->password) : $user->password;
        $user->update([
            'name'          => $request->name,
            'password'      => $password
        ]);
        return redirect('/settings/user')->with(['success' => 'User: <strong>' . $user->name . '</strong> Diperbaharui']);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect(route('user.index'))->with(['success' => $user->name . 'is successfully deleted']);
    }

    public function roles(Request $request, $id)
    {
        $user               = User::findOrFail($id);
        $roles              = Role::get()->pluck('name');
        $permissions        = Permission::get()->pluck('name', 'name');

        return view('admin.settings.user_management.role', compact(['user', 'roles', 'permissions']));
    }

    public function setRole(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user           = User::findOrFail($id);
            //menggunakan syncRoles agar terlebih dahulu menghapus semua role yang dimiliki
            //kemudian di-set kembali agar tidak terjadi duplicate
            if (!$request->role) {
                DB::rollback();
                return response()->json(['errors' => 'Roles must be filled at least one!']);
            }
            $user->syncRoles($request->role);
            $user->syncPermissions($request->permission);
            DB::commit();
            return response()->json(['success' => 'Data is successfully added']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
}
