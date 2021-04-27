<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->constrained()->cascadeOnDelete();
            $table->string('tenant');
            $table->bigInteger('amount');
            $table->boolean('is_deposit')->default(false);
            $table->date('month')->default(today('Africa/Nairobi'));
            $table->date('date_paid')->default(today('Africa/Nairobi'));
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
        Schema::dropIfExists('payments');
    }
}
