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
    Schema::table('employees', function (Blueprint $table) {
        $table->enum('jenis_kelamin', ['L', 'P'])->after('nama_lengkap');
        $table->string('tempat_lahir')->after('jenis_kelamin');
        $table->string('pendidikan_terakhir')->after('no_hp');
    });
}

public function down()
{
    Schema::table('employees', function (Blueprint $table) {
        $table->dropColumn([
            'jenis_kelamin',
            'tempat_lahir',
            'pendidikan_terakhir',
        ]);
    });
}
};
