<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThisIsHowIRolePackageRolesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('tihir_roles')) {
            return;
        }

        Schema::create('tihir_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('class_name');
            $table->bigInteger('foreign_id');
            $table->text('roles');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tihir_roles');
    }
}
