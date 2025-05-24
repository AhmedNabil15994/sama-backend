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
        Schema::table('user_videos', function (Blueprint $table) {
            $table->decimal('percent', 2,2)->after('totalPlayed')->default(0);
            $table->decimal('video_duration', 4,4)->after('percent')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_videos', function (Blueprint $table) {

        });
    }
};
