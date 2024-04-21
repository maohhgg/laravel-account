<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Page;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::random(5),
            'url' => Str::random(5),
            'navigation_id' => rand(3, 8),
        ];
    }

}
