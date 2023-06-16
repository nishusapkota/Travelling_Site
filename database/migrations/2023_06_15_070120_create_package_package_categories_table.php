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
        Schema::create('package_package_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('packages_id');
            $table->foreign('packages_id')->references('id')->on('packages')->onDelete('cascade');
            $table->unsignedBigInteger('package_categories_id');
            $table->foreign('package_categories_id')->references('id')->on('package_categories')->onDelete('cascade');
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
        Schema::dropIfExists('package_package_categories');
    }
};
