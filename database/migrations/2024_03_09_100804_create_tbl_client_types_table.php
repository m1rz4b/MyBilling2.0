<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_client_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->string('unit', 50);
            $table->text('description')->nullable();
            $table->decimal('price', 11, 0);
            $table->integer('reseller_id');
            $table->double('share_rate');
            $table->double('share_percent')->nullable();
            $table->integer('hotspot');
            $table->integer('pcq');
            $table->integer('days');
            $table->integer('view_portal');
            $table->integer('view_distridutor')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('tbl_client_types');
    }
};
