<?php

namespace Database\Factories;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Photo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $photos = [
            'https://www.designer.io/wp-content/uploads/2019/10/1-1024x698.png',
            'https://imgv3.fotor.com/images/homepage-feature-card/Fotor-AI-photo-enhancement-tool.jpg',
            'https://mymodernmet.com/wp/wp-content/uploads/2019/07/will-burrard-lucas-beetlecam-23-1024x683.jpg',
            'https://s.france24.com/media/display/451ed2b8-eed6-11ea-afdd-005056bf87d6/messi-1805.jpg',
            'https://pbs.twimg.com/profile_images/880014123785998336/GYLppyjs_400x400.jpg',
            'https://i.ytimg.com/vi/k7G0IUw1g_k/maxresdefault.jpg'
        ];
        return [
            'url' => $photos[rand(0, 5)]
        ];
    }
}
