<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    protected $key = 'email';
    protected $Users = [];

    public function __construct()
    {
        $this->Users = collect([
            [
                'name' => 'Root',
                'username' => 'root',
                'gender' => 'male',
                'position_id' => 1,
                'email' => 'root@main.com',
                'password' => Hash::make('Asdasd123!!'),
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
        $Exists = DB::table('users')
            ->whereIn($this->key, $this->Users
            ->pluck($this->key)->all())
            ->get()->keyBy($this->key);

        $New = $this->Users->diffKeys($Exists->toArray())->values();
        DB::table('users')->insert($New->all());

    }
}
