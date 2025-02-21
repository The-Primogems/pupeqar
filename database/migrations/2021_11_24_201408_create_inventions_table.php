p<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('inventions');
        Schema::create('inventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('college_id')->nullable();
            $table->foreignId('department_id')->nullable();
            $table->foreignId('classification')->nullable();
            $table->string('nature')->nullable();
            $table->string('title')->nullable();
            $table->string('collaborator')->nullable();
            $table->string('funding_agency')->nullable();
            $table->decimal('funding_amount', 15, 2)->nullable();
            $table->foreignId('funding_type')->nullable();
            $table->foreignId('status')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('utilization')->nullable();
            $table->string('copyright_number')->nullable();
            $table->date('issue_date')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventions')->nullable();
    }
}
