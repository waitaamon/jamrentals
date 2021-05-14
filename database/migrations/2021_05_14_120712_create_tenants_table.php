<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('id_number')->nullable();
            $table->string('phone')->nullable();
            $table->bigInteger('deposit')->nullable();
            $table->bigInteger('incurred_cost')->nullable();
            $table->bigInteger('balance')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
    }
}
