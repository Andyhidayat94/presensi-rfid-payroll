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
    Schema::create('salary_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('salary_id')->constrained()->onDelete('cascade');
        $table->string('keterangan');
        $table->decimal('jumlah', 15, 2);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_details');
    }
};
