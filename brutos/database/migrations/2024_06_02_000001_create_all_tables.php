<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'tinder2'; 

    public function up(): void
    {
        Schema::create('tipo_intencao', function (Blueprint $table) {
            $table->id('id_tipo_intencao');
            $table->string('no_tipo_intencao')->nullable();
        });

        Schema::create('status_usuario', function (Blueprint $table) {
            $table->id('id_status_usuario');
            $table->string('no_status_usuario')->nullable();
        });

        Schema::create('motivo_recusa', function (Blueprint $table) {
            $table->id('id_motivo_recusa');
            $table->string('legenda')->nullable();
            $table->string('no_motivo_recusa')->nullable();
        });

        Schema::create('tipo_interacao', function (Blueprint $table) {
            $table->id('id_tipo_interacao');
            $table->string('no_tipo_interacao');
        });

        Schema::create('usuario', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->integer('idade')->nullable();
            $table->string('nome')->nullable();
            $table->text('de_observacao_recusa')->nullable();
            $table->string('de_sobre')->nullable();
            $table->timestamp('dh_criacao')->useCurrent();
            $table->integer('matricula_recusa')->nullable();
            $table->timestamp('dh_alteracao')->useCurrent()->useCurrentOnUpdate();
            $table->integer('matricula');

            $table->unsignedBigInteger('id_tipo_intencao');
            $table->unsignedBigInteger('id_status_usuario');
            $table->unsignedBigInteger('id_motivo_recusa')->nullable();

            $table->foreign('id_tipo_intencao')->references('id_tipo_intencao')->on('tipo_intencao')->onDelete('cascade');
            $table->foreign('id_status_usuario')->references('id_status_usuario')->on('status_usuario')->onDelete('cascade');
            $table->foreign('id_motivo_recusa')->references('id_motivo_recusa')->on('motivo_recusa')->onDelete('cascade');
        });

        Schema::create('interacao', function (Blueprint $table) {
            $table->id('id_interacao');
            $table->integer('matricula_origem');
            $table->timestamp('dh_criacao')->useCurrent();
            $table->integer('matricula_destino');
            $table->unsignedBigInteger('id_tipo_interacao')->nullable();
            $table->foreign('id_tipo_interacao')->references('id_tipo_interacao')->on('tipo_interacao')->onDelete('cascade');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('password', 255);
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('email', 255);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 255);
            $table->integer('last_activity');
            $table->text('payload');
            $table->integer('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id', 255);
            $table->string('name', 255);
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->text('failed_job_ids');
            $table->text('options')->nullable();
            $table->integer('created_at');
            $table->integer('cancelled_at')->nullable();
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->text('exception');
            $table->text('connection');
            $table->timestamp('failed_at')->useCurrent();
            $table->text('queue');
            $table->string('uuid', 255);
            $table->text('payload');
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue', 255);
            $table->integer('reserved_at')->nullable();
            $table->integer('available_at');
            $table->string('attempts'); // tipo: smallint
            $table->integer('created_at');
            $table->text('payload');
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->id();
            $table->string('key', 255);
            $table->text('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->id();
            $table->string('key', 255);
            $table->string('owner', 255);
            $table->integer('expiration');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('email', 255);
            $table->string('token', 255);
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('usuario');
        Schema::dropIfExists('status_usuario');
        Schema::dropIfExists('users');
        Schema::dropIfExists('interacao');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('tipo_interacao');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('tipo_intencao');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('motivo_recusa');
        Schema::dropIfExists('password_reset_tokens');
    }
};
