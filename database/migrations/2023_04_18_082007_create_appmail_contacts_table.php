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
        Schema::create('appmail_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('appmail_contact_email');
            $table->string('appmail_contact_firstname');
            $table->string('appmail_contact_lastname');
            $table->string('appmail_contact_business');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appmail_contacts');
    }
};
