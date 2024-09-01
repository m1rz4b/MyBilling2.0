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
        Schema::create('trn_clients_service_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('srv_id');
            $table->string('action_name');
            $table->string('p_value');
            $table->double('p_rate');
            $table->double('p_vat');
            $table->date('active_date');
            $table->string('c_value');
            $table->double('c_rate');
            $table->double('c_vat');
            $table->string('comments');
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
        Schema::dropIfExists('trn_clients_service_logs');
    }
};
