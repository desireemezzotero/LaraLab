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
        /* tabella polimorfica */
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('file_path'); /* percorso nel server  */
            $table->string('file_name'); /* nome originale per l'utente */

            $table->unsignedBigInteger('attachable_id');   /*  ID dell'oggetto come la pubblicazione o il progetto */
            $table->string('attachable_type');             /* la classe dell'oggetto */

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
