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
        Schema::create('tbl_company', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 150);
            $table->text('address');
            $table->string('phone', 50);
            $table->string('phone_emergency', 100);
            $table->string('fax', 100);
            $table->string('hst_no', 100);
            $table->text('email');
            $table->string('account_email', 100);
            $table->string('state', 11);
            $table->string('postal_code', 50);
            $table->string('city', 100);
            $table->string('country', 100);
            $table->string('admin_user', 150);
            $table->string('password', 150);
            $table->string('company_image', 150);
            $table->double('vat_per');
            $table->integer('comp_id');
            $table->integer('default_service');
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
        Schema::dropIfExists('tbl_company');
    }
};
