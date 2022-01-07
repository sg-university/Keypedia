
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     CREATE TABLE `user` (
  `id` decimal(19,0) NOT NULL,
  `role_id` decimal(19,0) NOT NULL,
  `username` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `name` text DEFAULT NULL,
  `gender_id` decimal(19,0) NOT NULL,
  `address` text DEFAULT NULL,
  `dob` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FKuser103719` (`gender_id`),
  KEY `FKuser994439` (`role_id`),
  CONSTRAINT `FKuser103719` FOREIGN KEY (`gender_id`) REFERENCES `gender` (`id`),
  CONSTRAINT `FKuser994439` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            // ["id", "decimal(19,0)", "NO", "PRI", null, ""]
            $table->id();
            // ["role_id", "decimal(19,0)", "NO", "MUL", null, ""]
            $table->foreignId('role_id');
            $table->foreign('role_id', 'fk_roleid_user_role')->references('id')->on('role')->onUpdate('cascade')->onDelete('cascade');

            // ["username", "text", "YES", "", null, ""]
            $table->text('username')->unique();
            // ["email", "text", "YES", "", null, ""]
            $table->text('email')->unique();
            // ["password", "text", "YES", "", null, ""]
            $table->text('password');
            // ["name", "text", "YES", "", null, ""]
            $table->text('name');
            // ["gender_id", "decimal(19,0)", "NO", "MUL", null, ""]
            $table->foreignId('gender_id');
            $table->foreign('gender_id', 'fk_genderid_user_gender')->references('id')->on('gender')->onUpdate('cascade')->onDelete('cascade');

            // ["address", "text", "YES", "", null, ""]
            $table->text('address');
            // ["dob", "timestamp", "YES", "", null, ""]
            $table->timestamp('dob')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('user');
    }
}
?>
