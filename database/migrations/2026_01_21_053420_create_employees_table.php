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
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('employee_code')->unique();
        $table->string('nama_lengkap');
        $table->string('nik')->unique();
        $table->date('tanggal_lahir')->nullable();
        $table->text('alamat')->nullable();
        $table->string('no_hp')->nullable();
        $table->string('jabatan');
        $table->date('tanggal_masuk');
        $table->enum('status_kerja', ['aktif', 'nonaktif'])->default('aktif');
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
        Schema::dropIfExists('employees');
    }
};
