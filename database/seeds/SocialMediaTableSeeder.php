<?php

use App\SocialMedia;
use Illuminate\Database\Seeder;

class SocialMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SocialMedia::create([
            'id' => 1,
            'name' => 'Facebook',
            'url' => 'https://www.facebook.com',
            'icon_name' => 'fb-icon.png',
            'link_code_alias' => 'username'
        ]);

        SocialMedia::create([
            'id' => 2,
            'name' => 'Twitter',
            'url' => 'https://www.twitter.com',
            'icon_name' => 'twitter-icon.png',
            'link_code_alias' => 'username'
        ]);

        SocialMedia::create([
            'id' => 3,
            'name' => 'Instagram',
            'url' => 'https://www.instagram.com',
            'icon_name' => 'instagram-icon.png',
            'link_code_alias' => 'username'
        ]);

        SocialMedia::create([
            'id' => 4,
            'name' => 'Skype',
            'url' => 'https://www.skype.com',
            'icon_name' => 'skype-icon.png',
            'link_code_alias' => 'username'
        ]);
    }
}
