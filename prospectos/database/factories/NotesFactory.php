<?php

namespace Database\Factories;

use App\Models\Notes;
use App\Models\Status;
use App\Models\User as User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notes::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4, true),
            'content' => $this->faker->paragraph(3, true),
            'status_id' => Status::factory()->create()->id,
            'note_type' => $this->faker->word(),
            'applies_to_date' => $this->faker->date(),
            'users_id' => User::factory()->create()->id,
        ];
    }
}
