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
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('rack_builder_racks')) {
            Schema::create('rack_builder_racks', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedSmallInteger('size')->default(42);
                $table->string('layout', 16)->default('standard');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('rack_builder_servers')) {
            Schema::create('rack_builder_servers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('rack_id')->constrained('rack_builder_racks')->cascadeOnDelete();
                $table->string('panel', 16)->default('main');
                $table->string('name');
                $table->unsignedTinyInteger('u_height')->default(1);
                $table->unsignedSmallInteger('u_position');
                $table->unsignedTinyInteger('num_nodes')->default(1);
                $table->text('description')->nullable();
                $table->string('color', 7)->nullable();
                $table->string('slot_position', 8)->default('full');
                $table->string('side', 8)->default('both');
                $table->timestamps();

                $table->index(['rack_id', 'panel', 'u_position']);
            });
        }

        if (! Schema::hasTable('rack_builder_nodes')) {
            Schema::create('rack_builder_nodes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('server_id')->constrained('rack_builder_servers')->cascadeOnDelete();
                $table->unsignedTinyInteger('node_number');
                $table->string('label');
                $table->unsignedInteger('device_id')->nullable()->index();
                $table->text('description')->nullable();
                $table->timestamps();

                $table->unique(['server_id', 'node_number']);
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
