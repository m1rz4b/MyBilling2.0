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
        Schema::create('hrm_tbl_emploan', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->date('sanction_date');
            $table->date('start_date');
            $table->double('amnt');
            $table->double('interest');
            $table->integer('no_of_installment');
            $table->double('emi');
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
        Schema::dropIfExists('hrm_tbl_emploan');
    }
};
