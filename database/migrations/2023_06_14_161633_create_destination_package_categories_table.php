<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destination_package_categories', function (Blueprint $table) {
            $table->id();
             $table->unsignedBiginteger('destinations_id')->unsigned();
            $table->unsignedBiginteger('package_categories_id')->unsigned();

            $table->foreign('destinations_id')->references('id')
                 ->on('destinations')->onDelete('cascade');
            $table->foreign('package_categories_id')->references('id')
                ->on('package_categories')->onDelete('cascade');
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
        Schema::dropIfExists('destination_package_categories');
    }
};
