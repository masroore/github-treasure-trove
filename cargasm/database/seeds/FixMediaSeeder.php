<?php

use Illuminate\Database\Seeder;

class FixMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Spatie\MediaLibrary\Models\Media::where('collection_name', 'main_photo')
            ->update(['is_main' => 1]);

        \Spatie\MediaLibrary\Models\Media::where('model_type', \App\Models\Service::class)
            ->update(['collection_name' => 'photos']);
        \Spatie\MediaLibrary\Models\Media::where('model_type', \App\Models\Post::class)
            ->update(['collection_name' => 'photo']);
        \Spatie\MediaLibrary\Models\Media::where('model_type', App\Models\User::class)
            ->update(['collection_name' => 'avatar']);
        \Spatie\MediaLibrary\Models\Media::where('model_type', App\Models\Car::class)
            ->update(['collection_name' => 'photos']);
        \Spatie\MediaLibrary\Models\Media::where('model_type', App\Models\Banner::class)
            ->update(['collection_name' => 'photo']);
    }
}
