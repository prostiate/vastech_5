<?php

namespace App\Http\Controllers;

use App\cashbank;
use App\contact;
use App\other_term;
use App\coa;
use App\default_account;
use App\expense;
use App\Exports\ContactExport;
use App\history_limit_balance;
use App\Imports\ContactImport;
use App\other_transaction;
use App\purchase_delivery;
use App\purchase_invoice;
use App\purchase_order;
use App\purchase_payment;
use App\purchase_quote;
use App\purchase_return;
use App\sale_delivery;
use App\sale_invoice;
use App\sale_order;
use App\sale_payment;
use App\sale_quote;
use App\sale_return;
use App\spk;
use App\User;
use App\wip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Validator;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{
    public function indexCustomer()
    {
        $user               = User::find(Auth::id());
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                return datatables()->of(contact::where('type_customer', true)->where('sales_type', $user->getRoleNames()->first())->get())
                    ->make(true);
            }
        } else {
            if (request()->ajax()) {
                return datatables()->of(contact::where('type_customer', true)->get())
                    ->make(true);
            }
        }

        return view('admin.contacts.customer.index');
    }

    public function indexVendor()
    {
        $user               = User::find(Auth::id());
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                return datatables()->of(contact::where('type_vendor', true)->where('sales_type', $user->getRoleNames()->first())->get())
                    ->make(true);
            }
        } else {
            if (request()->ajax()) {
                return datatables()->of(contact::where('type_vendor', true)->get())
                    ->make(true);
            }
        }

        return view('admin.contacts.vendor.index');
    }

    public function indexEmployee()
    {
        $user               = User::find(Auth::id());
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                return datatables()->of(contact::where('type_employee', true)->where('sales_type', $user->getRoleNames()->first())->get())
                    ->make(true);
            }
        } else {
            if (request()->ajax()) {
                return datatables()->of(contact::where('type_employee', true)->get())
                    ->make(true);
            }
        }

        return view('admin.contacts.employee.index');
    }

    public function indexOther()
    {
        $user               = User::find(Auth::id());
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                return datatables()->of(contact::where('type_other', true)->where('sales_type', $user->getRoleNames()->first())->get())
                    ->make(true);
            }
        } else {
            if (request()->ajax()) {
                return datatables()->of(contact::where('type_other', true)->get())
                    ->make(true);
            }
        }

        return view('admin.contacts.other.index');
    }

    public function indexAll()
    {
        $user               = User::find(Auth::id());
        if ($user->getRoleNames()->first() == 'GT' or $user->getRoleNames()->first() == 'MT' or $user->getRoleNames()->first() == 'WS') {
            if (request()->ajax()) {
                return datatables()->of(contact::where('sales_type', $user->getRoleNames()->first())->get())
                    ->make(true);
            }
        } else {
            if (request()->ajax()) {
                return datatables()->of(contact::get())
                    ->make(true);
            }
        }

        return view('admin.contacts.all.index');
    }

    public function create()
    {
        $user               = User::find(Auth::id());
        $coa_receive        = coa::where('coa_category_id', '1')->get();
        $coa_payable        = coa::where('coa_category_id', '8')->get();
        $term               = other_term::get();
        return view('admin.contacts.create', compact(['user', 'coa_receive', 'coa_payable', 'term']));
    }

    public function store(Request $request)
    {
        $user                       = User::find(Auth::id());
        $rules = array(
            'display_name'       => 'required',
        );

        $default_account_receivable     = default_account::find(15);
        $default_account_payable        = default_account::find(16);
        $default_term                   = other_term::find(1);

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $type                       = 0;
            if (isset($request->contact_type1)) {
                if ($request->has('contact_type1')) {
                    $contact_type1 = 1;
                } else {
                    $contact_type1 = 0;
                };
            } else {
                $type                   += 1;
                $contact_type1 = 0;
            }
            if (isset($request->contact_type2)) {
                if ($request->has('contact_type2')) {
                    $contact_type2 = 1;
                } else {
                    $contact_type2 = 0;
                };
            } else {
                $type                   += 1;
                $contact_type2 = 0;
            }
            if (isset($request->contact_type3)) {
                if ($request->has('contact_type3')) {
                    $contact_type3 = 1;
                } else {
                    $contact_type3 = 0;
                };
            } else {
                $type                   += 1;
                $contact_type3 = 0;
            }
            if (isset($request->contact_type4)) {
                if ($request->has('contact_type4')) {
                    $contact_type4 = 1;
                } else {
                    $contact_type4 = 0;
                };
            } else {
                $type                   += 1;
                $contact_type4 = 0;
            }

            if ($type == 4) {
                return response()->json(['errors' => 'Contact type must be filled with at least one type!']);
            }

            if ($request->get('account_receivable')) {
                $account_receivable = $request->get('account_receivable');
            } else {
                $account_receivable = $default_account_receivable->account_id;
            };

            if ($request->get('account_payable')) {
                $account_payable = $request->get('account_payable');
            } else {
                $account_payable = $default_account_payable->account_id;
            };

            if ($request->get('default_term')) {
                $account_term = $request->get('default_term');
            } else {
                $account_term = $default_term->id;
            };

            if ($request->limit_balance != null) {
                $limit_b                    = $request->limit_balance;
            } else {
                $limit_b                    = 0;
            }

            if ($limit_b == 0) {
                $is_limit                   = 0;
            } else {
                $is_limit                   = 1;
            }

            $share                          = new contact([
                'company_id'                => $user->company_id,
                'user_id'                   => Auth::id(),
                'account_receivable_id'     => $account_receivable,
                'account_payable_id'        => $account_payable,
                'term_id'                   => $account_term,
                'display_name'              => $request->get('display_name'),
                'type_customer'             => $contact_type1,
                'type_vendor'               => $contact_type2,
                'type_employee'             => $contact_type3,
                'type_other'                => $contact_type4,
                'sales_type'                => $request->sales_type,
                'is_limit'                  => $is_limit,
                'limit_balance'             => $limit_b,
                'current_limit_balance'     => $limit_b,
                'last_limit_balance'        => 0,
                'first_name'                => $request->get('first_name'),
                'middle_name'               => $request->get('middle_name'),
                'last_name'                 => $request->get('last_name'),
                'handphone'                 => $request->get('handphone'),
                'identity_type'             => $request->get('identity_type'),
                'identity_id'               => $request->get('identity_number'),
                'email'                     => $request->get('email'),
                'another_info'              => $request->get('another_info'),
                'company_name'              => $request->get('company_name'),
                'telephone'                 => $request->get('telephone'),
                'fax'                       => $request->get('fax'),
                'npwp'                      => $request->get('npwp'),
                'billing_address'           => $request->get('billing_address'),
                'shipping_address'          => $request->get('shipping_address'),
            ]);
            $share->save();
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $share->id]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }
    // STORE LIMIT BISA DI ACCESS KALAU SUDAH ADA TRANSACTION PADA CONTACT TERSEBUT
    public function storeLimit(Request $request, $id)
    {
        $rules = array(
            'to_limit_balance'       => 'required',
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $contact = contact::find($id);
            if ($request->type_limit_balance == 'add') {
                $limit_balance                = $contact->limit_balance + $request->to_limit_balance;
                $current_limit_balance        = $contact->current_limit_balance + $request->to_limit_balance;
            } else {
                $limit_balance                = $contact->limit_balance - $request->to_limit_balance;
                $current_limit_balance        = $contact->current_limit_balance - $request->to_limit_balance;
            }
            if ($limit_balance < 0 or $current_limit_balance < 0) {
                DB::rollBack();
                return response()->json(['errors' => 'Total limit balance or total current limit balance cannot less than zero!<br><br>
                Total Previous Limit Balance = ' . number_format($contact->limit_balance, 2, ',', '.') . '<br>
                Total Previous Current Limit Balance = ' . number_format($contact->current_limit_balance, 2, ',', '.') . '<br>
                Total New Limit Balance = ' . number_format($limit_balance, 2, ',', '.') . '<br>
                Total New Current Limit Balance = ' . number_format($current_limit_balance, 2, ',', '.')]);
            }
            history_limit_balance::create([
                'user_id'               => Auth::id(),
                'contact_id'            => $id,
                'from_limit_balance'    => $contact->limit_balance,
                'to_limit_balance'      => $limit_balance,
                'type_limit_balance'    => $request->type_limit_balance,
                'value'                 => $request->to_limit_balance,
            ]);
            $contact->update([
                'limit_balance'         => $limit_balance,
                'current_limit_balance' => $current_limit_balance,
            ]);
            DB::commit();
            return response()->json(['success' => 'Data is successfully added', 'id' => $id]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $contact            = contact::find($id);
        $check_transaction  = 0;
        if (
            $contact->sale_delivery()->exists() or $contact->sale_invoice()->exists() or $contact->sale_payment()->exists()
            or $contact->sale_order()->exists() or $contact->sale_quote()->exists() or $contact->sale_return()->exists()
            or $contact->purchase_delivery()->exists() or $contact->purchase_invoice()->exists() or $contact->purchase_payment()->exists()
            or $contact->purchase_order()->exists() or $contact->purchase_quote()->exists() or $contact->purchase_return()->exists()
            or $contact->spk()->exists() or $contact->wip()->exists()
            or $contact->expense()->exists() or $contact->cashbank()->exists()
        ) {
            $check_transaction = 1;
        }
        $other_transaction  = other_transaction::with('status')->where('contact', $id)->get();
        $pq                 = purchase_quote::where('contact_id', $id)->get();
        $po                 = purchase_order::where('contact_id', $id)->get();
        $pd                 = purchase_delivery::where('contact_id', $id)->get();
        $pi                 = purchase_invoice::where('contact_id', $id)->get();
        $pp                 = purchase_payment::where('contact_id', $id)->get();
        $pr                 = purchase_return::where('contact_id', $id)->get();
        $sq                 = sale_quote::where('contact_id', $id)->get();
        $so                 = sale_order::where('contact_id', $id)->get();
        $sd                 = sale_delivery::where('contact_id', $id)->get();
        $si                 = sale_invoice::where('contact_id', $id)->get();
        $sp                 = sale_payment::where('contact_id', $id)->get();
        $sr                 = sale_return::where('contact_id', $id)->get();
        $expense            = expense::where('contact_id', $id)->get();
        $caba               = cashbank::where('contact_id', $id)->get();
        $spk                = spk::where('contact_id', $id)->get();
        $wip                = wip::where('contact_id', $id)->get();
        $hlb                = history_limit_balance::where('contact_id', $id)->get();

        return view('admin.contacts.show', compact([
            'check_transaction',
            'contact', 'other_transaction',
            'pq', 'po', 'pd', 'pi', 'pp', 'pr', 'sq', 'so', 'sd', 'si', 'sp', 'sr',
            'expense', 'caba', 'spk', 'wip', 'hlb',
        ]));
    }

    public function edit($id)
    {
        $contact            = contact::find($id);
        $check_transaction  = 0;
        if (
            $contact->sale_delivery()->exists() or $contact->sale_invoice()->exists() or $contact->sale_payment()->exists()
            or $contact->sale_order()->exists() or $contact->sale_quote()->exists() or $contact->sale_return()->exists()
            or $contact->purchase_delivery()->exists() or $contact->purchase_invoice()->exists() or $contact->purchase_payment()->exists()
            or $contact->purchase_order()->exists() or $contact->purchase_quote()->exists() or $contact->purchase_return()->exists()
            or $contact->spk()->exists() or $contact->wip()->exists()
            or $contact->expense()->exists() or $contact->cashbank()->exists()
        ) {
            $check_transaction = 1;
        }
        $coa_receive        = coa::where('coa_category_id', '1')->get();
        $coa_payable        = coa::where('coa_category_id', '8')->get();
        $term               = other_term::get();

        return view('admin.contacts.edit', compact(['contact', 'coa_receive', 'coa_payable', 'term', 'check_transaction']));
    }

    public function update(Request $request)
    {
        $rules = array(
            'display_name'    => 'required',
        );

        $default_account_receivable     = default_account::find(15);
        $default_account_payable        = default_account::find(16);
        $default_term                   = other_term::find(1);

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        DB::beginTransaction();
        try {
            $id                         = $request->hidden_id;
            $type                       = 0;
            if (isset($request->contact_type1)) {
                if ($request->has('contact_type1')) {
                    $contact_type1 = 1;
                } else {
                    $contact_type1 = 0;
                };
            } else {
                $type                   += 1;
                $contact_type1 = 0;
            }
            if (isset($request->contact_type2)) {
                if ($request->has('contact_type2')) {
                    $contact_type2 = 1;
                } else {
                    $contact_type2 = 0;
                };
            } else {
                $type                   += 1;
                $contact_type2 = 0;
            }
            if (isset($request->contact_type3)) {
                if ($request->has('contact_type3')) {
                    $contact_type3 = 1;
                } else {
                    $contact_type3 = 0;
                };
            } else {
                $type                   += 1;
                $contact_type3 = 0;
            }
            if (isset($request->contact_type4)) {
                if ($request->has('contact_type4')) {
                    $contact_type4 = 1;
                } else {
                    $contact_type4 = 0;
                };
            } else {
                $type                   += 1;
                $contact_type4 = 0;
            }

            if ($type == 4) {
                return response()->json(['errors' => 'Contact type must be filled with at least one type!']);
            }

            if ($request->get('account_receivable')) {
                $account_receivable = $request->get('account_receivable');
            } else {
                $account_receivable = $default_account_receivable->account_id;
            };

            if ($request->get('account_payable')) {
                $account_payable = $request->get('account_payable');
            } else {
                $account_payable = $default_account_payable->account_id;
            };

            if ($request->get('default_term')) {
                $account_term = $request->get('default_term');
            } else {
                $account_term = $default_term->id;
            };

            if ($request->limit_balance != null) {
                $limit_b                    = $request->limit_balance;
            } else {
                $limit_b                    = 0;
            }

            if ($limit_b == 0) {
                $is_limit                   = 0;
            } else {
                $is_limit                   = 1;
            }

            $form_data = array(
                'account_receivable_id'     => $account_receivable,
                'account_payable_id'        => $account_payable,
                'term_id'                   => $account_term,
                'display_name'              => $request->get('display_name'),
                'type_customer'             => $contact_type1,
                'type_vendor'               => $contact_type2,
                'type_employee'             => $contact_type3,
                'type_other'                => $contact_type4,
                'sales_type'                => $request->sales_type,
                'is_limit'                  => $is_limit,
                'limit_balance'             => $limit_b,
                'current_limit_balance'     => $limit_b,
                'last_limit_balance'        => 0,
                'first_name'                => $request->get('first_name'),
                'middle_name'               => $request->get('middle_name'),
                'last_name'                 => $request->get('last_name'),
                'handphone'                 => $request->get('handphone'),
                'identity_type'             => $request->get('identity_type'),
                'identity_id'               => $request->get('identity_number'),
                'email'                     => $request->get('email'),
                'another_info'              => $request->get('another_info'),
                'company_name'              => $request->get('company_name'),
                'telephone'                 => $request->get('telephone'),
                'fax'                       => $request->get('fax'),
                'npwp'                      => $request->get('npwp'),
                'billing_address'           => $request->get('billing_address'),
                'shipping_address'          => $request->get('shipping_address'),
            );
            contact::whereId($id)->update($form_data);
            DB::commit();
            return response()->json(['success' => 'Data is successfully updated', 'id' => $id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function destroy($contact)
    {
        DB::beginTransaction();
        try {
            $data = contact::find($contact);
            if (
                $data->sale_delivery()->exists() or $data->sale_invoice()->exists() or $data->sale_payment()->exists()
                or $data->sale_order()->exists() or $data->sale_quote()->exists() or $data->sale_return()->exists()
                or $data->purchase_delivery()->exists() or $data->purchase_invoice()->exists() or $data->purchase_payment()->exists()
                or $data->purchase_order()->exists() or $data->purchase_quote()->exists() or $data->purchase_return()->exists()
                or $data->spk()->exists() or $data->wip()->exists()
                or $data->expense()->exists() or $data->cashbank()->exists()
            ) {
                DB::rollBack();
                return response()->json(['errors' => 'Cannot delete contact with transactions!']);
            }
            $data->delete();
            DB::commit();
            return response()->json(['success' => 'Data is successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function import_excel(Request $request)
    {
        /*$rules = array(
            'file' => 'required|mimes:csv,xls,xlsx'
        );

        $error = Validator::make($request->all(), $rules);
        // ngecek apakah semua inputan sudah valid atau belum
        if ($error->fails()) {
            \Session::flash('error', $error->errors());
            return redirect('/contacts_all');
        }*/
        try {
            /*// validasi
            $this->validate($request, [
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);*/

            // menangkap file excel
            $file = $request->file('file');

            // membuat nama file unik
            $nama_file = rand() . $file->getClientOriginalName();

            // upload ke folder file_siswa di dalam folder public
            $file->move(public_path('/file_contact/'), $nama_file);

            try {
                // import data
                Excel::import(new ContactImport, public_path('/file_contact/' . $nama_file));
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();

                foreach ($failures as $failure) {
                    $failure->row(); // row that went wrong
                    $failure->attribute(); // either heading key (if using heading row concern) or column index
                    $failure->errors(); // Actual error messages from Laravel validator
                    $failure->values(); // The values of the row that has failed.
                }
                // notifikasi dengan session
                \Session::flash('error', $e->failures());
                // alihkan halaman kembali
                return redirect('/contacts_all');
            }
            // notifikasi dengan session
            \Session::flash('sukses', 'Data Contact Berhasil Diimport!');

            // alihkan halaman kembali
            return redirect('/contacts_all');
        } catch (\Exception $e) {
            \Session::flash('error', $e->getMessage());
            return redirect('/contacts_all');
        }
    }

    public function export_excel()
    {
        return Excel::download(new ContactExport, 'contact.xlsx');
    }

    public function export_csv()
    {
        return Excel::download(new ContactExport, 'contact.csv');
    }

    public function export_pdf()
    {
        $contacts                             = contact::get();
        $no                                   = count($contacts);

        if ($no <= 1000) {
            $view = view('admin.contacts.printPDF')->with(compact(['contacts']));
            $html = $view->render();
            $pdf = PDF::loadHTML($html);
            return $pdf->download('contact.pdf');
        } else {
            \Session::flash('error', 'Failed, data coptact is more than 1000!');
            return redirect('/contacts_all');
        }
    }
}
