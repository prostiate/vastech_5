<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VastechConstruction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tenant_password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->boolean('is_trial')->default('1');
            $table->integer('duration')->default('7'); //*** DURASI BERAPA LAMA COMPANY BISA DI AKSES (EXPIRED DAYS)
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });

        Schema::create('company_settings', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('is_logo')->default('0');
            $table->string('name');
            $table->text('address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('logo_uploadeds', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->string('dimensions');
            $table->string('path');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('company_logos', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('mime');
            $table->string('original_filename');
            $table->string('filename');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('coa_categories', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('other_payment_methods', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('other_product_categories', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('other_statuses', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('coas', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('lock')->nullable()->default('1');
            $table->string('code')->nullable();
            $table->string('is_parent')->default('1');
            $table->integer('parent_id')->nullable();
            $table->string('name');
            $table->unsignedBigInteger('coa_category_id');
            $table->foreign('coa_category_id')
                ->references('id')->on('coa_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('cashbank')->default('0')->nullable();
            $table->unsignedBigInteger('default_tax')->nullable(); //*** gatau buat apaan
            $table->decimal('balance', 17, 2)->default('0')->nullable();
            $table->decimal('state_balance', 17, 2)->default('0')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('other_taxes', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->integer('rate');
            $table->unsignedBigInteger('sell_tax_account');
            $table->foreign('sell_tax_account')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('buy_tax_account');
            $table->foreign('buy_tax_account')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('other_units', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('other_terms', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->integer('length');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('default_accounts', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('display_name');
            $table->unsignedBigInteger('account_receivable_id');
            $table->foreign('account_receivable_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('account_payable_id');
            $table->foreign('account_payable_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('term_id');
            $table->foreign('term_id')
                ->references('id')->on('other_terms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('type_vendor')->default('1');
            $table->boolean('type_customer')->default('1');
            $table->boolean('type_employee')->default('1');
            $table->boolean('type_other')->default('1');
            $table->string('sales_type')->nullable();
            $table->boolean('is_limit')->default('0');
            $table->decimal('limit_balance', 17, 2)->default('0');
            $table->decimal('current_limit_balance', 17, 2)->default('0');
            $table->decimal('last_limit_balance', 17, 2)->default('0');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('handphone')->nullable();
            $table->string('identity_type')->nullable();
            $table->string('identity_id')->nullable();
            $table->string('email')->nullable();
            $table->string('another_info')->nullable();
            $table->string('company_name')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('npwp')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('history_limit_balances', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('to_limit_balance', 17, 2)->default('0');
            $table->decimal('from_limit_balance', 17, 2)->default('0');
            $table->string('type_limit_balance');
            $table->decimal('value', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('other_transactions', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->date('transaction_date');
            $table->string('number');
            $table->string('number_complete');
            $table->string('type');
            $table->text('memo')->nullable();
            $table->unsignedBigInteger('contact')->nullable();
            $table->foreign('contact')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('balance_due', 17, 2)->default('0');
            $table->decimal('total', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('coa_details', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->unsignedBigInteger('other_transaction_id')->nullable();
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('coa_id');
            $table->foreign('coa_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('type');
            $table->date('date')->nullable();
            $table->string('number');
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('debit', 17, 2)->default('0')->nullable();
            $table->decimal('credit', 17, 2)->default('0')->nullable();
            $table->decimal('balance', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('avg_price', 17, 2)->default('0');
            $table->string('name');
            $table->string('code')->nullable();
            $table->unsignedBigInteger('other_product_category_id');
            $table->foreign('other_product_category_id')
                ->references('id')->on('other_product_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_unit_id');
            $table->foreign('other_unit_id')
                ->references('id')->on('other_units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('desc')->nullable();
            $table->boolean('is_buy')->default('1');
            $table->decimal('buy_price', 17, 2)->default('0');
            $table->unsignedBigInteger('buy_tax')->default('1');
            $table->foreign('buy_tax')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('buy_account')->default('69');
            $table->foreign('buy_account')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('is_sell')->default('1');
            $table->decimal('sell_price', 17, 2)->default('0');
            $table->unsignedBigInteger('sell_tax')->default('1');
            $table->foreign('sell_tax')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sell_account')->default('65');
            $table->foreign('sell_account')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('is_track')->default('1');
            $table->boolean('is_bundle')->default('0');
            $table->boolean('is_production_bundle')->default('0');
            $table->boolean('is_discount')->default('0');
            $table->boolean('is_lock_sales')->default('0');
            $table->boolean('is_lock_purchase')->default('0');
            $table->boolean('is_lock_production')->default('0');
            $table->string('sales_type')->nullable();
            $table->integer('min_qty')->default('0');
            $table->unsignedBigInteger('default_inventory_account')->default('7');
            $table->foreign('default_inventory_account')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('qty', 20, 6)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_bundle_costs', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('coa_id');
            $table->foreign('coa_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_bundle_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('bundle_product_id');
            $table->foreign('bundle_product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('qty', 20, 6);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_discount_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('qty', 20, 6);
            $table->decimal('price', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_production_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('bundle_product_id');
            $table->foreign('bundle_product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('qty', 20, 6);
            $table->decimal('price', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('warehouses', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->string('code')->nullable();
            $table->text('address')->nullable();
            $table->string('desc')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('warehouse_details', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('date')->nullable();
            $table->double('qty_in', 20, 6)->default('0');
            $table->double('qty_out', 20, 6)->default('0');
            $table->string('type');
            $table->string('number')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('warehouse_transfers', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->date('transaction_date');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('from_warehouse_id');
            $table->foreign('from_warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('to_warehouse_id');
            $table->foreign('to_warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('memo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('warehouse_transfer_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('warehouse_transfer_id');
            $table->foreign('warehouse_transfer_id')
                ->references('id')->on('warehouse_transfers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('qty', 20, 6);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('spks', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('desc')->nullable();
            $table->date('transaction_date');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('vendor_ref_no')->nullable();
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('spk_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('spk_id');
            $table->foreign('spk_id')
                ->references('id')->on('spks')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('qty', 20, 6);
            $table->double('qty_remaining', 20, 6)->default('0');
            $table->double('qty_remaining_sent', 20, 6)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->integer('stock_type');
            $table->string('adjustment_type');
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('coa_id');
            $table->foreign('coa_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('date');
            $table->text('memo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('stock_adjustment_details', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('stock_adjustment_id');
            $table->foreign('stock_adjustment_id')
                ->references('id')->on('stock_adjustments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('recorded', 20, 6)->default('0');
            $table->double('actual', 20, 6)->default('0');
            $table->double('difference', 20, 6)->default('0');
            $table->double('avg_price', 20, 6)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('wips', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('transaction_no_spk');
            $table->unsignedBigInteger('result_product');
            $table->foreign('result_product')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('result_qty', 20, 6)->default('0');
            $table->unsignedBigInteger('selected_spk_id');
            $table->foreign('selected_spk_id')
                ->references('id')->on('spks')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('production_method')->default('0');
            $table->string('number');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('desc')->nullable();
            $table->date('transaction_date');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('vendor_ref_no')->nullable();
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('margin_type');
            $table->decimal('margin_value', 5, 3)->default('0');
            $table->decimal('margin_total', 17, 2)->default('0');
            $table->decimal('grandtotal_without_qty', 17, 2)->default('0');
            $table->decimal('grandtotal_with_qty', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('wip_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('wip_id');
            $table->foreign('wip_id')
                ->references('id')->on('wips')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('qty_require', 20, 6)->default('0');
            $table->double('qty_total', 20, 6)->default('0');
            $table->decimal('price', 17, 2)->default('0');
            $table->decimal('total_price', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('journal_entries', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->date('transaction_date');
            $table->text('memo')->nullable();
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('total_debit', 17, 2)->default('0');
            $table->decimal('total_credit', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('journal_entry_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('journal_entry_id');
            $table->foreign('journal_entry_id')
                ->references('id')->on('journal_entries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('coa_id');
            $table->foreign('coa_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->decimal('debit', 17, 2)->default('0');
            $table->decimal('credit', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('journal_opening_balances', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->date('transaction_date');
            $table->text('memo')->nullable();
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('total_debit', 17, 2)->default('0');
            $table->decimal('total_credit', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('journal_opening_balance_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('journal_opening_balance_id');
            $table->foreign('journal_opening_balance_id')
                ->references('id')->on('journal_opening_balances')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('coa_id');
            $table->foreign('coa_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->decimal('debit', 17, 2)->default('0')->nullable();
            $table->decimal('credit', 17, 2)->default('0')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('journal_entry_id');
            $table->foreign('journal_entry_id')
                ->references('id')->on('journal_entries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->string('number');
            $table->unsignedBigInteger('asset_account');
            $table->foreign('asset_account')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('description')->nullable();
            $table->date('date');
            $table->decimal('cost', 17, 2)->default('0');
            $table->decimal('actual_cost', 17, 2)->default('0');
            $table->unsignedBigInteger('credited_account');
            $table->foreign('credited_account')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('is_depreciable')->default('0');
            $table->boolean('is_depreciated')->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('asset_details', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('asset_id');
            $table->foreign('asset_id')
                ->references('id')->on('assets')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('method');
            $table->integer('life');
            $table->integer('rate');
            $table->integer('depreciate_account');
            $table->unsignedBigInteger('accumulated_depreciate_account');
            $table->foreign('accumulated_depreciate_account')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('accumulated_depreciate', 17, 2)->default('0');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('payment_method_id');
            $table->foreign('payment_method_id')
                ->references('id')->on('other_payment_methods')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('pay_from_coa_id');
            $table->foreign('pay_from_coa_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('address')->nullable();
            $table->date('transaction_date');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('term_id')->nullable();
            $table->foreign('term_id')
                ->references('id')->on('other_terms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('memo')->nullable();
            $table->decimal('subtotal', 17, 2)->default('0');
            $table->decimal('taxtotal', 17, 2)->default('0');
            $table->decimal('amount_paid', 17, 2)->default('0');
            $table->decimal('balance_due', 17, 2)->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('expense_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('expense_id');
            $table->foreign('expense_id')
                ->references('id')->on('expenses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('coa_id');
            $table->foreign('coa_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amountsub', 17, 2)->default('0');
            $table->decimal('amounttax', 17, 2)->default('0');
            $table->decimal('amountgrand', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cashbanks', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('bank_transfer')->nullable();
            $table->boolean('bank_deposit')->nullable();
            $table->boolean('bank_withdrawal_acc')->nullable();
            $table->boolean('bank_withdrawal_ex')->nullable();
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('date');
            $table->string('number');
            $table->unsignedBigInteger('pay_from')->nullable();
            $table->foreign('pay_from')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('transfer_from')->nullable();
            $table->foreign('transfer_from')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('deposit_to')->nullable();
            $table->foreign('deposit_to')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('memo')->nullable();
            $table->decimal('subtotal', 17, 2)->default('0');
            $table->decimal('taxtotal', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cashbank_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('cashbank_id');
            $table->foreign('cashbank_id')
                ->references('id')->on('cashbanks')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('receive_from')->nullable();
            $table->foreign('receive_from')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('expense_id')->nullable();
            $table->foreign('expense_id')
                ->references('id')->on('expenses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->foreign('tax_id')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amountsub', 17, 2)->default('0');
            $table->decimal('amounttax', 17, 2)->default('0');
            $table->decimal('amountgrand', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
        //*** START PURCHASES
        Schema::create('purchase_quotes', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('transaction_date');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('term_id');
            $table->foreign('term_id')
                ->references('id')->on('other_terms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('vendor_ref_no')->nullable();
            $table->text('message')->nullable();
            $table->text('memo')->nullable();
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('subtotal', 17, 2)->default('0');
            $table->decimal('taxtotal', 17, 2)->default('0');
            $table->decimal('balance_due', 17, 2)->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_quote_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_quote_id');
            $table->foreign('purchase_quote_id')
                ->references('id')->on('purchase_quotes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->double('qty', 20, 6);
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')
                ->references('id')->on('other_units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('unit_price', 17, 2)->default('0');
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amountsub', 17, 2)->default('0');
            $table->decimal('amounttax', 17, 2)->default('0');
            $table->decimal('amountgrand', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('transaction_date');
            $table->date('due_date');
            $table->unsignedBigInteger('term_id');
            $table->foreign('term_id')
                ->references('id')->on('other_terms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('transaction_no_pq')->nullable();
            $table->string('vendor_ref_no')->nullable();
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('jasa_only')->default('0');
            $table->text('message')->nullable();
            $table->text('memo')->nullable();
            $table->decimal('deposit', 17, 2)->default('0');
            $table->decimal('subtotal', 17, 2)->default('0');
            $table->decimal('taxtotal', 17, 2)->default('0');
            $table->decimal('balance_due', 17, 2)->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('selected_pq_id')->nullable();
            $table->foreign('selected_pq_id')
                ->references('id')->on('purchase_quotes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('total_qty', 20, 6)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_order_id');
            $table->foreign('purchase_order_id')
                ->references('id')->on('purchase_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->double('qty', 20, 6);
            $table->double('qty_remaining', 20, 6);
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')
                ->references('id')->on('other_units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('unit_price', 17, 2)->default('0');
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amountsub', 17, 2)->default('0');
            $table->decimal('amounttax', 17, 2)->default('0');
            $table->decimal('amountgrand', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_deliveries', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('transaction_date');
            $table->unsignedBigInteger('term_id');
            $table->foreign('term_id')
                ->references('id')->on('other_terms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('transaction_no')->nullable();
            $table->string('vendor_ref_no')->nullable();
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('message')->nullable();
            $table->text('memo')->nullable();
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('subtotal', 17, 2)->default('0');
            $table->decimal('taxtotal', 17, 2)->default('0');
            $table->decimal('balance_due', 17, 2)->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('selected_pq_id')->nullable();
            $table->foreign('selected_pq_id')
                ->references('id')->on('purchase_quotes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('selected_po_id')->nullable();
            $table->foreign('selected_po_id')
                ->references('id')->on('purchase_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_delivery_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_delivery_id');
            $table->foreign('purchase_delivery_id')
                ->references('id')->on('purchase_deliveries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_order_item_id');
            $table->foreign('purchase_order_item_id')
                ->references('id')->on('purchase_order_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->double('qty', 20, 6);
            $table->double('qty_remaining', 20, 6);
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')
                ->references('id')->on('other_units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('unit_price', 17, 2)->default('0');
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amountsub', 17, 2)->default('0');
            $table->decimal('amounttax', 17, 2)->default('0');
            $table->decimal('amountgrand', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('transaction_date');
            $table->date('due_date');
            $table->unsignedBigInteger('term_id');
            $table->foreign('term_id')
                ->references('id')->on('other_terms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('transaction_no_pq')->nullable();
            $table->string('transaction_no_po')->nullable();
            $table->string('transaction_no_pd')->nullable();
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('vendor_ref_no')->nullable();
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('message')->nullable();
            $table->text('memo')->nullable();
            $table->decimal('subtotal', 17, 2)->default('0');
            $table->decimal('taxtotal', 17, 2)->default('0');
            $table->decimal('amount_paid', 17, 2)->default('0');
            $table->decimal('total_return', 17, 2)->default('0');
            $table->decimal('debit_memo', 17, 2)->default('0');
            $table->decimal('balance_due', 17, 2)->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('selected_pq_id')->nullable();
            $table->foreign('selected_pq_id')
                ->references('id')->on('purchase_quotes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('selected_po_id')->nullable();
            $table->foreign('selected_po_id')
                ->references('id')->on('purchase_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('selected_pd_id')->nullable();
            $table->foreign('selected_pd_id')
                ->references('id')->on('purchase_deliveries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('witholding_coa_id')->nullable();
            $table->foreign('witholding_coa_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('witholding_amount_rp', 17, 2)->nullable();
            $table->decimal('witholding_amount_per', 5, 3)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_invoice_id');
            $table->foreign('purchase_invoice_id')
                ->references('id')->on('purchase_invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_order_item_id')->nullable();
            $table->foreign('purchase_order_item_id')
                ->references('id')->on('purchase_order_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->double('qty', 20, 6);
            $table->double('qty_remaining', 20, 6)->nullable();
            $table->double('qty_remaining_return', 20, 6)->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')
                ->references('id')->on('other_units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('unit_price', 17, 2)->default('0');
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amountsub', 17, 2)->default('0');
            $table->decimal('amounttax', 17, 2)->default('0');
            $table->decimal('amountgrand', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_invoice_pos', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_invoice_id');
            $table->foreign('purchase_invoice_id')
                ->references('id')->on('purchase_invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_order_id');
            $table->foreign('purchase_order_id')
                ->references('id')->on('purchase_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amount', 17, 2)->default('0')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_invoice_po_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_invoice_id');
            $table->foreign('purchase_invoice_id')
                ->references('id')->on('purchase_invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_order_id');
            $table->foreign('purchase_order_id')
                ->references('id')->on('purchase_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_order_item_id');
            $table->foreign('purchase_order_item_id')
                ->references('id')->on('purchase_order_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('qty', 20, 6);
            $table->double('qty_remaining_return', 20, 6);
            $table->decimal('unit_price', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_payments', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_payment_method_id');
            $table->foreign('other_payment_method_id')
                ->references('id')->on('other_payment_methods')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->date('transaction_date');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('transaction_no_pi')->nullable();
            $table->foreign('transaction_no_pi')
                ->references('id')->on('purchase_invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('memo')->nullable();
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_payment_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_invoice_id');
            $table->foreign('purchase_invoice_id')
                ->references('id')->on('purchase_invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_payment_id');
            $table->foreign('purchase_payment_id')
                ->references('id')->on('purchase_payments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->decimal('payment_amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('transaction_date');
            $table->date('due_date');
            $table->date('return_date');
            $table->string('transaction_no_pi')->nullable();
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('message')->nullable();
            $table->text('memo')->nullable();
            $table->decimal('subtotal', 17, 2)->default('0');
            $table->decimal('taxtotal', 17, 2)->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('selected_pi_id');
            $table->foreign('selected_pi_id')
                ->references('id')->on('purchase_invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_return_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_return_id');
            $table->foreign('purchase_return_id')
                ->references('id')->on('purchase_returns')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_invoice_item_id');
            $table->foreign('purchase_invoice_item_id')
                ->references('id')->on('purchase_invoice_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->foreign('purchase_order_id')
                ->references('id')->on('purchase_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_order_item_id')->nullable();
            $table->foreign('purchase_order_item_id')
                ->references('id')->on('purchase_order_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('qty_invoice', 20, 6);
            $table->double('qty_remaining_invoice', 20, 6);
            $table->double('qty', 20, 6);
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')
                ->references('id')->on('other_units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('unit_price', 17, 2)->default('0');
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amountsub', 17, 2)->default('0');
            $table->decimal('amounttax', 17, 2)->default('0');
            $table->decimal('amountgrand', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
        //*** END PURCHASES
        //*** START SALES
        Schema::create('sale_quotes', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('transaction_date');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('term_id');
            $table->foreign('term_id')
                ->references('id')->on('other_terms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('vendor_ref_no')->nullable();
            $table->text('message')->nullable();
            $table->text('memo')->nullable();
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('subtotal', 17, 2)->default('0');
            $table->decimal('taxtotal', 17, 2)->default('0');
            $table->decimal('balance_due', 17, 2)->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_quote_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_quote_id');
            $table->foreign('sale_quote_id')
                ->references('id')->on('sale_quotes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->double('qty', 20, 6);
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')
                ->references('id')->on('other_units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('unit_price', 17, 2)->default('0');
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amountsub', 17, 2)->default('0');
            $table->decimal('amounttax', 17, 2)->default('0');
            $table->decimal('amountgrand', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_orders', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('transaction_date');
            $table->date('due_date');
            $table->unsignedBigInteger('term_id');
            $table->foreign('term_id')
                ->references('id')->on('other_terms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('transaction_no_sq')->nullable();
            $table->string('vendor_ref_no')->nullable();
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('is_marketting')->default('0')->nullable();
            $table->unsignedBigInteger('marketting')->nullable();
            $table->foreign('marketting')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('message')->nullable();
            $table->text('memo')->nullable();
            $table->decimal('deposit', 17, 2)->default('0');
            $table->decimal('subtotal', 17, 2)->default('0');
            $table->decimal('taxtotal', 17, 2)->default('0');
            $table->decimal('balance_due', 17, 2)->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('selected_sq_id')->nullable();
            $table->foreign('selected_sq_id')
                ->references('id')->on('sale_quotes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('total_qty', 20, 6)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_order_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_order_id');
            $table->foreign('sale_order_id')
                ->references('id')->on('sale_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->double('qty', 20, 6);
            $table->double('qty_remaining', 20, 6);
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')
                ->references('id')->on('other_units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('harga_nota', 17, 2)->default('0')->nullable();
            $table->decimal('unit_price', 17, 2)->default('0');
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amountsub', 17, 2)->default('0');
            $table->decimal('amounttax', 17, 2)->default('0');
            $table->decimal('amountgrand', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_deliveries', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('transaction_date');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('transaction_no')->nullable();
            $table->string('vendor_ref_no')->nullable();
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('message')->nullable();
            $table->text('memo')->nullable();
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('subtotal', 17, 2)->default('0');
            $table->decimal('taxtotal', 17, 2)->default('0');
            $table->decimal('balance_due', 17, 2)->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('selected_sq_id')->nullable();
            $table->foreign('selected_sq_id')
                ->references('id')->on('sale_quotes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('selected_so_id')->nullable();
            $table->foreign('selected_so_id')
                ->references('id')->on('sale_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_delivery_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_delivery_id');
            $table->foreign('sale_delivery_id')
                ->references('id')->on('sale_deliveries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_order_item_id');
            $table->foreign('sale_order_item_id')
                ->references('id')->on('sale_order_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->double('qty', 20, 6);
            $table->double('qty_remaining', 20, 6);
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')
                ->references('id')->on('other_units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('unit_price', 17, 2)->default('0');
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amountsub', 17, 2)->default('0');
            $table->decimal('amounttax', 17, 2)->default('0');
            $table->decimal('amountgrand', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('transaction_date');
            $table->date('due_date');
            $table->unsignedBigInteger('term_id');
            $table->foreign('term_id')
                ->references('id')->on('other_terms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('transaction_no_sq')->nullable();
            $table->string('transaction_no_so')->nullable();
            $table->string('transaction_no_sd')->nullable();
            $table->string('transaction_no_spk')->nullable();
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('vendor_ref_no')->nullable();
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('is_marketting')->default('0')->nullable();
            $table->unsignedBigInteger('marketting')->nullable();
            $table->foreign('marketting')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('jasa_only')->default('0')->nullable();
            $table->text('message')->nullable();
            $table->text('memo')->nullable();
            $table->decimal('costtotal', 17, 2)->default('0');
            $table->decimal('subtotal', 17, 2)->default('0');
            $table->decimal('taxtotal', 17, 2)->default('0');
            $table->decimal('amount_paid', 17, 2)->default('0');
            $table->decimal('total_return', 17, 2)->default('0');
            $table->decimal('credit_memo', 17, 2)->default('0');
            $table->decimal('balance_due', 17, 2)->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('selected_sq_id')->nullable();
            $table->foreign('selected_sq_id')
                ->references('id')->on('sale_quotes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('selected_so_id')->nullable();
            $table->foreign('selected_so_id')
                ->references('id')->on('sale_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('selected_sd_id')->nullable();
            $table->foreign('selected_sd_id')
                ->references('id')->on('sale_deliveries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('selected_spk_id')->nullable();
            $table->foreign('selected_spk_id')
                ->references('id')->on('spks')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('witholding_coa_id')->nullable();
            $table->foreign('witholding_coa_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('witholding_amount_rp', 17, 2)->nullable();
            $table->decimal('witholding_amount_per', 5, 3)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_invoice_costs', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_invoice_id');
            $table->foreign('sale_invoice_id')
                ->references('id')->on('sale_invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('coa_id');
            $table->foreign('coa_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_invoice_id');
            $table->foreign('sale_invoice_id')
                ->references('id')->on('sale_invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_order_item_id')->nullable();
            $table->foreign('sale_order_item_id')
                ->references('id')->on('sale_order_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->double('qty', 20, 6);
            $table->double('qty_remaining', 20, 6)->nullable();
            $table->double('qty_remaining_return', 20, 6)->nullable();
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')
                ->references('id')->on('other_units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('unit_price', 17, 2)->default('0');
            $table->decimal('cost_unit_price', 17, 2)->default('0')->nullable();
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('cost_amount', 17, 2)->default('0');
            $table->decimal('amountsub', 17, 2)->default('0');
            $table->decimal('amounttax', 17, 2)->default('0');
            $table->decimal('amountgrand', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_payments', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_payment_method_id');
            $table->foreign('other_payment_method_id')
                ->references('id')->on('other_payment_methods')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->date('transaction_date');
            $table->date('due_date')->nullable();
            $table->unsignedBigInteger('transaction_no_si')->nullable();
            $table->foreign('transaction_no_si')
                ->references('id')->on('sale_invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('memo')->nullable();
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_payment_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_invoice_id');
            $table->foreign('sale_invoice_id')
                ->references('id')->on('sale_invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_payment_id');
            $table->foreign('sale_payment_id')
                ->references('id')->on('sale_payments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->decimal('payment_amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_returns', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('transaction_date');
            $table->date('due_date');
            $table->date('return_date');
            $table->string('transaction_no_si')->nullable();
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('message')->nullable();
            $table->text('memo')->nullable();
            $table->decimal('subtotal', 17, 2)->default('0');
            $table->decimal('taxtotal', 17, 2)->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('selected_si_id');
            $table->foreign('selected_si_id')
                ->references('id')->on('sale_invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sale_return_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_return_id');
            $table->foreign('sale_return_id')
                ->references('id')->on('sale_returns')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_invoice_item_id');
            $table->foreign('sale_invoice_item_id')
                ->references('id')->on('sale_invoice_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_order_id')->nullable();
            $table->foreign('sale_order_id')
                ->references('id')->on('sale_orders')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_order_item_id')->nullable();
            $table->foreign('sale_order_item_id')
                ->references('id')->on('sale_order_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('qty_invoice', 20, 6);
            $table->double('qty_remaining_invoice', 20, 6);
            $table->double('qty', 20, 6);
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')
                ->references('id')->on('other_units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('unit_price', 17, 2)->default('0');
            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')
                ->references('id')->on('other_taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('amountsub', 17, 2)->default('0');
            $table->decimal('amounttax', 17, 2)->default('0');
            $table->decimal('amountgrand', 17, 2)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });
        //*** END SALES
        Schema::create('closing_books', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('other_transaction_id');
            $table->foreign('other_transaction_id')
                ->references('id')->on('other_transactions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->string('number');
            $table->date('transaction_date');
            $table->date('start_period');
            $table->date('end_period');
            $table->unsignedBigInteger('retained_acc')->nullable();
            $table->foreign('retained_acc')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('retained_amt', 17, 2)->default('0');
            $table->text('memo')->nullable();
            $table->decimal('net_profit', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('closing_book_items', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('closing_book_id');
            $table->foreign('closing_book_id')
                ->references('id')->on('closing_books')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('coa_id');
            $table->foreign('coa_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->text('desc')->nullable();
            $table->decimal('debit', 17, 2)->default('0');
            $table->decimal('credit', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('opening_balances', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('opening_date');
            $table->string('status');
            $table->decimal('total_debit', 17, 2)->default('0');
            $table->decimal('total_credit', 17, 2)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('opening_balance_details', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('opening_balance_id');
            $table->foreign('opening_balance_id')
                ->references('id')->on('opening_balances')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('account_id');
            $table->foreign('account_id')
                ->references('id')->on('coas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('debit', 17, 2)->default('0')->nullable();
            $table->decimal('credit', 17, 2)->default('0')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        //*** START CONSTRUCTION
        Schema::create('offering_letter_cons', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->string('name');
            $table->string('date');
            $table->string('address')->nullable();
            $table->boolean('is_approved')->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('offering_letter_detail_cons', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('offering_letter_id');
            $table->foreign('offering_letter_id')
                ->references('id')->on('offering_letter_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->string('specification');
            $table->decimal('amount', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('budget_plan_cons', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('offering_letter_id');
            $table->foreign('offering_letter_id', 'ol_bp_id_foreign')
                ->references('id')->on('offering_letter_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->string('name');
            $table->text('address');
            $table->string('date');
            $table->boolean('is_approved')->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('budget_plan_detail_cons', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('budget_plan_id');
            $table->foreign('budget_plan_id')
                ->references('id')->on('budget_plan_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('offering_letter_detail_id');
            $table->foreign('offering_letter_detail_id', 'old_bp_id_foreign')
                ->references('id')->on('offering_letter_detail_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->integer('duration')->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->decimal('amountsub', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('bill_quantities_cons', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('budget_plan_id');
            $table->foreign('budget_plan_id')
                ->references('id')->on('budget_plan_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->string('address')->nullable();
            $table->string('name');
            $table->string('date');
            $table->boolean('is_approved')->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('bill_quantities_detail_cons', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('offering_letter_detail_id');
            $table->foreign('offering_letter_detail_id', 'old_bq_id_foreign')
                ->references('id')->on('offering_letter_detail_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('bill_quantities_id');
            $table->foreign('bill_quantities_id')
                ->references('id')->on('bill_quantities_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('budget_plan_detail_id');
            $table->foreign('budget_plan_detail_id')
                ->references('id')->on('budget_plan_detail_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')
                ->references('id')->on('other_units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->double('qty', 20, 6)->default('0');
            $table->decimal('amount', 17, 2)->default('0');
            $table->decimal('amounttotal', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('form_order_cons', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('bill_quantities_id');
            $table->foreign('bill_quantities_id')
                ->references('id')->on('bill_quantities_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->string('address')->nullable();
            $table->string('name');
            $table->string('date');
            $table->boolean('is_approved')->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('form_order_detail_cons', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('form_order_id');
            $table->foreign('form_order_id')
                ->references('id')->on('form_order_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('budget_plan_detail_id');
            $table->foreign('budget_plan_detail_id')
                ->references('id')->on('budget_plan_detail_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            //$table->boolean('is_late')->default('0');
            //$table->integer('progress_current_in_month');
            //$table->decimal('progress_current_in_percent', 5, 3)->default('0');
            //$table->integer('progress_lateness_in_month');
            //$table->decimal('progress_lateness_in_percent', 5, 3)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('progress_cons', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('form_order_id');
            $table->foreign('form_order_id')
                ->references('id')->on('form_order_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('bill_quantities_id');
            $table->foreign('bill_quantities_id')
                ->references('id')->on('bill_quantities_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('number');
            $table->string('address')->nullable();
            $table->string('name');
            $table->string('date');
            $table->boolean('is_approved')->default('0');
            $table->decimal('grandtotal', 17, 2)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('progress_detail_cons', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('progress_id');
            $table->foreign('progress_id')
                ->references('id')->on('progress_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('budget_plan_detail_id');
            $table->foreign('budget_plan_detail_id')
                ->references('id')->on('budget_plan_detail_cons')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('is_late')->default('0');
            //$table->integer('progress_current_in_month');
            $table->decimal('progress_current_in_percent', 5, 3)->default('0');
            $table->integer('progress_lateness_in_month');
            $table->decimal('progress_lateness_in_percent', 5, 3)->default('0');
            $table->unsignedBigInteger('status');
            $table->foreign('status')
                ->references('id')->on('other_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
        //*** END CONSTRUCTION
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('tenant_password_resets');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_password_resets');
        Schema::dropIfExists('company_settings');
        Schema::dropIfExists('logo_uploadeds');
        Schema::dropIfExists('company_logos');
        Schema::dropIfExists('coa_categories');
        Schema::dropIfExists('other_payment_methods');
        Schema::dropIfExists('other_product_categories');
        Schema::dropIfExists('other_statuses');
        Schema::dropIfExists('coas');
        Schema::dropIfExists('other_taxes');
        Schema::dropIfExists('other_units');
        Schema::dropIfExists('other_terms');
        Schema::dropIfExists('default_accounts');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('history_limit_balances');
        Schema::dropIfExists('other_transactions');
        Schema::dropIfExists('coa_details');
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_bundle_cost');
        Schema::dropIfExists('product_bundle_items');
        Schema::dropIfExists('product_discount_items');
        Schema::dropIfExists('product_production_items');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('warehouse_details');
        Schema::dropIfExists('warehouse_transfers');
        Schema::dropIfExists('warehouse_transfer_items');
        Schema::dropIfExists('spks');
        Schema::dropIfExists('spk_items');
        Schema::dropIfExists('stock_adjustments');
        Schema::dropIfExists('stock_adjustment_details');
        Schema::dropIfExists('wips');
        Schema::dropIfExists('wip_items');
        Schema::dropIfExists('journal_entries');
        Schema::dropIfExists('journal_entry_items');
        Schema::dropIfExists('assets');
        Schema::dropIfExists('asset_details');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('expense_items');
        Schema::dropIfExists('cashbanks');
        Schema::dropIfExists('cashbank_items');
        Schema::dropIfExists('purchase_quotes');
        Schema::dropIfExists('purchase_quote_items');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('purchase_order_items');
        Schema::dropIfExists('purchase_deliveries');
        Schema::dropIfExists('purchase_delivery_items');
        Schema::dropIfExists('purchase_invoices');
        Schema::dropIfExists('purchase_invoice_items');
        Schema::dropIfExists('purchase_invoice_pos');
        Schema::dropIfExists('purchase_invoice_po_items');
        Schema::dropIfExists('purchase_payments');
        Schema::dropIfExists('purchase_payment_items');
        Schema::dropIfExists('purchase_returns');
        Schema::dropIfExists('purchase_return_items');
        Schema::dropIfExists('sale_quotes');
        Schema::dropIfExists('sale_quote_items');
        Schema::dropIfExists('sale_orders');
        Schema::dropIfExists('sale_order_items');
        Schema::dropIfExists('sale_deliveries');
        Schema::dropIfExists('sale_delivery_items');
        Schema::dropIfExists('sale_invoices');
        Schema::dropIfExists('sale_invoice_items');
        Schema::dropIfExists('sale_payments');
        Schema::dropIfExists('sale_payment_items');
        Schema::dropIfExists('sale_returns');
        Schema::dropIfExists('sale_return_items');
        Schema::dropIfExists('offering_letter_cons');
        Schema::dropIfExists('offering_letter_detail_cons');
        Schema::dropIfExists('budget_plan_cons');
        Schema::dropIfExists('budget_plan_detail_cons');
        Schema::dropIfExists('bill_quantities_cons');
        Schema::dropIfExists('bill_quantities_detail_cons');
        Schema::dropIfExists('form_order_cons');
        Schema::dropIfExists('form_order_detail_cons');
        Schema::dropIfExists('progress_cons');
        Schema::dropIfExists('progress_detail_cons');
    }
}
