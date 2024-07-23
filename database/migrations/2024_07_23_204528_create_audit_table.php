<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditTable extends Migration
{
    public function up()
    {
            Schema::create('audits', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('ip_management_id');
                $table->unsignedBigInteger('user_id');
                $table->string('action');
                $table->string('label')->nullable(); // Add this line
                $table->timestamp('created_at')->useCurrent();

                $table->foreign('ip_management_id')->references('id')->on('ip_management')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });

    }

    public function down()
    {
        Schema::dropIfExists('audits');
    }
}
