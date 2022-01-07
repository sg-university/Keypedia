
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenderTable extends Migration
{
    /**
     * Run the migrations.
     CREATE TABLE `gender` (
  `id` decimal(19,0) NOT NULL,
  `name` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
     * @return void
     */
    public function up()
    {
        Schema::create('gender', function (Blueprint $table) {
            // ["id", "decimal(19,0)", "NO", "PRI", null, ""]
            $table->id();
            // ["name", "text", "YES", "", null, ""]
            $table->text('name');
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
        Schema::dropIfExists('gender');
    }
}
?>
