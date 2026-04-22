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
    Schema::create('salary_rules', function (Blueprint $table) {
        $table->id();

        $table->foreignId('position_id')->constrained()->cascadeOnDelete();
        $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();

        $table->decimal('gaji_pokok', 15, 2)->default(0);
        $table->decimal('upah_harian', 15, 2)->default(0);

        $table->enum('status', ['pending','approved','rejected'])->default('pending');

        $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
        $table->timestamp('approved_at')->nullable();

        $table->timestamps();

        $table->unique(['position_id','department_id']); // 🔥 penting
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_rules');
    }
};
