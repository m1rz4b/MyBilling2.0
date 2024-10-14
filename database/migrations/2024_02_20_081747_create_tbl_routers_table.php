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
        Schema::create('tbl_routers', function (Blueprint $table) {
            $table->id();
            $table->string('router_name', 150);
            $table->string('router_ip', 100);
            $table->string('router_username', 150);
            $table->string('router_password', 150);
            $table->string('router_location', 250);
            $table->integer('port');
            $table->string('web_server_port', 50)->nullable();
            $table->string('wefig_username', 100)->nullable();
            $table->string('wefig_pass', 100)->nullable();
            $table->string('r_secret', 100);
            $table->string('ssh_port', 50);
            $table->integer('active_client')->nullable();
            $table->integer('radius_auth');
            $table->integer('radius_acct');
            $table->string('local_address', 50);
            $table->string('lan_interface', 100);
            $table->text('dns1');
            $table->text('dns2');
            $table->string('active', 6)->nullable();
            $table->string('router_type', 2)->nullable();
            $table->string('suboffice_id')->nullable();
            $table->string('radius_server_id')->nullable();

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
        Schema::dropIfExists('tbl_routers');
    }
};
