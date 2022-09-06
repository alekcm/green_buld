<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_id')->nullable()->comment('Parent page ID');

            $table->unsignedInteger('_lft');
            $table->unsignedInteger('_rgt');
            $table->text('path')->comment('Page path');
            $table->json('breadcrumbs')->comment('Breadcrumbs array');

            $table->string('title', 255)->unique()->comment('Page title');
            $table->string('slug', 255)->unique()->comment('Page title slug');
            $table->boolean('show_main')->comment('Is shown on homepage?');
            $table->unsignedInteger('order')->comment('Order of page');
            $table->string('icon')->nullable()->comment('Icon image path');

            $table->longText('content')->nullable()->comment('Content of the page');
            $table->json('content_table')->nullable()->comment('Table of content');

            $table->json('available')->comment('Available to users roles');

            $table->timestamps();

            $table->foreign('parent_id')->on('pages')->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
        Schema::dropIfExists('pages');
    }
};
