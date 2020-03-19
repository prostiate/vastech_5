<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableFifo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('product_fifo_ins', function (Blueprint $table) {
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
            $table->unsignedBigInteger('purchase_invoice_item_id')->nullable();
            $table->foreign('purchase_invoice_item_id')
                ->references('id')->on('purchase_invoice_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('warehouse_transfer_item_id')->nullable();
            $table->foreign('warehouse_transfer_item_id')
                ->references('id')->on('warehouse_transfer_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('stock_adjustment_detail_id')->nullable();
            $table->foreign('stock_adjustment_detail_id')
                ->references('id')->on('stock_adjustments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('wip_item_id')->nullable();
            $table->foreign('wip_item_id')
                ->references('id')->on('wip_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('type')->nullable();
            $table->string('number')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->float('qty', 20, 6)->default('0');
            $table->decimal('unit_price', 17, 2);
            $table->decimal('total_price', 17, 2);
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_fifo_outs', function (Blueprint $table) {
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
            $table->unsignedBigInteger('sale_invoice_item_id')->nullable();
            $table->foreign('sale_invoice_item_id')
                ->references('id')->on('sale_invoice_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('warehouse_transfer_item_id')->nullable();
            $table->foreign('warehouse_transfer_item_id')
                ->references('id')->on('warehouse_transfer_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('stock_adjustment_detail_id')->nullable();
            $table->foreign('stock_adjustment_detail_id')
                ->references('id')->on('stock_adjustments')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('wip_item_id')->nullable();
            $table->foreign('wip_item_id')
                ->references('id')->on('wip_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('type')->nullable();
            $table->string('number')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id')
                ->references('id')->on('warehouses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->float('qty', 20, 6)->default('0');
            $table->decimal('unit_price', 17, 2);
            $table->decimal('total_price', 17, 2);
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
        });

        /*Schema::create('product_fifo_in_fk_pds', function (Blueprint $table) {
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
            $table->unsignedBigInteger('product_fifo_in_id');
            $table->foreign('product_fifo_in_id')
                ->references('id')->on('product_fifo_ins')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_delivery_id');
            $table->foreign('purchase_delivery_id')
                ->references('id')->on('purchase_deliveries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_fifo_in_fk_pis', function (Blueprint $table) {
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
            $table->unsignedBigInteger('product_fifo_in_id');
            $table->foreign('product_fifo_in_id')
                ->references('id')->on('product_fifo_ins')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('purchase_invoice_id');
            $table->foreign('purchase_invoice_id')
                ->references('id')->on('purchase_invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_fifo_in_fk_wips', function (Blueprint $table) {
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
            $table->unsignedBigInteger('product_fifo_in_id');
            $table->foreign('product_fifo_in_id')
                ->references('id')->on('product_fifo_ins')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('wip_id');
            $table->foreign('wip_id')
                ->references('id')->on('wips')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_fifo_out_fk_sds', function (Blueprint $table) {
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
            $table->unsignedBigInteger('product_fifo_out_id');
            $table->foreign('product_fifo_out_id')
                ->references('id')->on('product_fifo_outs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_delivery_id');
            $table->foreign('sale_delivery_id')
                ->references('id')->on('sale_deliveries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_fifo_out_fk_sis', function (Blueprint $table) {
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
            $table->unsignedBigInteger('product_fifo_out_id');
            $table->foreign('product_fifo_out_id')
                ->references('id')->on('product_fifo_outs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('sale_invoice_id');
            $table->foreign('sale_invoice_id')
                ->references('id')->on('sale_invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_fifo_out_fk_wips', function (Blueprint $table) {
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
            $table->unsignedBigInteger('product_fifo_out_id');
            $table->foreign('product_fifo_out_id')
                ->references('id')->on('product_fifo_outs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('wip_id');
            $table->foreign('wip_id')
                ->references('id')->on('wips')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_fifo_ins');
        Schema::dropIfExists('product_fifo_outs');
        /*Schema::dropIfExists('product_fifo_in_fk_pds');
        Schema::dropIfExists('product_fifo_in_fk_pis');
        Schema::dropIfExists('product_fifo_in_fk_wips');
        Schema::dropIfExists('product_fifo_out_fk_sds');
        Schema::dropIfExists('product_fifo_out_fk_sis');
        Schema::dropIfExists('product_fifo_out_fk_wips');*/
    }
}
