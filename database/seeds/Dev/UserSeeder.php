<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    protected $key = 'email';
    protected $Users = [];

    public function __construct()
    {
        $this->Users = collect([
        ])->keyBy($this->key);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Exists = DB::table('users')
            ->whereIn($this->key, $this->Users
            ->pluck($this->key)->all())
            ->get()->keyBy($this->key);

        $New = $this->Users->diffKeys($Exists->toArray())->values();
        DB::table('users')->insert($New->all());
    }
}
