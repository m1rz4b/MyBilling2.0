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
        Schema::create('tbl_servercommands', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('command');
            $table->integer('status');
            $table->dateTime('last_restart');
            $table->integer('fail_status');
            $table->text('comments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_servercommands');
    }
};
