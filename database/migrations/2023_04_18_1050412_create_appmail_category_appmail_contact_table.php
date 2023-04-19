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
        //Attention la table doit etre écrit dans ce sens event_site et sans les s

        Schema::create('appmail_category_appmail_contact', function (Blueprint $table) {
            $table->id();

            // Attention pas de s à site_id
            $table->bigInteger('appmail_contact_id')->unsigned()->nullable();
            $table->foreign('appmail_contact_id')
                ->references('id')
                ->on('appmail_contact');

            // Attention pas de s à event_id        
            $table->bigInteger('appmail_category_id')->unsigned()->nullable();
            $table->foreign('appmail_category_id')
                ->references('id')
                ->on('appmail_category');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appmail_contacts_categories');
    }
};
