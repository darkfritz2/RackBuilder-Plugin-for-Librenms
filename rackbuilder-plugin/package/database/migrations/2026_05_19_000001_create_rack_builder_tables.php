<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Creates the RackBuilder tables.
 *
 * Loaded by LocalPlugins\RackBuilder\RoutesServiceProvider, so `lnms migrate` (which daily.sh
 * runs on every update) picks it up automatically. Each table is only created if it doesn't
 * exist yet, so installs that already have the tables are left untouched.
 *
 * The schema is identical to the original RackBuilder migration of the same name, which older
 * installs placed in LibreNMS's database/migrations folder. Because the file name matches,
 * Laravel treats it as already run on those installs.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('rack_builder_racks')) {
            Schema::create('rack_builder_racks', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->tinyInteger('size')->default(42);
                $table->string('layout', 20)->default('standard');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('rack_builder_servers')) {
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
        }

        if (! Schema::hasTable('rack_builder_nodes')) {
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
    }

    public function down(): void
    {
        Schema::dropIfExists('rack_builder_nodes');
        Schema::dropIfExists('rack_builder_servers');
        Schema::dropIfExists('rack_builder_racks');
    }
};
