<?php
use Illuminate\Database\Seeder;
class BuildingTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$buildings = [ 
				'Trout Lodge Guest Room',
				'Trout Lodge Loft Suite',
				'Lakeview Cabin',
				'Forestview Cabin',
				'Lakewood Cabin',
				'Lakewood YA Cabin',
				'Lakewood Sr High Cabin',
				'Lakewood Jr High Cabin',
				'Tent Camping',
				'Commuter (2 meals/day)',
				'Commuter (3 meals/day)'
		];
		array_map ( function ($name) {
			// $now = date('Y-m-d H:i:s', strtotime('now'));
			DB::table ( 'buildings' )->insert ( [ 
					'name' => $name 
			] );
		}, $buildings );
	}
}
