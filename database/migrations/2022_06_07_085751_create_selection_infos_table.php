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
        Schema::create('selection_infos', function (Blueprint $table) {
            $table->id();
            $table->string('procedure_number')->comment('Registry number of the procedure');
            $table->string('lot_number')->unique()->comment('Lot registration number');
            $table->string('lot_subject')->nullable()->comment('Lot subject');
            $table->string('status_name')->nullable()->comment('Name of the step of the procurement procedure in the ASUZ');
            $table->string('step_name')->nullable()->comment('Name of the status of the procurement procedure in the ASUZ');
            $table->integer('proposals_number')->nullable()->comment('Number of proposals');

            $table->timestamp('started_at')->nullable()->comment('Date of starting application');
            $table->timestamp('ended_at')->nullable()->comment('Date of ending application');
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
        Schema::dropIfExists('selection_infos');
    }
};
