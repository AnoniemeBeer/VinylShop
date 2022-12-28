<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('genre_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('artist');
            $table->string('title');
            $table->string('mb_id', 36)->unique();
            $table->float('price', 5, 2)->default(19.99);
            $table->unsignedInteger('stock')->default(1);
            $table->timestamps();
        });
        // Insert some records (inside up-function, after create method)
        DB::table('records')->insert(
            [
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Queen',
                    'title' => 'Greatest Hits',
                    'mb_id' => 'fcb78d0d-8067-4b93-ae58-1e4347e20216',
                    'price' => 19.99
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'The Rolling Stones',
                    'title' => 'Sticky Fingers',
                    'mb_id' => 'd883e644-5ec0-4928-9ccd-fc78bc306a46',
                    'price' => 21.00
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'The Beatles',
                    'title' => 'Abbey Road',
                    'mb_id' => 'd6010be3-98f8-422c-a6c9-787e2e491e58',
                    'price' => 24.99
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 3,
                    'artist' => 'The Who',
                    'title' => 'Tommy',
                    'mb_id' => 'fceaca05-a210-4f92-9e88-1e8b44ec8e37',
                    'price' => 12.50
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Fleetwood Mac',
                    'title' => 'Rumours',
                    'mb_id' => '081ea37e-db59-4332-8cd2-ad020cb93af6',
                    'price' => 19.99
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 3,
                    'artist' => 'David Bowie',
                    'title' => 'The Rise and Fall of Ziggy Stardust and the Spiders From Mars',
                    'mb_id' => '7dc5edce-ead6-41e4-9c4b-240223c9bab0',
                    'price' => 24.99
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'David Bowie',
                    'title' => '"Heroes"',
                    'mb_id' => 'f0a4ed57-10e0-4c37-81b4-36311dc7d4b6',
                    'price' => 19.99
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Steve Harley & Cockney Rebel',
                    'title' => 'The Psychomodo',
                    'mb_id' => '88776dcc-072e-4072-bc25-8b970a3f055e',
                    'price' => 9.99
                ],
                [
                    'genre_id' => 1,
                    'created_at' => now(),
                    'stock' => 4,
                    'artist' => 'Roxy Music',
                    'title' => 'Siren',
                    'mb_id' => 'c2dad882-7804-416d-980e-d06b8405e9cf',
                    'price' => 24.00
                ],
                [
                    'genre_id' => 3,
                    'created_at' => now(),
                    'stock' => 4,
                    'artist' => 'Ministry',
                    'title' => 'The Land of Rape and Honey',
                    'mb_id' => '4bcaf5b9-76ba-4891-934b-1a441c62b008',
                    'price' => 19.99
                ],
                [
                    'genre_id' => 3,
                    'created_at' => now(),
                    'stock' => 2,
                    'artist' => 'Front 242',
                    'title' => 'Front by Front',
                    'mb_id' => '97508279-e7d3-4303-8f2a-483119ce41c7',
                    'price' => 16.49
                ],
                [
                    'genre_id' => 3,
                    'created_at' => now(),
                    'stock' => 3,
                    'artist' => 'Nine Inch Nails',
                    'title' => 'Pretty Hate Machine',
                    'mb_id' => '8f156938-6462-3b3e-84ba-bfc7dd232c34',
                    'price' => 25.00
                ],
                [
                    'genre_id' => 3,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'Einstürzende Neubauten',
                    'title' => 'Halber Mensch',
                    'mb_id' => '94b93f48-6357-49fd-affa-7c07db1f131b',
                    'price' => 14.00
                ],
                [
                    'genre_id' => 5,
                    'created_at' => now(),
                    'stock' => 5,
                    'artist' => 'The Police',
                    'title' => 'Outlandos d\'Amour',
                    'mb_id' => 'e07a2c71-dde7-37a3-8b02-44d25dd128f9',
                    'price' => 19.99
                ],
                [
                    'genre_id' => 5,
                    'created_at' => now(),
                    'stock' => 2,
                    'artist' => 'Japan',
                    'title' => 'Oil on Canvas',
                    'mb_id' => 'a7472800-543f-44a1-a299-7bd07b80e9a8',
                    'price' => 9.99
                ],
                [
                    'genre_id' => 5,
                    'created_at' => now(),
                    'stock' => 4,
                    'artist' => 'The Cure',
                    'title' => 'Disintegration',
                    'mb_id' => '11af85e2-c272-4c59-a902-47f75141dc97',
                    'price' => 26.00
                ],
                [
                    'genre_id' => 5,
                    'created_at' => now(),
                    'stock' => 2,
                    'artist' => 'Talking Heads',
                    'title' => 'Stop Making Sense',
                    'mb_id' => '5f4ad828-bb45-4867-9ae9-295cfe22449d',
                    'price' => 9.90
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Sex Pistols',
                    'title' => 'Never Mind the Bollocks',
                    'mb_id' => '11c6c574-6442-45f8-9c25-110675725f2f',
                    'price' => 15.00
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'The Clash',
                    'title' => 'London Calling',
                    'mb_id' => '7bec22a0-eb73-4b79-a619-b253d5c2af87',
                    'price' => 11.99
                ],
                [
                    'genre_id' => 12,
                    'created_at' => now(),
                    'stock' => 2,
                    'artist' => 'Atari Teenage Riot',
                    'title' => 'The Future of War',
                    'mb_id' => 'fcba15e2-3d1e-40b3-996c-be22450bda82',
                    'price' => 21.50
                ],
                [
                    'genre_id' => 12,
                    'created_at' => now(),
                    'stock' => 3,
                    'artist' => 'Sonic Youth',
                    'title' => 'EVOL',
                    'mb_id' => '22079997-d0d3-449a-83e0-e8ac1942740f',
                    'price' => 24.99
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 5,
                    'artist' => 'H₂O',
                    'title' => 'Nothing to Prove',
                    'mb_id' => '60464f78-9697-4458-adfd-0e2a0109c9f5',
                    'price' => 18.99
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 5,
                    'artist' => 'Turnstile',
                    'title' => 'Time & Space',
                    'mb_id' => '36a6b0c0-24d3-4cae-9e7c-96ba0da9a331',
                    'price' => 24.99
                ],
                [
                    'genre_id' => 4,
                    'created_at' => now(),
                    'stock' => 5,
                    'artist' => 'Guns N\' Roses',
                    'title' => 'Appetite for Destruction',
                    'mb_id' => 'b6945872-411f-4bf5-824b-7b319148a264',
                    'price' => 24.99
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Off With Their Heads',
                    'title' => 'Home',
                    'mb_id' => 'ae6938f1-a7a1-4864-892e-778e27f17426',
                    'price' => 15.99
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 2,
                    'artist' => 'Social Distortion',
                    'title' => 'Somewhere Between Heaven and Hell',
                    'mb_id' => '68f75281-39f2-43fc-a63a-76a8854c777c',
                    'price' => 15.99
                ],
                [
                    'genre_id' => 7,
                    'created_at' => now(),
                    'stock' => 3,
                    'artist' => 'Bob Marley & The Wailers',
                    'title' => 'Uprising',
                    'mb_id' => '62ed2ddd-498c-4d93-9b8c-d352d38e9ea9',
                    'price' => 29.99
                ],
                [
                    'genre_id' => 16,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'House of Pain',
                    'title' => 'House of Pain',
                    'mb_id' => 'f9490168-7fa1-4076-a5e2-ee6a246584c6',
                    'price' => 16.99
                ],
                [
                    'genre_id' => 4,
                    'created_at' => now(),
                    'stock' => 3,
                    'artist' => 'Volbeat',
                    'title' => 'The Strength/The Sound/The Songs',
                    'mb_id' => '2794f3ec-ff30-4526-ab20-c188edc25024',
                    'price' => 19.99
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Suicidal Tendencies',
                    'title' => 'Join the Army',
                    'mb_id' => '6c5e4cc7-9955-4281-a017-463be6e71b09',
                    'price' => 14.99
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 4,
                    'artist' => 'Cock Sparrer',
                    'title' => 'Forever',
                    'mb_id' => '4171be5b-6904-40de-b1f7-07c73bbb6690',
                    'price' => 17.50
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 0,
                    'artist' => 'SNFU',
                    'title' => 'The One Voted Most Likely to Succeed',
                    'mb_id' => 'fcaf21bb-915c-34bb-ab08-abb35588746f',
                    'price' => 17.50
                ],
                [
                    'genre_id' => 2,
                    'created_at' => now(),
                    'stock' => 2,
                    'artist' => 'Descendents',
                    'title' => 'Milo Goes to College',
                    'mb_id' => '72837739-550b-3a21-8d7a-3bb898562b6a',
                    'price' => 32.50
                ],
                [
                    'genre_id' => 7,
                    'created_at' => now(),
                    'stock' => 1,
                    'artist' => 'Peter Tosh',
                    'title' => 'Mama Africa',
                    'mb_id' => '38d30631-9341-4e62-9d10-2cd372b3e0f4',
                    'price' => 22.50
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
};
