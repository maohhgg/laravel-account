<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Navigation;

/**
 * @extends Factory<Navigation>
 */
class NavigationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'action' => Str::random(10),
            'icon' => Str::random(10),
            'name' => Str::random(10),
            'url' => Str::random(10),
            'parent_id' => rand(0,1),
            'is_admin' => rand(0,1),
        ];
    }

}
