<?php

use App\Entities\Auth\Client;
use Illuminate\Database\Seeder;

class OAuthClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Client::create([
           'id' => '$2y$10$jvw/V6Fo9mvp4JXDCYYI..123uYpTEl27',
           'secret' => '$2y$10$9OqJjxC9qZKC92L.123nO7hVOPY0436eU',
           'name' => 'Yegnacon Web Client',
       ]);
    }
}
