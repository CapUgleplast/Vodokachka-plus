<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Показания счётчика водокачки
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('period_id')->unique();     // Ссылка на период (уникальна, на 1 период должна быть 1 запись счетчика)
            $table->float('price_per_cubic_meter');             // Тариф за кубометр воды

            $table->foreign('period_id')                // Внешний ключ: нельзя удалять период
                  ->references('id')->on('periods');    // по которому уже внесены данные счетчика
        // Если при вводе показаний счетчика, в таблице periods нет записи на соответствующий месяц, то надо её создать
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tariffs');
    }
}
