<?php

namespace App\Database\Seeds;

use Faker\Factory;
use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        for ($i = 0; $i < 5; $i++) {
            $data = [
                'name'          => $faker->name(),
                'email'         => $faker->email(),
                'password'      => password_hash('password', PASSWORD_DEFAULT),
                'role'          => 'member',
                'is_active'     => true,
                'created_at'    => Time::createFromTimestamp($faker->unixTime()),
                'updated_at'    => Time::now()
            ];
            $this->db->table('users')->insert($data);
        }
    }
}
