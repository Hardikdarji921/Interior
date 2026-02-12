<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        $testimonials = [
            [
                'client_name' => 'Alex Smith',
                'client_position' => 'CEO, Tech Company',
                'content' => 'Staging transformed our office space completely. Their attention to detail and creative solutions exceeded our expectations. Highly recommended!',
                'rating' => 5,
            ],
            [
                'client_name' => 'Maria Garcia',
                'client_position' => 'Homeowner',
                'content' => 'Working with Staging was an absolute pleasure. They understood my vision and brought it to life beautifully. My home has never looked better!',
                'rating' => 5,
            ],
            [
                'client_name' => 'John Williams',
                'client_position' => 'Restaurant Owner',
                'content' => 'The team at Staging designed our restaurant interior and the results are stunning. Our customers constantly compliment the ambiance.',
                'rating' => 5,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
