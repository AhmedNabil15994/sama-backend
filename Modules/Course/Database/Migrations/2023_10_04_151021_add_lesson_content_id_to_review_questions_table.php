<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('review_questions', function (Blueprint $table) {
            $table->bigInteger('lesson_content_id')->after('course_id')->unsigned()->index()->nullable();

            $table->foreign('lesson_content_id')->references('id')->on('lesson_contents')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('review_questions', function (Blueprint $table) {

        });
    }
};
