<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_employees', function (Blueprint $table) {
            $table->id();
			$table->foreignId('branch_id')->index()->nullable();
			$table->foreignId('role_id')->index()->nullable();
			$table->foreignId('admin_id')->index()->nullable()->comment('branch_employee_id');
			$table->foreignId('department_id')->index()->nullable();
			$table->string('email')->nullable();
			$table->string('phone')->nullable();
			$table->text('address')->nullable();
			$table->string('national_id')->nullable();
			$table->string('image')->nullable();
			$table->string('driver')->default('local')->nullable();
			$table->boolean('status')->default(1);
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
        Schema::dropIfExists('branch_employees');
    }
}
