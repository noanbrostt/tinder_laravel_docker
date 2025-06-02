<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('name', 255);
            $table->integer('finished_at')->nullable();
            $table->integer('failed_jobs');
            $table->text('failed_job_ids');
            $table->integer('cancelled_at')->nullable();
            $table->text('options')->nullable();
            $table->integer('created_at');
            $table->integer('total_jobs');
            $table->string('id', 255);
            $table->integer('pending_jobs');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('id', 255);
            $table->integer('last_activity');
            $table->text('payload');
            $table->integer('user_id')->nullable();
        });

        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->integer('idade')->nullable();
            $table->integer('id_usuario')->default(nextval('usuario_id_usuario_seq'));
            $table->string('nome')->nullable();
            $table->text('de_observacao_recusa')->nullable();
            $table->integer('id_status_usuario')->nullable();
            $table->integer('id_motivo_recusa')->nullable();
            $table->integer('id_tipo_intencao')->nullable();
            $table->string('de_sobre')->nullable();
            $table->timestamp('dh_criacao')->nullable()->default(CURRENT_TIMESTAMP);
            $table->integer('matricula_recusa')->nullable();
            $table->timestamp('dh_alteracao')->nullable();
            $table->integer('matricula');
            $table->foreignId('id_tipo_intencao')->constrained('tipo_intencao')->references('id_tipo_intencao')->onDelete('cascade');
            $table->foreignId('id_status_usuario')->constrained('status_usuario')->references('id_status_usuario')->onDelete('cascade');
            $table->foreignId('id_motivo_recusa')->constrained('motivo_recusa')->references('id_motivo_recusa')->onDelete('cascade');
        });

        Schema::create('migrations', function (Blueprint $table) {
            $table->integer('id')->default(nextval('migrations_id_seq'));
            $table->integer('batch');
            $table->string('migration', 255);
        });

        Schema::create('status_usuario', function (Blueprint $table) {
            $table->id();
            $table->integer('id_status_usuario')->default(nextval('status_usuario_id_status_usuario_seq'));
            $table->string('no_status_usuario')->nullable();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->string('name', 255);
            $table->string('password', 255);
            $table->string('remember_token', 100)->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('email', 255);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('id')->default(nextval('users_id_seq'));
        });

        Schema::create('interacao', function (Blueprint $table) {
            $table->id();
            $table->integer('matricula_origem');
            $table->timestamp('dh_criacao')->nullable()->default(CURRENT_TIMESTAMP);
            $table->integer('matricula_destino');
            $table->integer('id_tipo_interacao')->nullable();
            $table->integer('id_interacao')->default(nextval('interacao_id_interacao_seq'));
            $table->foreignId('id_tipo_interacao')->constrained('tipo_interacao')->references('id_tipo_interacao')->onDelete('cascade');
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->text('exception');
            $table->text('connection');
            $table->timestamp('failed_at')->default(CURRENT_TIMESTAMP);
            $table->text('queue');
            $table->integer('id')->default(nextval('failed_jobs_id_seq'));
            $table->string('uuid', 255);
            $table->text('payload');
        });

        Schema::create('tipo_interacao', function (Blueprint $table) {
            $table->id();
            $table->string('no_tipo_interacao');
            $table->integer('id_tipo_interacao')->default(nextval('tipo_interacao_id_tipo_interacao_seq'));
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->string('queue', 255);
            $table->integer('reserved_at')->nullable();
            $table->integer('available_at');
            $table->integer('id')->default(nextval('jobs_id_seq'));
            $table->string('attempts') /* tipo: smallint */;
            $table->integer('created_at');
            $table->text('payload');
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->id();
            $table->text('value');
            $table->string('key', 255);
            $table->integer('expiration');
        });

        Schema::create('tipo_intencao', function (Blueprint $table) {
            $table->id();
            $table->string('no_tipo_intencao')->nullable();
            $table->integer('id_tipo_intencao')->default(nextval('tipo_intencao_id_tipo_intencao_seq'));
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->id();
            $table->integer('expiration');
            $table->string('key', 255);
            $table->string('owner', 255);
        });

        Schema::create('motivo_recusa', function (Blueprint $table) {
            $table->id();
            $table->string('legenda')->nullable();
            $table->integer('id_motivo_recusa')->default(nextval('motivo_recusa_id_motivo_recusa_seq'));
            $table->string('no_motivo_recusa')->nullable();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token', 255);
            $table->timestamp('created_at')->nullable();
            $table->string('email', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('usuario');
        Schema::dropIfExists('migrations');
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