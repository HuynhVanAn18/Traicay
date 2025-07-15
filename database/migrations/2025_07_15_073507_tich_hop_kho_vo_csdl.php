<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('product_id');
            $table->unsignedBigInteger('admin_id'); // who performed the transaction
            $table->integer('quantity');
            $table->string('type'); // e.g., 'import', 'export'
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('product_id')->on('tbl_product')->onDelete('cascade');
            $table->foreign('admin_id')->references('admin_id')->on('tbl_admin')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void 
     */
    public function down()
    {
        Schema::dropIfExists('stock_transactions');
    }
};
