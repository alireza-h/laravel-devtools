<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('type');
            $table->string('message');
            $table->integer('count');
            $table->longText('preview');
            $table->timestamps();
        });

        Schema::table('error_logs', function (Blueprint $table) {
            $table->unique('key');
            $table->index(['key', 'type'], 'error_logs_key_type_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('error_logs');
    }
}
