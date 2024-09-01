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
        Schema::create('nisl_mas_members', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->default('');
            $table->bigInteger('user_id')->nullable()->unique('User_ID');
            $table->string('password', 50)->default('');
            $table->integer('type')->default(0);
            $table->integer('suboffice_id');
            $table->integer('data_status')->nullable()->default(0);
            $table->integer('reseller_id');
            $table->integer('zone_office');
            $table->unique(['username'], 'username');
            $table->integer('status')->default(1);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nisl_mas_members');
    }
};
