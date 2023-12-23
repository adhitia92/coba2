<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporaninventaris', function (Blueprint $table) {
            $table->bigIncrements('idlaporaninventaris');
            $table->unsignedBigInteger('idkategori');
            $table->unsignedBigInteger('idbarang');
            $table->unsignedBigInteger('id')->nullable();
            $table->string('namateknisi');
            $table->string('asalteknisi');
            $table->enum('kondisiterbaru', ['baik','rusak'])->default('baik');
            $table->string('gambarterbaru')->nullable();
            $table->string('detail');


            $table->timestamps();
            $table->foreign('id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('idkategori')->references('idkategori')->on('kategori')->cascadeOnDelete();
            $table->foreign('idbarang')->references('idbarang')->on('barang')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporaninventaris');
    }
};
