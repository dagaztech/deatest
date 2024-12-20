<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('voting_type')->nullable();
            $table->text('multiple_answer_options')->nullable();
            $table->string('require_participants_names')->nullable();
            $table->string('voting_restrictions')->nullable();
            $table->string('set_end_date')->nullable();
            $table->string('hide_participants_from_each_other')->nullable();
            $table->dateTime('set_end_date_time')->nullable();
            $table->string('allow_comments')->nullable();
            $table->string('results_visibility')->nullable();
            $table->text('image_answer_options')->nullable();
            $table->string('image_require_participants_names')->nullable();
            $table->string('image_voting_restrictions')->nullable();
            $table->string('image_set_end_date')->nullable();
            $table->dateTime('image_set_end_date_time')->nullable();
            $table->string('image_allow_comments')->nullable();
            $table->string('image_hide_participants_from_each_other')->nullable();
            $table->string('image_results_visibility')->nullable();
            $table->text('meeting_answer_options')->nullable();
            $table->string('meeting_fixed_time_zone')->nullable();
            $table->string('meetings_fixed_time_zone')->nullable();
            $table->string('limit_selection_to_one_option_only')->nullable();
            $table->string('meeting_set_end_date')->nullable();
            $table->dateTime('meeting_set_end_date_time')->nullable();
            $table->string('meeting_allow_comments')->nullable();
            $table->string('meeting_hide_participants_from_each_other')->nullable();
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
        Schema::dropIfExists('polls');
    }
}
