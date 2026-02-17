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
    Schema::create('salaries', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained()->onDelete('cascade');
        $table->integer('bulan');   // 1 - 12
        $table->integer('tahun');
        $table->decimal('gaji_pokok', 15, 2);
        $table->decimal('potongan', 15, 2)->default(0);
        $table->decimal('total_gaji', 15, 2);
        $table->enum('status_approval', ['pending', 'disetujui', 'ditolak'])->default('pending');
        $table->foreignId('approved_by')->nullable()->constrained('users');
        $table->timestamp('approved_at')->nullable();
        $table->timestamps();

        $table->unique(['employee_id', 'bulan', 'tahun']);
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
};
