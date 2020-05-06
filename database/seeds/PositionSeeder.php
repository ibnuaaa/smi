<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    protected $key = 'name';
    protected $Positions = [];

    public function __construct()
    {
        $this->Positions = collect([
            [
                'name' => 'Admin',
                'created_at' => Carbon::now()
            ]
        ])->keyBy($this->key);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Exists = DB::table('positions')
            ->whereIn($this->key, $this->Positions
            ->pluck($this->key)->all())
            ->get()->keyBy($this->key);

        $New = $this->Positions->diffKeys($Exists->toArray())->values();
        DB::table('positions')->insert($New->all());

    }
}
