<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            //testo
            $table->longText('text');

            //tipo -> A & B
            $table->enum('tipes', ['A', 'B']);

            //url
            $table->text('url');

            //data_inizio
            $table->date('start_time');

            //data_fine
            $table->date('end_time');
            //note
            $table->text('note');
            //attivo -> boolean
            $table->boolean('active');

            $table->foreignId('user_id')->constrained()->onDelete("cascade");

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
        Schema::dropIfExists('messages');
    }
}
