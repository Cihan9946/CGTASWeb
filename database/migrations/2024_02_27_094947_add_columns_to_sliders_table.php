<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSlidersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('maintitle')->nullable();
            $table->string('maindescription')->nullable();
            $table->string('link')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn('maintitle');
            $table->dropColumn('maindescription');
            $table->dropColumn('link');
            $table->dropColumn('title');
            $table->dropColumn('description');
        });
    }
}
