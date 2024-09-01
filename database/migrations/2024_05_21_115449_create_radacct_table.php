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
        Schema::create('radacct', function (Blueprint $table) {
            $table->id();
            $table->string('acctsessionid', 64)->default('')->index('acctsessionid');
            $table->string('acctuniqueid', 32)->default('')->unique('acctuniqueid');
            $table->string('username', 64)->default('')->index('username');
            $table->string('groupname', 64)->default('');
            $table->string('realm', 64)->nullable()->default('');
            $table->string('nasipaddress', 15)->default('')->index('nasipaddress');
            $table->string('nasportid', 60)->nullable();
            $table->string('nasporttype', 32)->nullable();
            $table->dateTime('acctstarttime')->nullable()->index('acctstarttime');
            $table->dateTime('acctupdatetime')->nullable();
            $table->dateTime('acctstoptime')->nullable()->index('acctstoptime');
            $table->integer('acctinterval')->nullable()->index('acctinterval');
            $table->unsignedInteger('acctsessiontime')->nullable()->index('acctsessiontime');
            $table->string('acctauthentic', 32)->nullable();
            $table->string('connectinfo_start', 50)->nullable();
            $table->string('connectinfo_stop', 50)->nullable();
            $table->bigInteger('acctinputoctets')->nullable();
            $table->bigInteger('acctoutputoctets')->nullable();
            $table->string('calledstationid', 100)->default('');
            $table->string('callingstationid', 50)->default('');
            $table->string('acctterminatecause', 32)->default('');
            $table->string('servicetype', 32)->nullable();
            $table->string('framedprotocol', 32)->nullable();
            $table->string('framedipaddress', 15)->default('')->index('framedipaddress');
            // Use `unsigned()` instead of `integer()` to avoid auto_increment
            $table->unsignedInteger('acctstartdelay')->nullable();
            $table->unsignedInteger('acctstopdelay')->nullable();
            $table->string('xascendsessionsvrkey', 10);
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
        Schema::dropIfExists('radacct');
    }
};
