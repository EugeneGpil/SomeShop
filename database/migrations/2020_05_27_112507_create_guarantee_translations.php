<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuaranteeTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guarantee_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guarantee_id');
            $table->string('locale');
            $table->string('attribute');
            $table->string('value');
            $table->timestamps();
        });

        Schema::table('guarantee_translations', function (Blueprint $table) {
            $table->foreign('guarantee_id')
                ->references('id')
                ->on('guarantees')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guarantee_translations');
    }
}
