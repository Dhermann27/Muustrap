<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateBuildingsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create ( 'buildings', function (Blueprint $table) {
			$table->increments ( 'id' );
			$table->string ( 'name' );
		} );
        DB::update('ALTER TABLE buildings AUTO_INCREMENT = 1000');

        DB::unprepared('CREATE FUNCTION getbuildingid (buildingname VARCHAR(1024)) RETURNS INT DETERMINISTIC BEGIN
 			RETURN(SELECT b.id FROM buildings b WHERE b.name LIKE CONCAT(\'%\', buildingname, \'%\') LIMIT 1);
 		END');

	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::unprepared('DROP FUNCTION IF EXISTS getbuildingid' );
		Schema::dropIfExists ( 'buildings' );
	}
}
