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
    Schema::table('payrolls', function (Blueprint $table) {

        $table->integer('total_alpha')->default(0)->after('hari_hadir');
        $table->integer('total_cuti')->default(0)->after('total_alpha');

        $table->enum('tipe_gaji', ['harian','bulanan'])->after('tahun');

        $table->bigInteger('upah_harian')->default(0)->after('gaji_pokok');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payrolls', function (Blueprint $table) {
            //
        });
    }
};
