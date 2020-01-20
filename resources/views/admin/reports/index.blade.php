@extends('layouts.admin')

@section('contentheader')
<div class="page-title">
    <div class="title_left">
        <h3>Reports</h3>
    </div>
    <!--<div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>-->
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>List of Reports</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content_overview" role="tab" id="accounts-tab" data-toggle="tab" aria-expanded="true">Overview</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content_sales" role="tab" id="sales-tab" data-toggle="tab" aria-expanded="false">Sales</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content_purchase" role="tab" id="purchases-tab2" data-toggle="tab" aria-expanded="false">Purchases</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content_expense" role="tab" id="products-tab2" data-toggle="tab" aria-expanded="false">Expense</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content_product" role="tab" id="products-tab2" data-toggle="tab" aria-expanded="false">Products</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content_production" role="tab" id="products-tab2" data-toggle="tab" aria-expanded="false">Production</a>
                        </li>
                        <!--<li role="presentation" class=""><a href="#tab_content5" role="tab" id="assets-tab2" data-toggle="tab" aria-expanded="false">Assets</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content6" role="tab" id="bank-tab2" data-toggle="tab" aria-expanded="false">Bank</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content7" role="tab" id="tax-tab2" data-toggle="tab" aria-expanded="false">Tax</a>
                        </li>-->
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content_overview" aria-labelledby="invoice-tab">
                            <!--<div class="row top_tiles">
                                <a href="/reports/balance_sheet">
                                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <div class="tile-stats">
                                            <div class="count">Balance Sheet</div>
                                            <div class="icon"><i class="fa fa-check-square-o"></i></div>
                                            <h3>Balance Sheet</h3>
                                            <p>Lorem ipsum psdea itgum rixt.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="/reports/profit_loss">
                                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <div class="tile-stats">
                                            <div class="count">Profit & Loss</div>
                                            <h3>New Sign ups</h3>
                                            <p>Lorem ipsum psdea itgum rixt.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="/reports/general_ledger">
                                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <div class="tile-stats">
                                            <div class="count">General Ledger</div>
                                            <h3>New Sign ups</h3>
                                            <p>Lorem ipsum psdea itgum rixt.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#">
                                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <div class="tile-stats">
                                            <div class="icon"><i class="fa fa-check-square-o"></i></div>
                                            <div class="count">179</div>
                                            <h3>New Sign ups</h3>
                                            <p>Lorem ipsum psdea itgum rixt.</p>
                                        </div>
                                    </div>
                                </a>
                            </div>-->
                            <a href="/reports/balance_sheet">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Balance Sheet</h3>
                                            <div class="divider"></div>
                                            <p>Lists what you own (assets), what your debts are (liabilities),
                                                and what you've invested in your company (equity).</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/general_ledger">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">General Ledger</h3>
                                            <div class="divider"></div>
                                            <p>This report lists all the transactions that occurred within a period of time.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/profit_loss">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Profit & Loss</h3>
                                            <div class="divider"></div>
                                            <p>Lists the individual transactions and totals for money you earned (income) and money you spent (expenses).</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/journal_report">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Journal</h3>
                                            <div class="divider"></div>
                                            <p>lists all journal entry per transaction that occurred within a period of time.
                                                It is useful to track where your transaction goes into each account</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/trial_balance">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Trial Balance</h3>
                                            <div class="divider"></div>
                                            <p>Display balance of each accounts, including opening balance, movement, and ending balance for selected period.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/cashflow">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Cash Flow</h3>
                                            <div class="divider"></div>
                                            <p>This report measures the cash generated or used by a company and shows how it has moved in a given period.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/executive_summary">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Executive Summary</h3>
                                            <div class="divider"></div>
                                            <p>A summary of financial statement and its insight.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content_sales" aria-labelledby="delivery-tab">
                            <a href="/reports/sales_list">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Sales List</h3>
                                            <div class="divider"></div>
                                            <p>Shows a chronological list of all your invoices, orders, quotes, and payments for a selected date range.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/sales_by_customer">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Sales by Customer</h3>
                                            <div class="divider"></div>
                                            <p>Lists the individual sales transactions for each customer, including dates, types, amounts, and totals.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/customer_balance">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Customer Balance</h3>
                                            <div class="divider"></div>
                                            <p>Lists unpaid invoices for each customer, including invoice date and number, due date, total, and amount owed to you (open balance).</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/aged_receivable">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Aged Receivable</h3>
                                            <div class="divider"></div>
                                            <p>This report gives summary of your account receivables, showing each customers owing to you,
                                                based on monthly basis, as well as a total amount over time.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/sales_delivery">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Sales Delivery Report</h3>
                                            <div class="divider"></div>
                                            <p>Lists all product deliveries recorded for sales transactions in a specified date range, grouped by customers.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/sales_by_product">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Sales by Product</h3>
                                            <div class="divider"></div>
                                            <p>Lists sold-item quantity for each product, including returns quantity, net sales, and average selling price</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!--<a href="/reports/sales_order_completion">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Sales Order Completion</h3>
                                            <div class="divider"></div>
                                            <p>Gives summary of your business process, showing quote, order, delivery, invoices, and payments per each process.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>-->
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content_purchase" aria-labelledby="order-tab">
                            <a href="/reports/purchases_list">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Purchases List</h3>
                                            <div class="divider"></div>
                                            <p>Shows a chronological list of all your invoices, orders, quotes, and payments for a selected date range.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/purchases_by_vendor">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Purchases by Vendor</h3>
                                            <div class="divider"></div>
                                            <p>Shows your individual purchases and totals for each vendor.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/vendor_balance">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Vendor Balance</h3>
                                            <div class="divider"></div>
                                            <p>Shows the total amount you owe each vendor.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/aged_payable">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Aged Payable</h3>
                                            <div class="divider"></div>
                                            <p>This report gives summary of your account payables, showing each vendors you are owing to based on monthly basis, as well as a total amount over time.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/purchases_delivery">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Purchases Delivery Report</h3>
                                            <div class="divider"></div>
                                            <p>Lists all product deliveries recorded for sales transactions in a specified date range, grouped by vendors.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/purchases_by_product">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Purchases by Product</h3>
                                            <div class="divider"></div>
                                            <p>Lists bought-item quantity for each product, including returns quantity, net bought, and average buying price</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!--<a href="/reports/purchases_order_completion">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Purchases Order Completion</h3>
                                            <div class="divider"></div>
                                            <p>Gives summary of your business process, showing quote, order, delivery, invoices, and payments per each process.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>-->
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content_expense" aria-labelledby="order-tab">
                            <a href="/reports/expenses_list">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Expense List</h3>
                                            <div class="divider"></div>
                                            <p>This report lists all expenses and its description within a date range.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/expenses_details">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Expense Details</h3>
                                            <div class="divider"></div>
                                            <p>This report details expense information, grouped within each category within a date range.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content_product" aria-labelledby="quote-tab">
                            <a href="/reports/inventory_summary">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Inventory Summary</h3>
                                            <div class="divider"></div>
                                            <p>Shows list of all stocked items' quantity and value as of a specified date.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/warehouse_stock_quantity">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Warehouse Stock Quantity</h3>
                                            <div class="divider"></div>
                                            <p>This report shows stocked quantity in each warehouse for all products.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/inventory_valuation">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Inventory Valuation</h3>
                                            <div class="divider"></div>
                                            <p>Summarizes key information, such as quantity on hand, value, and average cost, for each inventory item.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/warehouse_items_valuation">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Warehouse Items Valuation</h3>
                                            <div class="divider"></div>
                                            <p>This report shows inventory valuation in each warehouse for all products.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/inventory_details">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Inventory Details</h3>
                                            <div class="divider"></div>
                                            <p>Lists the transactions that each inventory item is linked to and shows how the transactions affected quantity on hand, value, and cost.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/warehouse_items_stock_movement">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Warehouse Item Stock Movement</h3>
                                            <div class="divider"></div>
                                            <p>This report shows stock inventory movement and details transactions that affects stock movement in each warehouse for
                                                all products or each products in all warehouses in a period .</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content_production" aria-labelledby="quote-tab">
                            <a href="/reports/spk_list">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Surat Perintah Kerja List</h3>
                                            <div class="divider"></div>
                                            <p>Shows list of all stocked items' quantity and value as of a specified date.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="/reports/spk_details">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Surat Perintah Kerja Details</h3>
                                            <div class="divider"></div>
                                            <p>This report shows stocked quantity in each warehouse for all products.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content_fixedasset" aria-labelledby="quote-tab">
                            <a href="#">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Fixed Asset Summary</h3>
                                            <div class="divider"></div>
                                            <p>Shows list of all recorded fixed assets cost, accumulated depreciation, and its book value.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Fixed Asset Details</h3>
                                            <div class="divider"></div>
                                            <p>Lists the transactions that each asset item is linked to and shows how the transactions affected its book value.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content_bank" aria-labelledby="quote-tab">
                            <a href="#">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Bank Reconciliation Summary</h3>
                                            <div class="divider"></div>
                                            <p>Show a summary of recorded bank reconciliation, as well as unidentified or unrecorded balance.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Bank Statement Reports</h3>
                                            <div class="divider"></div>
                                            <p>List of all bank statement transactions within a given period.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content_tax" aria-labelledby="quote-tab">
                            <a href="#">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Witholding Tax Reports</h3>
                                            <div class="divider"></div>
                                            <p>Showing summary of tax calculation with type witholding used in your transactions per object.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a href="#">
                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                    <div class="x_panel fixed_height_200">
                                        <div class="x_content">
                                            <h3 class="name">Sales Tax Reports</h3>
                                            <div class="divider"></div>
                                            <p>Showing summary of tax calculation with type adding used in your transactions.</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection