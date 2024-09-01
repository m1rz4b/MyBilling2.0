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
        Schema::create('tbl_crm_email_setup', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('port', 100);
            $table->string('Username', 100);
            $table->string('Password', 100);
            $table->string('setFrom', 100);
            $table->string('SMTPAuth', 30);
            $table->string('Host', 100);
            $table->string('SMTPSecure', 30);
            $table->text('addReplyTo');
            $table->text('addCC');
            $table->text('addBCC');
            $table->string('isHTML', 30);
            $table->string('Mailer', 100);
            $table->integer('send_email');
            $table->integer('receive_email');
            $table->integer('department');
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
        Schema::dropIfExists('tbl_crm_email_setup');
    }
};
