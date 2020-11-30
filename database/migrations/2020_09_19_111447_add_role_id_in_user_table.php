<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleIdInUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('role_id')->after('username')->default(0);
        });
        factory(App\User::class,1)
            ->create(
                [
                 'username' => 'Admin',
                 'first_name' => 'Admin' ,
                 'last_name' => 'Admin',
                 'role_id' => 1,
                 'email' => 'admin.xcoders@admin.com',
                ]
            );

            // Artisan::call('db:seed' ,[
            //     '--class' => AdminSeeder
            // ]);
    }

    /**
     * Reverse the migrations.
     *we
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');
        });
    }
}
