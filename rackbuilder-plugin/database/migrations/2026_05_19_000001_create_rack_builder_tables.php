<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rack_builder_racks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('size')->default(42);
            $table->string('layout', 20)->default('standard');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('rack_builder_servers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rack_id');
            $table->string('panel', 20)->default('main');
            $table->string('name');
            $table->tinyInteger('u_height');
            $table->tinyInteger('u_position');
            $table->tinyInteger('num_nodes')->default(1);
            $table->text('description')->nullable();
            $table->string('color', 7)->nullable();
            $table->string('slot_position', 5)->default('full');
            $table->string('side', 5)->default('both');
            $table->timestamps();

            $table->foreign('rack_id')->references('id')->on('rack_builder_racks')->onDelete('cascade');
            $table->index('rack_id');
        });

        Schema::create('rack_builder_nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('server_id');
            $table->tinyInteger('node_number');
            $table->string('label');
            $table->unsignedInteger('device_id')->nullable()->index();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('server_id')->references('id')->on('rack_builder_servers')->onDelete('cascade');
            $table->index('server_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rack_builder_nodes');
        Schema::dropIfExists('rack_builder_servers');
        Schema::dropIfExists('rack_builder_racks');
    }
};
