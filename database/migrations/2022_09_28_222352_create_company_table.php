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
        Schema::create('company_symbols', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('financial_status');
            $table->string('market_category');
            $table->string('round_lot_size');
            $table->string('security_name');
            $table->string('symbol');
            $table->string('test_issue');
            $table->timestamps();
            $table->index(['id', 'symbol']);
        });

        Artisan::call('db:seed', [
            '--class' => 'SeedCompanySymbol',
            '--force' => true,
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_symbols');
    }
};
