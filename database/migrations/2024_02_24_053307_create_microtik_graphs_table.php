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
        Schema::create('tbl_mikrotik_graphing', function (Blueprint $table) {
            $table->id();

            $table->integer('router_id');
            $table->string('interface', 150);
            $table->string('allow_address', 100);
            $table->string('store_on', 20);
            $table->unique(['router_id', 'interface'], 'router_id');

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
        Schema::dropIfExists('tbl_mikrotik_graphing');
    }
};
