<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSoftdeleteToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('work_statuses', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('languages', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('genres', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('artworks', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('images', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('chapters', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('buying_a_chapters', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('financial_operation_statuses', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('types_of_financial_operations', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('work_statuses', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('languages', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('genres', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('artworks', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('favorites', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('images', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('chapters', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('buying_a_chapters', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('financial_operation_statuses', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('types_of_financial_operations', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
