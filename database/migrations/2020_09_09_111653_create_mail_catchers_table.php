<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailCatchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_catchers', function (Blueprint $table) {
            $table->id();
            $table->text('to')->nullable(false);
            $table->text('from')->nullable(false);
            $table->string('subject')->nullable(false);
            $table->string('content_type')->nullable(false);
            //$table->string('queue');
            //$table->string('delay');
            $table->text('body')->nullable(false);
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
        Schema::dropIfExists('mail_catchers');
    }
}
