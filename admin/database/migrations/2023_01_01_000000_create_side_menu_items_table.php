<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSideMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_menu_items', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('type')->nullable();
            $table->text('icon')->nullable();
            $table->text('route')->nullable();
            $table->text('privilege')->nullable();
            $table->sortable();
            $table->status();
            // $table->schedule();
            $table->timestamps();
        });

        Schema::table('side_menu_items', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')
            ->on('side_menu_items')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('side_menu_tables');
    }
}
