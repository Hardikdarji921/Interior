<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'title' => 'Interior Design',
                'slug' => 'interior-design',
                'description' => 'We provide full interior design services including space planning, furniture selection, color consultation, and material specification.',
                'icon' => 'interior-design.png',
                'order' => 1,
            ],
            [
                'title' => 'Architecture',
                'slug' => 'architecture',
                'description' => 'Our architectural services cover residential and commercial projects from concept to completion.',
                'icon' => 'architecture.png',
                'order' => 2,
            ],
            [
                'title' => 'Home Decor',
                'slug' => 'home-decor',
                'description' => 'We help you select the perfect decor items to complement your space and reflect your personal style.',
                'icon' => 'home-decor.png',
                'order' => 3,
            ],
            [
                'title' => 'Furniture Design',
                'slug' => 'furniture-design',
                'description' => 'Custom furniture design services to create unique pieces that fit your space perfectly.',
                'icon' => 'furniture.png',
                'order' => 4,
            ],
            [
                'title' => 'Lighting Design',
                'slug' => 'lighting-design',
                'description' => 'Expert lighting design to create the perfect ambiance and functionality in every room.',
                'icon' => 'lighting.png',
                'order' => 5,
            ],
            [
                'title' => 'Consultation',
                'slug' => 'consultation',
                'description' => 'Professional design consultation to help you make informed decisions about your space.',
                'icon' => 'consultation.png',
                'order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
