<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('/',                                                         'HomeController@index');

    Route::get('/dashboard',                                                'HomeController@index');

    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        return "Cache is cleared";
    });
    /*---------REPORTS --------------*/
    Route::get('/reports', function () {
        return view('admin.reports.index');
    })->name('reportsindex');
    // OVERVIEW
    Route::get('/reports/balance_sheet',                                                                        'ReportController@balanceSheet');
    Route::get('/reports/balance_sheet/excel/as_of={today}/start_year={startyear}&end_year={endyear}',          'ReportController@balanceSheet_excel');
    Route::get('/reports/balance_sheet/csv/as_of={today}/start_year={startyear}&end_year={endyear}',            'ReportController@balanceSheet_csv');
    Route::get('/reports/balance_sheet/pdf/as_of={today}/start_year={startyear}&end_year={endyear}',            'ReportController@balanceSheet_pdf');
    Route::get('/reports/balance_sheet/as_of={mulaidari}',                                                      'ReportController@balanceSheetInput');
    Route::get('/reports/general_ledger',                                                                       'ReportController@generalLedger');
    Route::get('/reports/general_ledger/start_date={start}&end_date={end}&account_id={id}',                     'ReportController@generalLedgerInput');
    Route::get('/reports/general_ledger/excel/start_date={start}&end_date={end}&account_id={id}',               'ReportController@generalLedger_excel');
    Route::get('/reports/general_ledger/csv/start_date={start}&end_date={end}&account_id={id}',                 'ReportController@generalLedger_csv');
    Route::get('/reports/general_ledger/pdf/start_date={start}&end_date={end}&account_id={id}',                 'ReportController@generalLedger_pdf');
    Route::get('/reports/profit_loss',                                                                          'ReportController@profitLoss');
    Route::get('/reports/profit_loss/start_date={start}&end_date={end}',                                        'ReportController@profitLossInput');
    Route::get('/reports/profit_loss/excel/start_date={start}&end_date={end}',                                  'ReportController@profitLoss_excel');
    Route::get('/reports/profit_loss/csv/start_date={start}&end_date={end}',                                    'ReportController@profitLoss_csv');
    Route::get('/reports/profit_loss/pdf/start_date={start}&end_date={end}',                                    'ReportController@profitLoss_pdf');
    Route::get('/reports/journal_report',                                                                       'ReportController@journal_report');
    Route::get('/reports/journal_report/start_date={start}&end_date={end}',                                     'ReportController@journal_reportInput');
    Route::get('/reports/journal_report/excel/start_date={start}&end_date={end}',                               'ReportController@journal_report_excel');
    Route::get('/reports/journal_report/csv/start_date={start}&end_date={end}',                                 'ReportController@journal_report_csv');
    Route::get('/reports/journal_report/pdf/start_date={start}&end_date={end}',                                 'ReportController@journal_report_pdf');
    Route::get('/reports/trial_balance',                                                                        'ReportController@trial_balance');
    Route::get('/reports/trial_balance/start_date={start}&end_date={end}',                                      'ReportController@trial_balanceInput');
    Route::get('/reports/trial_balance/excel/start_date={start}&end_date={end}',                                'ReportController@trial_balance_excel');
    Route::get('/reports/trial_balance/csv/start_date={start}&end_date={end}',                                  'ReportController@trial_balance_csv');
    Route::get('/reports/trial_balance/pdf/start_date={start}&end_date={end}',                                  'ReportController@trial_balance_pdf');
    Route::get('/reports/cashflow',                                                                             'ReportController@cashflow');
    Route::get('/reports/cashflow/start_date={start}&end_date={end}',                                           'ReportController@cashflowInput');
    Route::get('/reports/cashflow/excel/start_date={start}&end_date={end}',                                     'ReportController@cashflow_excel');
    Route::get('/reports/cashflow/csv/start_date={start}&end_date={end}',                                       'ReportController@cashflow_csv');
    Route::get('/reports/cashflow/pdf/start_date={start}&end_date={end}',                                       'ReportController@cashflow_pdf');
    Route::get('/reports/executive_summary',                                'ReportController@executive_summary');
    Route::get('/reports/executive_summary/{start}&{end}',                  'ReportController@executive_summaryInput');
    //OVERVIEW
    //SALES
    Route::get('/reports/sales_list',                                       'ReportController@sales_list');
    Route::get('/reports/sales_list/{start}&{end}',                         'ReportController@sales_listInput');
    Route::get('/reports/sales_by_customer',                                'ReportController@sales_by_customer');
    Route::get('/reports/sales_by_customer/{start}&{end}',                  'ReportController@sales_by_customerInput');
    Route::get('/reports/customer_balance',                                 'ReportController@customer_balance');
    Route::get('/reports/customer_balance/{mulaidari}',                     'ReportController@customer_balanceInput');
    Route::get('/reports/aged_receivable',                                  'ReportController@aged_receivable');
    Route::get('/reports/aged_receivable/{mulaidari}',                      'ReportController@aged_receivableInput');
    Route::get('/reports/sales_delivery',                                   'ReportController@sales_delivery');
    Route::get('/reports/sales_delivery/{start}&{end}',                     'ReportController@sales_deliveryInput');
    Route::get('/reports/sales_by_product',                                 'ReportController@sales_by_product');
    Route::get('/reports/sales_by_product/{start}&{end}',                   'ReportController@sales_by_productInput');
    Route::get('/reports/sales_order_completion',                           'ReportController@sales_order_completion');
    Route::get('/reports/sales_order_completion/{start}&{end}',             'ReportController@sales_order_completionInput');
    // SALES
    // PURCHASES
    Route::get('/reports/purchases_list',                                   'ReportController@purchases_list');
    Route::get('/reports/purchases_list/{start}&{end}',                     'ReportController@purchases_listInput');
    Route::get('/reports/purchases_by_vendor',                              'ReportController@purchases_by_vendor');
    Route::get('/reports/purchases_by_vendor/{start}&{end}',                'ReportController@purchases_by_vendorInput');
    Route::get('/reports/vendor_balance',                                   'ReportController@vendor_balance');
    Route::get('/reports/vendor_balance/{mulaidari}',                       'ReportController@vendor_balanceInput');
    Route::get('/reports/aged_payable',                                     'ReportController@aged_payable');
    Route::get('/reports/aged_payable/{mulaidari}',                         'ReportController@aged_payableInput');
    Route::get('/reports/purchases_delivery',                               'ReportController@purchases_delivery');
    Route::get('/reports/purchases_delivery/{start}&{end}',                 'ReportController@purchases_deliveryInput');
    Route::get('/reports/purchases_by_product',                             'ReportController@purchases_by_product');
    Route::get('/reports/purchases_by_product/{start}&{end}',               'ReportController@purchases_by_productInput');
    Route::get('/reports/purchases_order_completion',                       'ReportController@purchases_order_completion');
    Route::get('/reports/purchases_order_completion/{start}&{end}',         'ReportController@purchases_order_completionInput');
    // PURCHASES
    // EXPENSES
    Route::get('/reports/expenses_list',                                    'ReportController@expenses_list');
    Route::get('/reports/expenses_list/{start}&{end}',                      'ReportController@expenses_listInput');
    // EXPENSES
    // PRODUCTS             
    Route::get('/reports/inventory_summary',                                                                        'ReportController@inventory_summary');
    Route::get('/reports/inventory_summary/excel/as_of={today}/start_year={startyear}&end_year={endyear}',          'ReportController@inventory_summary_excel');
    Route::get('/reports/inventory_summary/csv/as_of={today}/start_year={startyear}&end_year={endyear}',            'ReportController@inventory_summary_csv');
    Route::get('/reports/inventory_summary/pdf/as_of={today}/start_year={startyear}&end_year={endyear}',            'ReportController@inventory_summary_pdf');
    Route::get('/reports/inventory_summary/as_of={mulaidari}',                                                      'ReportController@inventory_summaryInput');
   // Route::get('/reports/inventory_summary/{mulaidari}',                    'ReportController@inventory_summaryInput');
    Route::get('/reports/warehouse_stock_quantity',                         'ReportController@warehouse_stock_quantity');
    Route::get('/reports/warehouse_stock_quantity/{mulaidari}',             'ReportController@warehouse_stock_quantityInput');
    Route::get('/reports/inventory_valuation',                              'ReportController@inventory_valuation');
    Route::get('/reports/inventory_valuation/{start}&{end}',                'ReportController@inventory_valuationInput');
    Route::get('/reports/warehouse_items_valuation',                        'ReportController@warehouse_items_valuation');
    Route::get('/reports/warehouse_items_valuation/{mulaidari}',            'ReportController@warehouse_items_valuationInput');
    Route::get('/reports/inventory_details',                                'ReportController@inventory_details');
    Route::get('/reports/warehouse_items_stock_movement',                   'ReportController@warehouse_items_stock_movement');
    // PRODUCTS

    /*---------CASH AND BANK --------------*/
    Route::get('/cashbank',                                                 'CashbankController@index');
    Route::get('/cashbankListTransaction',                                  'CashbankController@indexListTransaction');
    Route::get('/cashbank/bank_transfer/new',                               'CashbankController@createBankTransfer');
    Route::get('/cashbank/bank_deposit/new',                                'CashbankController@createBankDeposit');
    Route::get('/cashbank/bank_withdrawal/account/new',                     'CashbankController@createBankWithdrawalAccount');
    Route::get('/cashbank/bank_withdrawal/expense/new/{id}',                'CashbankController@createBankWithdrawalFromExpense');
    Route::post('/cashbank/newBankTransfer',                                'CashbankController@storeBankTransfer');
    Route::post('/cashbank/newBankDeposit',                                 'CashbankController@storeBankDeposit');
    Route::post('/cashbank/newBankAccount',                                 'CashbankController@storeBankWithdrawalAccount');
    Route::post('/cashbank/newBankFromExpense',                             'CashbankController@storeBankWithdrawalFromExpense');
    Route::get('/cashbank/edit/{id}',                                       'CashbankController@edit');
    Route::get('/cashbank/bank_transfer/edit/{id}',                         'CashbankController@editBankTransfer');
    Route::get('/cashbank/bank_deposit/edit/{id}',                          'CashbankController@editBankDeposit');
    Route::get('/cashbank/bank_withdrawal/account/edit/{id}',               'CashbankController@editBankWithdrawalAccount');
    Route::get('/cashbank/bank_withdrawal/expense/edit/{id}',               'CashbankController@editBankWithdrawalExpense');
    Route::post('/cashbank/updateTransaction',                              'CashbankController@update');
    Route::post('/cashbank/updateBankTransfer',                             'CashbankController@updateBankTransfer');
    Route::post('/cashbank/updateBankDeposit',                              'CashbankController@updateBankDeposit');
    Route::post('/cashbank/updateBankWithdrawalAccount',                    'CashbankController@updateBankWithdrawalAccount');
    Route::post('/cashbank/updateBankWithdrawalFromExpense',                'CashbankController@updateBankWithdrawalFromExpense');
    Route::get('/cashbank/bank_transfer/{id}',                              'CashbankController@showBankTransfer');
    Route::get('/cashbank/bank_deposit/{id}',                               'CashbankController@showBankDeposit');
    Route::get('/cashbank/bank_withdrawal/{id}',                            'CashbankController@showBankWithdrawal');
    Route::get('/cashbank/bank_transfer/delete/{id}',                       'CashbankController@destroyBankTransfer');
    Route::get('/cashbank/bank_deposit/delete/{id}',                        'CashbankController@destroyBankDeposit');
    Route::get('/cashbank/bank_withdrawal/delete/{id}',                     'CashbankController@destroyBankWithdrawal');
    Route::get('/cashbank/bank_transfer/PDF/{id}',                          'CashbankController@cetak_pdfBankDeposit');
    Route::get('/cashbank/bank_withdrawal/PDF/{id}',                        'CashbankController@cetak_pdfBankWithdrawal');

    /*###################################### SALES /*######################################*/
    Route::get('/sales_invoice/select_product',                             'SaleInvoiceController@select_product');
    Route::get('/sales_invoice/select_contact',                             'SaleInvoiceController@select_contact');
    Route::get('/sales_invoice',                                            'SaleInvoiceController@index');
    Route::get('/sales_invoice/new',                                        'SaleInvoiceController@create');
    Route::get('/sales_invoice/newRS',                                      'SaleInvoiceController@createRequestSukses');
    Route::get('/sales_invoice/new/fromQuote/{id}',                         'SaleInvoiceController@createFromQuote');
    Route::get('/sales_invoice/new/fromOrder/{id}',                         'SaleInvoiceController@createFromOrder');
    Route::get('/sales_invoice/new/fromDelivery/{id}',                      'SaleInvoiceController@createFromDelivery');
    Route::get('/sales_invoice/new/fromSPK/{id}',                           'SaleInvoiceController@createFromSPK');
    Route::get('/sales_invoice/newRS/fromOrder/{id}',                       'SaleInvoiceController@createFromOrderRequestSukses');
    Route::post('/sales_invoice/newSInvoice',                               'SaleInvoiceController@store');
    Route::post('/sales_invoice/newSInvoiceRequestSukses',                  'SaleInvoiceController@storeRequestSukses');
    Route::post('/sales_invoice/newInvoiceFromQuote',                       'SaleInvoiceController@storeFromQuote');
    Route::post('/sales_invoice/newInvoiceFromOrder',                       'SaleInvoiceController@storeFromOrder');
    Route::post('/sales_invoice/newInvoiceFromDelivery',                    'SaleInvoiceController@storeFromDelivery');
    Route::post('/sales_invoice/newInvoiceFromSPK',                         'SaleInvoiceController@storeFromSPK');
    Route::post('/sales_invoice/newInvoiceFromOrderRequestSukses',          'SaleInvoiceController@storeFromOrderRequestSukses');
    Route::get('/sales_invoice/edit/{id}',                                  'SaleInvoiceController@edit');
    Route::post('/sales_invoice/updateSInvoice',                            'SaleInvoiceController@update');
    Route::post('/sales_invoice/updateSInvoiceFromQuote',                   'SaleInvoiceController@updateFromQuote');
    Route::post('/sales_invoice/updateSInvoiceFromOrder',                   'SaleInvoiceController@updateFromOrder');
    Route::post('/sales_invoice/updateSInvoiceFromDelivery',                'SaleInvoiceController@updateFromDelivery');
    Route::post('/sales_invoice/updateSInvoiceFromOrderRequestSukses',      'SaleInvoiceController@updateFromOrderRequestSukses');
    Route::get('/sales_invoice/{id}',                                       'SaleInvoiceController@show');
    Route::get('/sales_invoice/print/PDF/1/{id}',                           'SaleInvoiceController@cetak_pdf_1');
    Route::get('/sales_invoice/print/PDF/1_sj/{id}',                        'SaleInvoiceController@cetak_pdf_1_sj');
    Route::get('/sales_invoice/print/PDF/2/{id}',                           'SaleInvoiceController@cetak_pdf_2');
    Route::get('/sales_invoice/print/PDF/2_sj/{id}',                        'SaleInvoiceController@cetak_pdf_2_sj');
    Route::get('/sales_invoice/print/PDF/fas/{id}',                         'SaleInvoiceController@cetak_pdf_fas');
    Route::get('/sales_invoice/print/PDF/fas_sj/{id}',                      'SaleInvoiceController@cetak_pdf_fas_sj');
    Route::get('/sales_invoice/print/PDF/gelora/{id}',                      'SaleInvoiceController@cetak_pdf_gg');
    Route::get('/sales_invoice/print/PDF/gelora_sj/{id}',                   'SaleInvoiceController@cetak_pdf_gg_sj');
    Route::get('/sales_invoice/print/PDF/sukses/{id}',                      'SaleInvoiceController@cetak_pdf_sukses');
    Route::get('/sales_invoice/print/PDF/sukses_sj/{id}',                   'SaleInvoiceController@cetak_pdf_sukses_sj');
    Route::get('/sales_invoice/print/PDF/sukses_surabaya/{id}',             'SaleInvoiceController@cetak_pdf_sukses_surabaya');
    Route::get('/sales_invoice/print/PDF/sukses_surabaya_sj/{id}',          'SaleInvoiceController@cetak_pdf_sukses_surabaya_sj');
    Route::get('/sales_invoice/delete/{id}',                                'SaleInvoiceController@destroy');

    Route::get('/sales_return',                                             'SaleReturnController@index');
    Route::get('/sales_return/new/{id}',                                    'SaleReturnController@create');
    Route::post('/sales_return/newReturn',                                  'SaleReturnController@store');
    Route::get('/sales_return/{id}',                                        'SaleReturnController@show');
    Route::get('/sales_return/edit/{id}',                                   'SaleReturnController@edit');
    Route::post('/sales_return/updateReturn',                               'SaleReturnController@update');
    Route::get('/sales_return/delete/{id}',                                 'SaleReturnController@destroy');
    Route::get('/sales_return/print/PDF/1/{id}',                            'SaleReturnController@cetak_pdf_1');
    Route::get('/sales_return/print/PDF/2/{id}',                            'SaleReturnController@cetak_pdf_2');
    Route::get('/sales_return/print/PDF/fas/{id}',                          'SaleReturnController@cetak_pdf_fas');
    Route::get('/sales_return/print/PDF/gelora/{id}',                       'SaleReturnController@cetak_pdf_gg');
    Route::get('/sales_return/print/PDF/sukses/{id}',                       'SaleReturnController@cetak_pdf_sukses');
    Route::get('/sales_return/print/PDF/sukses_surabaya/{id}',              'SaleReturnController@cetak_pdf_sukses_surabaya');

    Route::get('/sales_order/select_product',                               'SaleOrderController@select_product');
    Route::get('/sales_order/select_contact',                               'SaleOrderController@select_contact');
    Route::get('/sales_order/select_contact_employee',                      'SaleOrderController@select_contact_employee');
    Route::post('/sales_order/closeOrder/{id}',                             'SaleOrderController@closeOrder');
    Route::get('/sales_order',                                              'SaleOrderController@index');
    Route::get('/sales_order/new',                                          'SaleOrderController@create');
    Route::get('/sales_order/new/fromQuote/{id}',                           'SaleOrderController@createFromQuote');
    Route::get('/sales_order/newRS',                                        'SaleOrderController@createRequestSukses');
    Route::post('/sales_order/newSOrder',                                   'SaleOrderController@store');
    Route::post('/sales_order/newOrderFromQuote',                           'SaleOrderController@storeFromQuote');
    Route::post('/sales_order/newOrderRequestSukses',                       'SaleOrderController@storeRequestSukses');
    Route::get('/sales_order/edit/{id}',                                    'SaleOrderController@edit');
    Route::post('/sales_order/updateSOrder',                                'SaleOrderController@update');
    Route::post('/sales_order/updateOrderRequestSukses',                    'SaleOrderController@updateRequestSukses');
    Route::get('/sales_order/{id}',                                         'SaleOrderController@show');
    Route::get('/sales_order/print/PDF/1/{id}',                             'SaleOrderController@cetak_pdf_1');
    Route::get('/sales_order/print/PDF/2/{id}',                             'SaleOrderController@cetak_pdf_2');
    Route::get('/sales_order/print/PDF/fas/{id}',                           'SaleOrderController@cetak_pdf_fas');
    Route::get('/sales_order/print/PDF/gelora/{id}',                        'SaleOrderController@cetak_pdf_gg');
    Route::get('/sales_order/print/PDF/sukses/{id}',                        'SaleOrderController@cetak_pdf_sukses');
    Route::get('/sales_order/print/PDF/sukses_surabaya/{id}',               'SaleOrderController@cetak_pdf_sukses_surabaya');
    Route::get('/sales_order/delete/{id}',                                  'SaleOrderController@destroy');

    Route::get('/sales_quote/select_product',                               'SaleQuoteController@select_product');
    Route::get('/sales_quote/select_contact',                               'SaleQuoteController@select_contact');
    Route::get('/sales_quote',                                              'SaleQuoteController@index');
    Route::get('/sales_quote/new',                                          'SaleQuoteController@create');
    Route::post('/sales_quote/newSQuote',                                   'SaleQuoteController@store');
    Route::get('/sales_quote/edit/{id}',                                    'SaleQuoteController@edit');
    Route::post('/sales_quote/updateSQuote',                                'SaleQuoteController@update');
    Route::get('/sales_quote/{id}',                                         'SaleQuoteController@show');
    Route::get('/sales_quote/print/PDF/1/{id}',                             'SaleQuoteController@cetak_pdf_1');
    Route::get('/sales_quote/print/PDF/2/{id}',                             'SaleQuoteController@cetak_pdf_2');
    Route::get('/sales_quote/print/PDF/fas/{id}',                           'SaleQuoteController@cetak_pdf_fas');
    Route::get('/sales_quote/print/PDF/gelora/{id}',                        'SaleQuoteController@cetak_pdf_gg');
    Route::get('/sales_quote/print/PDF/sukses/{id}',                        'SaleQuoteController@cetak_pdf_sukses');
    Route::get('/sales_quote/print/PDF/sukses_surabaya/{id}',               'SaleQuoteController@cetak_pdf_sukses_surabaya');
    Route::get('/sales_quote/delete/{id}',                                  'SaleQuoteController@destroy');

    Route::get('/sales_delivery',                                           'SaleDeliveryController@index');
    Route::get('/sales_delivery/new/from/{id}',                             'SaleDeliveryController@createFromPO');
    Route::post('/sales_delivery/newDelivery',                              'SaleDeliveryController@storeFromPO');
    Route::get('/sales_delivery/edit/from/{id}',                            'SaleDeliveryController@edit');
    Route::post('/sales_delivery/updateDelivery',                           'SaleDeliveryController@updateFromPO');
    Route::get('/sales_delivery/{id}',                                      'SaleDeliveryController@show');
    Route::get('/sales_delivery/print/PDF/1/{id}',                          'SaleDeliveryController@cetak_pdf_1');
    Route::get('/sales_delivery/print/PDF/2/{id}',                          'SaleDeliveryController@cetak_pdf_2');
    Route::get('/sales_delivery/print/PDF/fas/{id}',                        'SaleDeliveryController@cetak_pdf_fas');
    Route::get('/sales_delivery/print/PDF/gelora/{id}',                     'SaleDeliveryController@cetak_pdf_gg');
    Route::get('/sales_delivery/print/PDF/sukses/{id}',                     'SaleDeliveryController@cetak_pdf_sukses');
    Route::get('/sales_delivery/print/PDF/sukses_surabaya/{id}',            'SaleDeliveryController@cetak_pdf_sukses_surabaya');
    Route::get('/sales_delivery/delete/{id}',                               'SaleDeliveryController@destroy');

    Route::get('/sales_payment',                                            'SalePaymentController@index');
    Route::get('/sales_payment/new/from/{id}',                              'SalePaymentController@createFromSale');
    Route::post('/sales_payment/newFromSale',                               'SalePaymentController@store');
    Route::get('/sales_payment/edit/{id}',                                  'SalePaymentController@edit');
    Route::post('/sales_payment/updatePayment',                             'SalePaymentController@update');
    Route::get('/sales_payment/{id}',                                       'SalePaymentController@show');
    Route::get('/sales_payment/print/PDF/1/{id}',                           'SalePaymentController@cetak_pdf_1');
    Route::get('/sales_payment/print/PDF/fas/{id}',                         'SalePaymentController@cetak_pdf_fas');
    Route::get('/sales_payment/print/PDF/gelora/{id}',                      'SalePaymentController@cetak_pdf_gg');
    Route::get('/sales_payment/print/PDF/sukses/{id}',                      'SalePaymentController@cetak_pdf_sukses');
    Route::get('/sales_payment/print/PDF/sukses_surabaya/{id}',             'SalePaymentController@cetak_pdf_sukses_surabaya');
    Route::get('/sales_payment/delete/{id}',                                'SalePaymentController@destroy');
    /*###################################### SALES /*######################################*/


    /*###################################### PURCHASES /*######################################*/
    Route::get('/purchases_invoice/select_product',                         'PurchaseInvoiceController@select_product');
    Route::get('/purchases_invoice/select_contact',                         'PurchaseInvoiceController@select_contact');
    Route::get('/purchases_invoice',                                        'PurchaseInvoiceController@index');
    Route::get('/purchases_invoice/new',                                    'PurchaseInvoiceController@create');
    Route::get('/purchases_invoice/newRS',                                  'PurchaseInvoiceController@createRequestSuksesPartOne');
    Route::get('/purchases_invoice/newRS/{contact}_{warehouse}',            'PurchaseInvoiceController@createRequestSuksesPartTwo');
    Route::get('/purchases_invoice/new/fromQuote/{id}',                     'PurchaseInvoiceController@createFromQuote');
    Route::get('/purchases_invoice/new/fromOrder/{id}',                     'PurchaseInvoiceController@createFromOrder');
    Route::get('/purchases_invoice/new/fromDelivery/{id}',                  'PurchaseInvoiceController@createFromDelivery');
    Route::post('/purchases_invoice/newPInvoice',                           'PurchaseInvoiceController@store');
    Route::post('/purchases_invoice/newInvoiceFromQuote',                   'PurchaseInvoiceController@storeFromQuote');
    Route::post('/purchases_invoice/newInvoiceFromOrder',                   'PurchaseInvoiceController@storeFromOrder');
    Route::post('/purchases_invoice/newInvoiceFromDelivery',                'PurchaseInvoiceController@storeFromDelivery');
    Route::post('/purchases_invoice/newInvoiceRS',                          'PurchaseInvoiceController@storeRequestSukses');
    Route::get('/purchases_invoice/edit/{id}',                              'PurchaseInvoiceController@edit');
    Route::post('/purchases_invoice/updatePInvoice',                        'PurchaseInvoiceController@update');
    Route::post('/purchases_invoice/updatePInvoiceFromQuote',               'PurchaseInvoiceController@updateFromQuote');
    Route::post('/purchases_invoice/updatePInvoiceFromOrder',               'PurchaseInvoiceController@updateFromOrder');
    Route::post('/purchases_invoice/updatePInvoiceFromDelivery',            'PurchaseInvoiceController@updateFromDelivery');
    Route::get('/purchases_invoice/{id}',                                   'PurchaseInvoiceController@show');
    Route::get('/purchases_invoice/print/PDF/1/{id}',                       'PurchaseInvoiceController@cetak_pdf_1');
    Route::get('/purchases_invoice/print/PDF/2/{id}',                       'PurchaseInvoiceController@cetak_pdf_2');
    Route::get('/purchases_invoice/print/PDF/3/{id}',                       'PurchaseInvoiceController@cetak_pdf_3');
    Route::get('/purchases_invoice/print/PDF/4/{id}',                       'PurchaseInvoiceController@cetak_pdf_4');
    Route::get('/purchases_invoice/print/PDF/5/{id}',                       'PurchaseInvoiceController@cetak_pdf_5');
    Route::get('/purchases_invoice/print/PDF/fas/{id}',                     'PurchaseInvoiceController@cetak_pdf_fas');
    Route::get('/purchases_invoice/print/PDF/gelora/{id}',                  'PurchaseInvoiceController@cetak_pdf_gg');
    Route::get('/purchases_invoice/print/PDF/sukses/{id}',                  'PurchaseInvoiceController@cetak_pdf_sukses');
    Route::get('/purchases_invoice/print/PDF/sukses_surabaya/{id}',         'PurchaseInvoiceController@cetak_pdf_sukses_surabaya');
    Route::get('/purchases_invoice/delete/{id}',                            'PurchaseInvoiceController@destroy');

    Route::get('/purchases_return',                                         'PurchaseReturnController@index');
    Route::get('/purchases_return/new/{id}',                                'PurchaseReturnController@create');
    Route::post('/purchases_return/newReturn',                              'PurchaseReturnController@store');
    Route::get('/purchases_return/{id}',                                    'PurchaseReturnController@show');
    Route::get('/purchases_return/edit/{id}',                               'PurchaseReturnController@edit');
    Route::post('/purchases_return/updateReturn',                           'PurchaseReturnController@update');
    Route::get('/purchases_return/delete/{id}',                             'PurchaseReturnController@destroy');
    Route::get('/purchases_return/print/PDF/1/{id}',                        'PurchaseReturnController@cetak_pdf_1');
    Route::get('/purchases_return/print/PDF/2/{id}',                        'PurchaseReturnController@cetak_pdf_2');
    Route::get('/purchases_return/print/PDF/fas/{id}',                      'PurchaseReturnController@cetak_pdf_fas');
    Route::get('/purchases_return/print/PDF/gelora/{id}',                   'PurchaseReturnController@cetak_pdf_gg');
    Route::get('/purchases_return/print/PDF/sukses/{id}',                   'PurchaseReturnController@cetak_pdf_sukses');
    Route::get('/purchases_return/print/PDF/sukses_surabaya/{id}',          'PurchaseReturnController@cetak_pdf_sukses_surabaya');

    Route::get('/purchases_order/select_product',                           'PurchaseOrderController@select_product');
    Route::get('/purchases_order/select_contact',                           'PurchaseOrderController@select_contact');
    Route::post('/purchases_order/closeOrder/{id}',                         'PurchaseOrderController@closeOrder');
    Route::get('/purchases_order',                                          'PurchaseOrderController@index');
    Route::get('/purchases_order/new',                                      'PurchaseOrderController@create');
    Route::get('/purchases_order/newRS',                                    'PurchaseOrderController@createRequestSukses');
    Route::get('/purchases_order/new/fromQuote/{id}',                       'PurchaseOrderController@createFromQuote');
    Route::post('/purchases_order/newPOrder',                               'PurchaseOrderController@store');
    Route::post('/purchases_order/newOrderFromQuote',                       'PurchaseOrderController@storeFromQuote');
    Route::post('/purchases_order/newOrderRequestSukses',                   'PurchaseOrderController@storeRequestSukses');
    Route::get('/purchases_order/edit/{id}',                                'PurchaseOrderController@edit');
    Route::post('/purchases_order/updatePOrder',                            'PurchaseOrderController@update');
    Route::post('/purchases_order/updatePOrderRequestSukses',               'PurchaseOrderController@updateRequestSukses');
    Route::get('/purchases_order/{id}',                                     'PurchaseOrderController@show');
    Route::get('/purchases_order/print/PDF/1/{id}',                         'PurchaseOrderController@cetak_pdf_1');
    Route::get('/purchases_order/print/PDF/2/{id}',                         'PurchaseOrderController@cetak_pdf_2');
    Route::get('/purchases_order/print/PDF/fas/{id}',                       'PurchaseOrderController@cetak_pdf_fas');
    Route::get('/purchases_order/print/PDF/gelora/{id}',                    'PurchaseOrderController@cetak_pdf_gg');
    Route::get('/purchases_order/print/PDF/sukses/{id}',                    'PurchaseOrderController@cetak_pdf_sukses');
    Route::get('/purchases_order/print/PDF/sukses_surabaya/{id}',           'PurchaseOrderController@cetak_pdf_sukses_surabaya');
    Route::get('/purchases_order/delete/{id}',                              'PurchaseOrderController@destroy');

    Route::get('/purchases_quote/select_product',                           'PurchaseQuoteController@select_product');
    Route::get('/purchases_quote/select_contact',                           'PurchaseQuoteController@select_contact');
    Route::get('/purchases_quote',                                          'PurchaseQuoteController@index');
    Route::get('/purchases_quote/new',                                      'PurchaseQuoteController@create');
    Route::post('/purchases_quote/newPQuote',                               'PurchaseQuoteController@store');
    Route::get('/purchases_quote/edit/{id}',                                'PurchaseQuoteController@edit');
    Route::post('/purchases_quote/updatePQuote',                            'PurchaseQuoteController@update');
    Route::get('/purchases_quote/{id}',                                     'PurchaseQuoteController@show');
    Route::get('/purchases_quote/print/PDF/1/{id}',                         'PurchaseQuoteController@cetak_pdf_1');
    Route::get('/purchases_quote/print/PDF/2/{id}',                         'PurchaseQuoteController@cetak_pdf_2');
    Route::get('/purchases_quote/print/PDF/fas/{id}',                       'PurchaseQuoteController@cetak_pdf_fas');
    Route::get('/purchases_quote/print/PDF/gelora/{id}',                    'PurchaseQuoteController@cetak_pdf_gg');
    Route::get('/purchases_quote/print/PDF/sukses/{id}',                    'PurchaseQuoteController@cetak_pdf_sukses');
    Route::get('/purchases_quote/print/PDF/sukses_surabaya/{id}',           'PurchaseQuoteController@cetak_pdf_sukses_surabaya');
    Route::get('/purchases_quote/print/PDF/sukses_surabaya_sj/{id}',        'PurchaseQuoteController@cetak_pdf_sukses_surabaya_sj');
    Route::get('/purchases_quote/delete/{id}',                              'PurchaseQuoteController@destroy');

    Route::get('/purchases_delivery',                                       'PurchaseDeliveryController@index');
    Route::get('/purchases_delivery/new/from/{id}',                         'PurchaseDeliveryController@createFromPO');
    Route::post('/purchases_delivery/newDelivery',                          'PurchaseDeliveryController@storeFromPO');
    Route::get('/purchases_delivery/edit/from/{id}',                        'PurchaseDeliveryController@edit');
    Route::post('/purchases_delivery/updateDelivery',                       'PurchaseDeliveryController@updateFromPO');
    Route::get('/purchases_delivery/{id}',                                  'PurchaseDeliveryController@show');
    Route::get('/purchases_delivery/delete/{id}',                           'PurchaseDeliveryController@destroy');

    Route::get('/purchases_payment',                                        'PurchasePaymentController@index');
    Route::get('/purchases_payment/new/from/{id}',                          'PurchasePaymentController@createFromPurchase');
    Route::post('/purchases_payment/newFromPurchase',                       'PurchasePaymentController@store');
    Route::get('/purchases_payment/edit/{id}',                              'PurchasePaymentController@edit');
    Route::post('/purchases_payment/updatePayment',                         'PurchasePaymentController@update');
    Route::get('/purchases_payment/{id}',                                   'PurchasePaymentController@show');
    Route::get('/purchases_payment/print/PDF/1/{id}',                       'PurchasePaymentController@cetak_pdf_1');
    Route::get('/purchases_payment/print/PDF/fas/{id}',                     'PurchasePaymentController@cetak_pdf_fas');
    Route::get('/purchases_payment/print/PDF/gelora/{id}',                  'PurchasePaymentController@cetak_pdf_gg');
    Route::get('/purchases_payment/print/PDF/sukses/{id}',                  'PurchasePaymentController@cetak_pdf_sukses');
    Route::get('/purchases_payment/print/PDF/sukses_surabaya/{id}',         'PurchasePaymentController@cetak_pdf_sukses_surabaya');
    Route::get('/purchases_payment/delete/{id}',                            'PurchasePaymentController@destroy');
    /*###################################### PURCHASES /*######################################*/

    /*---------Expenses --------------*/
    Route::get('/expenses',                                                 'ExpenseController@index');
    Route::get('/expenses/new',                                             'ExpenseController@create');
    Route::post('/expenses/newExpense',                                     'ExpenseController@store');
    Route::get('/expenses/edit/{id}',                                       'ExpenseController@edit');
    Route::post('/expenses/updateExpenseNotNull',                           'ExpenseController@updateNotNull');
    Route::post('/expenses/updateExpenseNull',                              'ExpenseController@updateNull');
    Route::get('/expenses/{id}',                                            'ExpenseController@show');
    Route::get('/expenses/print/PDF1/{id}',                                 'ExpenseController@cetak_pdfNotNull');
    Route::get('/expenses/print/PDF2/{id}',                                 'ExpenseController@cetak_pdfNull');
    Route::get('/expenses/deleteNotNull/{id}',                              'ExpenseController@destroyNotNull');
    Route::get('/expenses/deleteNull/{id}',                                 'ExpenseController@destroyNull');

    /*---------Contacts --------------*/
    Route::get('/contacts_customer',                                        'ContactController@indexCustomer');
    Route::get('/contacts_vendor',                                          'ContactController@indexVendor');
    Route::get('/contacts_employee',                                        'ContactController@indexEmployee');
    Route::get('/contacts_other',                                           'ContactController@indexOther');
    Route::get('/contacts_all',                                             'ContactController@indexAll');

    Route::post('/contacts/import_excel',                                   'ContactController@import_excel');
    Route::get('/contacts/export_excel',                                    'ContactController@export_excel');
    Route::get('/contacts/export_csv',                                      'ContactController@export_csv');
    Route::get('/contacts/export_pdf',                                      'ContactController@export_pdf');

    Route::get('/contacts/new',                                             'ContactController@create');
    Route::post('/contacts/newContact',                                     'ContactController@store');
    Route::post('/contacts/newContactLimit/{id}',                           'ContactController@storeLimit');
    Route::get('/contacts/{id}',                                            'ContactController@show');
    Route::get('/contacts/edit/{id}',                                       'ContactController@edit');
    Route::post('/contacts/updateContact',                                  'ContactController@update');
    Route::get('/contacts/delete/{id}',                                     'ContactController@destroy');

    /*---------Products --------------*/
    Route::get('/selectProduct',                                            'ProductController@selectProduct');

    Route::get('/products/select_product',                                  'ProductController@select_product');
    Route::get('/products',                                                 'ProductController@index');
    Route::post('/products/import_excel',                                   'ProductController@import_excel');
    Route::get('/products/export_excel',                                    'ProductController@export_excel');
    Route::get('/products/export_csv',                                      'ProductController@export_csv');
    Route::get('/products/export_pdf',                                      'ProductController@export_pdf');
    Route::get('/products/new',                                             'ProductController@create');
    Route::post('/products/newProduct',                                     'ProductController@store');
    Route::post('/products/newProductRequestJoyday',                        'ProductController@storeRequestJoyday');
    Route::get('/products/{id}',                                            'ProductController@show');
    Route::get('/products/edit/{id}',                                       'ProductController@edit');
    Route::post('/products/updateProduct',                                  'ProductController@update');
    Route::get('/products/delete/{id}',                                     'ProductController@destroy');

    Route::get('/production_one',                                           'ProductionOneController@index');
    Route::get('/production_one/new',                                       'ProductionOneController@create');
    Route::post('/production_one/newProduction',                            'ProductionOneController@store');
    Route::get('/production_one/{id}',                                      'ProductionOneController@show');

    Route::get('/production_two',                                           'ProductionTwoController@index');
    Route::get('/production_two/new',                                       'ProductionTwoController@create');
    Route::post('/production_two/newProduction',                            'ProductionTwoController@store');
    Route::get('/production_two/{id}',                                      'ProductionTwoController@show');

    Route::get('/production_three',                                         'ProductionThreeController@index');
    Route::get('/production_three/new',                                     'ProductionThreeController@create');
    Route::post('/production_three/newProduction',                          'ProductionThreeController@store');
    Route::get('/production_three/{id}',                                    'ProductionThreeController@show');

    Route::get('/production_four',                                          'ProductionFourController@index');
    Route::get('/production_four/new',                                      'ProductionFourController@create');
    Route::post('/production_four/newProduction',                           'ProductionFourController@store');
    Route::get('/production_four/{id}',                                     'ProductionFourController@show');

    Route::get('/stock_adjustment',                                         'StockAdjustmentController@index');
    Route::get('/stock_adjustment/new',                                     'StockAdjustmentController@createPartOne');
    Route::get('/stock_adjustment/new/stock_count/{type}_{cat}&{war}',      'StockAdjustmentController@createPartTwoStockCount');
    Route::get('/stock_adjustment/new/stock_inout/{type}_{cat}&{war}',      'StockAdjustmentController@createPartTwoStockInOut');
    Route::post('/stock_adjustment/newStockCount',                          'StockAdjustmentController@storeStockCount');
    Route::post('/stock_adjustment/newStockInOut',                          'StockAdjustmentController@storeStockInOut');
    Route::get('/stock_adjustment/{id}',                                    'StockAdjustmentController@show');
    Route::get('/stock_adjustment/edit/stock_count/{id}',                   'StockAdjustmentController@editStockCount');
    Route::get('/stock_adjustment/edit/stock_inout/{id}',                   'StockAdjustmentController@editStockInOut');
    Route::post('/stock_adjustment/updateStockCount',                       'StockAdjustmentController@updateStockCount');
    Route::post('/stock_adjustment/updateStockInOut',                       'StockAdjustmentController@updateStockInOut');
    Route::get('/stock_adjustment/delete/stock_count/{id}',                 'StockAdjustmentController@destroyStockCount');
    Route::get('/stock_adjustment/delete/stock_inout/{id}',                 'StockAdjustmentController@destroyStockInOut');

    Route::get('/warehouses',                                               'WarehouseController@index');
    Route::get('/warehouses/new',                                           'WarehouseController@create');
    Route::post('/warehouses/newWarehouse',                                 'WarehouseController@store');
    Route::get('/warehouses/{id}',                                          'WarehouseController@show');
    Route::get('/warehouses/edit/{id}',                                     'WarehouseController@edit');
    Route::post('/warehouses/updateWarehouse',                              'WarehouseController@update');
    Route::get('/warehouses/delete/{id}',                                   'WarehouseController@destroy');

    Route::get('/warehouses_transfer',                                      'WarehouseController@indexTransfer');
    Route::get('/warehouses_transfer/new',                                  'WarehouseController@createTransferPartOne');
    Route::get('/warehouses_transfer/new/{from}_{to}',                      'WarehouseController@createTransferPartTwo');
    Route::post('/warehouses_transfer/newTransfer',                         'WarehouseController@storeTransfer');
    Route::get('/warehouses_transfer/{id}',                                 'WarehouseController@showTransfer');
    Route::get('/warehouses_transfer/edit/{id}',                            'WarehouseController@editTransfer');
    Route::post('/warehouses_transfer/updateTransfer',                      'WarehouseController@updateTransfer');
    Route::get('/warehouses_transfer/delete/{id}',                          'WarehouseController@destroyTransfer');

    /*---------Asset Managements --------------*/
    Route::get('/asset_managements',                                        'FixedAssetController@index');
    Route::get('/asset_managements/new',                                    'FixedAssetController@create');
    Route::post('/asset_managements/newAsset',                              'FixedAssetController@store')->name('asset.store');
    Route::get('/asset_managements/show',                                   'FixedAssetController@show');
    Route::get('/asset_managements/edit',                                   'FixedAssetController@edit');
    Route::post('/asset_managements/edit/{id}',                             'FixedAssetController@update')->name('asset.update');;
    Route::get('/asset_managements/delete/{id}',                            'FixedAssetController@destroy');

    /*---------CoA--------------*/
    Route::get('/chart_of_accounts',                                        'CoAController@index');
    Route::get('/chart_of_accounts/new',                                    'CoAController@create');
    Route::post('/chart_of_accounts/newAccount',                            'CoAController@store');
    Route::get('/chart_of_accounts/{id}',                                   'CoAController@show');
    Route::get('/chart_of_accounts/edit/{id}',                              'CoAController@edit');
    Route::post('/chart_of_accounts/updateAccount',                         'CoAController@update');
    Route::get('/chart_of_accounts/delete/{id}',                            'CoAController@destroy');

    Route::get('/chart_of_accounts/journal_entry',                          'JournalEntryController@index');
    Route::get('/chart_of_accounts/journal_entry/new',                      'JournalEntryController@create');
    Route::post('/chart_of_accounts/journal_entry/newJournalEntry',         'JournalEntryController@store');
    Route::get('/chart_of_accounts/journal_entry/{id}',                     'JournalEntryController@show');
    Route::get('/chart_of_accounts/journal_entry/edit',                     'JournalEntryController@edit');
    Route::post('/chart_of_accounts/journal_entry/updateAccount',           'JournalEntryController@update');
    Route::get('/chart_of_accounts/journal_entry/delete/{id}',              'JournalEntryController@destroy');

    /*---------Other List--------------*/
    Route::get('/other', function () {
        return view('admin.other.index');
    })->name('otherindex');

    Route::get('/other/taxes',                                              'OtherTaxController@index');
    Route::get('/other/taxes/new',                                          'OtherTaxController@create');
    Route::post('/other/taxes/newTaxes',                                    'OtherTaxController@store');
    Route::get('/other/taxes/{id}',                                         'OtherTaxController@show');
    Route::get('/other/taxes/edit/{id}',                                    'OtherTaxController@edit');
    Route::post('/other/taxes/updateTaxes',                                 'OtherTaxController@update');
    Route::get('/other/taxes/delete/{id}',                                  'OtherTaxController@destroy');

    Route::get('/other/terms',                                              'OtherTermController@index');
    Route::get('/other/terms/new',                                          'OtherTermController@create');
    Route::post('/other/terms/newTerms',                                    'OtherTermController@store');
    Route::get('/other/terms/{id}',                                         'OtherTermController@show');
    Route::get('/other/terms/edit/{id}',                                    'OtherTermController@edit');
    Route::post('/other/terms/updateTerms',                                 'OtherTermController@update');
    Route::get('/other/terms/delete/{id}',                                  'OtherTermController@destroy');

    Route::get('/other/units',                                              'OtherUnitController@index');
    Route::get('/other/units/new',                                          'OtherUnitController@create');
    Route::post('/other/units/newUnits',                                    'OtherUnitController@store');
    Route::get('/other/units/{id}',                                         'OtherUnitController@show');
    Route::get('/other/units/edit/{id}',                                    'OtherUnitController@edit');
    Route::post('/other/units/updateUnits',                                 'OtherUnitController@update');
    Route::get('/other/units/delete/{id}',                                  'OtherUnitController@destroy');

    Route::get('/other/product_categories',                                 'OtherProductCategoryController@index');
    Route::get('/other/product_categories/new',                             'OtherProductCategoryController@create');
    Route::post('/other/product_categories/newCategory',                    'OtherProductCategoryController@store');
    Route::get('/other/product_categories/{id}',                            'OtherProductCategoryController@show');
    Route::get('/other/product_categories/edit/{id}',                       'OtherProductCategoryController@edit');
    Route::post('/other/product_categories/updateCategory',                 'OtherProductCategoryController@update');
    Route::get('/other/product_categories/delete/{id}',                     'OtherProductCategoryController@destroy');

    Route::get('/other/payment_methods',                                    'OtherPaymentMethodController@index');
    Route::get('/other/payment_methods/new',                                'OtherPaymentMethodController@create');
    Route::post('/other/payment_methods/newMethod',                         'OtherPaymentMethodController@store');
    Route::get('/other/payment_methods/{id}',                               'OtherPaymentMethodController@show');
    Route::get('/other/payment_methods/edit/{id}',                          'OtherPaymentMethodController@edit');
    Route::post('/other/payment_methods/updateMethod',                      'OtherPaymentMethodController@update');
    Route::get('/other/payment_methods/delete/{id}',                        'OtherPaymentMethodController@destroy');

    Route::get('/other/transactions',                                       'OtherTransactionController@index');

    Route::get('/transactions', function () {
        return view('admin.other.transactions.index');
    });
    Route::resource('/product_categories', 'ProductCategoryController');
    Route::get('/payment_methods', function () {
        return view('admin.other.payment_methods.index');
    });
    Route::get('/payment_methods/show', function () {
        return view('admin.other.payment_methods.show');
    });
    Route::get('/payment_methods/create', function () {
        return view('admin.other.payment_methods.create');
    });
    Route::get('/payment_methods/edit', function () {
        return view('admin.other.payment_methods.edit');
    });
    Route::get('/taxes', function () {
        return view('admin.other.taxes.index');
    });
    Route::get('/taxes/show', function () {
        return view('admin.other.taxes.show');
    });
    Route::get('/taxes/create', function () {
        return view('admin.other.taxes.create');
    });
    Route::get('/taxes/edit', function () {
        return view('admin.other.taxes.edit');
    });
    Route::resource('/product_units', 'ProductUnitController');
    Route::get('/terms', function () {
        return view('admin.other.terms.index');
    });
    Route::get('/terms/create', function () {
        return view('admin.other.terms.create');
    });
    Route::get('/terms/edit', function () {
        return view('admin.other.terms.edit');
    });
    /* ini yang baru di web */
    Route::group(['prefix' => 'settings'], function () {

        Route::resource('/user', 'UserController', [
            'names' => [
                'index' => 'user',
            ]
        ]);
        Route::get('/user/roles/{id}', 'UserController@roles');
        Route::post('/user/roles/{id}', 'UserController@setRole')->name('user.roles');

        Route::get('/account', 'SettingController@account_index')->name('acc_map.index');
        Route::post('/account', 'SettingController@account_store')->name('acc_map.store');

        Route::get('/company', 'SettingController@company_index')->name('company.index');
        Route::post('/company', 'SettingController@company_store')->name('company.store');
    });
    Route::get('/coa/select_account',                                       'SettingController@select_account');

    /*---------Setting--------------*/
    Route::get('/setting', function () {
        return view('admin.settings.index');
    })->name('settingindex');
    ##############################################################
    ####################### REQUEST SUKSES #######################
    ##############################################################

    Route::get('/spk/select_product',                                       'SpkController@select_product');
    Route::get('/spk/select_contact',                                       'SpkController@select_contact');
    Route::get('/spk',                                                      'SpkController@index');
    Route::get('/spk/new',                                                  'SpkController@create');
    Route::post('/spk/newSPK',                                              'SpkController@store');
    Route::get('/spk/{id}',                                                 'SpkController@show');
    Route::get('/spk/edit/{id}',                                            'SpkController@edit');
    Route::post('/spk/updateSPK',                                           'SpkController@update');
    Route::get('/spk/delete/{id}',                                          'SpkController@destroy');
    Route::get('/spk/print/PDF/{id}',                                       'SpkController@cetak_pdf');

    Route::get('/wip/select_product',                                       'WipController@select_product');
    Route::get('/wip',                                                      'WipController@index');
    Route::get('/wip/new',                                                  'WipController@create');
    Route::get('/wip/new/fromSPK/{id}_{uid}',                               'WipController@createFromSPK');
    Route::post('/wip/newWIP_per',                                          'WipController@store_per');
    Route::post('/wip/newWIP_all',                                          'WipController@store_all');
    Route::get('/wip/{id}',                                                 'WipController@show');
    Route::get('/wip/edit/{id}',                                            'WipController@edit');
    Route::post('/wip/updateWIP',                                           'WipController@update');
    Route::get('/wip/delete/{id}/per',                                      'WipController@destroy_per');
    Route::get('/wip/delete/{id}/all',                                      'WipController@destroy_all');

    ##############################################################
    ####################### REQUEST SUKSES #######################
    ##############################################################
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
