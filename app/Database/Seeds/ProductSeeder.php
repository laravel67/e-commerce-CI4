<?php

namespace App\Database\Seeds;

use Faker\Factory;
use CodeIgniter\I18n\Time;
use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        for ($i = 0; $i < 20; $i++) {
            $data = [
                'name'          => $faker->word(2, true),
                'slug'          => $faker->slug(2, true),
                'category_id'   => $faker->numberBetween(1, 5),
                'description'   => $faker->paragraph(3),
                'price'         => $faker->randomNumber(8),
                'stocks'        => $faker->numberBetween(1, 100),
                'image'         => null,
                'created_at'    => Time::createFromTimestamp($faker->unixTime()),
                'updated_at'    => Time::now()
            ];
            $this->db->table('products')->insert($data);
        }
    }
}
