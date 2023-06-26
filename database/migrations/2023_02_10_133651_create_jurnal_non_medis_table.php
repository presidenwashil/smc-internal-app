<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The name of the database connection to use.
     *
     * @var ?string
     */
    protected $connection = 'mysql_smc';
    
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('mysql_smc')->create('jurnal_non_medis', function (Blueprint $table): void {
            $table->id();
            $table->string('no_jurnal', 20)->nullable();
            $table->timestamp('waktu_jurnal')->nullable();
            $table->string('no_faktur', 20)->nullable();
            $table->enum('status', ['Sudah', 'Batal'])->nullable();
            $table->text('ket')->nullable();
            $table->string('nik', 20)->nullable();

            $table->index(['no_jurnal', 'no_faktur', 'nik']);
        });
    }
};
