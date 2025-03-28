<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTdataEnqueteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdata_enquete', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_violation')->constrained('tdata_violation')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_ethni')->constrained('tdata_ethni')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_genre')->constrained('tdata_genre')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('id_auteur')->constrained('tdata_auteur')->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('refAgent')->constrained('tagent')->restrictOnUpdate()->restrictOnDelete();
            $table->string('author')->nullable();            
            $table->foreignId('refUser')->constrained('users')->restrictOnUpdate()->restrictOnDelete()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tdata_enquete');
    }
}
