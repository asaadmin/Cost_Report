<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostAndFormatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->id();
            $table->string('account_no');
            $table->string('description');
            $table->string('period_cost');
            $table->string('cost_to_date');
            $table->string('pos');
            $table->string('total_costs');
            $table->string('etc');
            $table->string('efc');
            $table->string('budget');
            $table->string('approved_overage');
            $table->string('total_budget');
            $table->string('over_under');
            $table->string('variance');
            $table->string('last_ctd');
            $table->string('last_efc');
            $table->string('sessionID');
            $table->timestamps();
        });
        Schema::create('formats', function (Blueprint $tableFormat) {
            $tableFormat->id();
            $tableFormat->string('sessionID');
            $tableFormat->integer('forder')->nullable();
            $tableFormat->string('account_no');
            $tableFormat->string('description');
            $tableFormat->integer('heading')->nullable();
            $tableFormat->integer('account')->nullable();
            $tableFormat->integer('category')->nullable();
            $tableFormat->string('production')->nullable();
            $tableFormat->string('grand_total')->nullable();
            $tableFormat->integer('line_type')->nullable();
            $tableFormat->integer('line_top')->nullable();
            $tableFormat->string('bold')->nullable();
            $tableFormat->integer('height_percent')->nullable();
            $tableFormat->timestamps();
        });
        Schema::create('settings', function (Blueprint $tableSettings) {
            $tableSettings->id();
            $tableSettings->string('type')->nullable();
            $tableSettings->integer('float_total')->nullable();
            $tableSettings->string('size')->nullable();
            $tableSettings->string('sessionID')->nullable();
            $tableSettings->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costs');
        Schema::dropIfExists('formats');
        Schema::dropIfExists('settings');
    }
}
