
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyboardTable extends Migration
{
    /**
     * Run the migrations.
     CREATE TABLE `keyboard` (
  `id` decimal(19,0) NOT NULL,
  `name` text DEFAULT NULL,
  `category_id` decimal(19,0) NOT NULL,
  `price` decimal(19,0) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_id` decimal(19,0) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FKkeyboard36648` (`category_id`),
  CONSTRAINT `FKkeyboard36648` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
     * @return void
     */
    public function up()
    {
        Schema::create('keyboard', function (Blueprint $table) {
            // ["id", "decimal(19,0)", "NO", "PRI", null, ""]
            $table->id();
            // ["name", "text", "YES", "", null, ""]
            $table->text('name');
            // ["category_id", "decimal(19,0)", "NO", "MUL", null, ""]
            $table->foreignId('category_id');
            $table->foreign('category_id', 'fk_categoryid_keyboard_category')->references('id')->on('category')->onUpdate('cascade')->onDelete('cascade');

            // ["price", "decimal(19,0)", "YES", "", null, ""]
            $table->decimal('price', 19, 0);
            // ["description", "text", "YES", "", null, ""]
            $table->text('description');
            // ["image_id", "decimal(19,0)", "YES", "", null, ""]
            $table->decimal('image_id', 19, 0);
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
        Schema::dropIfExists('keyboard');
    }
}
?>
