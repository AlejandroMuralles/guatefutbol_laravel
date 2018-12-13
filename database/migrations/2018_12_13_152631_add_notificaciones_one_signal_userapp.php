<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotificacionesOneSignalUserapp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_app', function (Blueprint $table) {
            $table->tinyInteger('notificaciones')->default(0);
            $table->string('one_signal_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_app', function (Blueprint $table) {
            $table->dropColumn(['notificaciones','one_signal_id']);
        });
    }
}
