<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('mysql_smc')->create('dokter_pintu', function (Blueprint $table): void {
            $table->id();
            $table->string('kd_dokter');
            $table->string('kd_pintu');
        });
    }
};
