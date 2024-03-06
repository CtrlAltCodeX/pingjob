<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('employer_id')->nullable();
			$table->string('title');
			$table->string('first_name');
			$table->string('middle_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('department')->nullable();
			$table->integer('primary_phone')->nullable();
			$table->integer('cell_phone')->nullable();
			$table->string('email')->nullable();
			$table->string('details')->nullable();
			$table->integer('approve_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
