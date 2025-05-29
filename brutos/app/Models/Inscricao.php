<?php



protected $fillable = ['foto', 'intencao', 'sobre'];


public function up()
{
    Schema::create('inscricaos', function (Blueprint $table) {
        $table->id();
        $table->string('foto');
        $table->string('intencao');
        $table->text('sobre');
        $table->timestamps();
    });
}


?>