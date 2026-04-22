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
    Schema::table('salary_rules', function (Blueprint $table) {

        $table->enum('tipe_gaji', ['harian','bulanan'])
              ->after('department_id');

        $table->decimal('potongan_alpha', 15, 2)
              ->default(0)
              ->after('upah_harian');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salary_rules', function (Blueprint $table) {
            //
        });
    }
};
