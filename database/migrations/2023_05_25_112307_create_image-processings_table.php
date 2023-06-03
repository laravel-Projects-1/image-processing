<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageProcessingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image-processing', function (Blueprint $table) {
            $table->id();
            $table->string('path',2000);
            $table->string('name',255);
            $table->string('type',25);
            $table->text('data',2000)->nullable();
            $table->string('output_path')->nullable();
            $table->foreignIdFor(\App\Models\User::class,'user_id')->nullable();
            $table->foreignIdFor(\App\Models\album::class,'album_id')->nullable();
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
        Schema::dropIfExists('image-processing');
    }
}
