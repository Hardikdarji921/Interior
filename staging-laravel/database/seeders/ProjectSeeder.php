<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            [
                'title' => 'Modern Minimalist Living Room',
                'slug' => 'modern-minimalist-living-room',
                'description' => 'A stunning minimalist living room design featuring clean lines, neutral colors, and carefully selected furniture. This project showcases how simplicity can create a powerful impact.',
                'client' => 'Sarah Johnson',
                'location' => 'New York, NY',
                'completed_date' => '2024-01-15',
                'budget' => 25000,
                'category' => 'Residential',
                'thumbnail' => 'projects/project-1.jpg',
                'gallery' => ['projects/project-1.jpg', 'projects/project-1-detail.jpg'],
                'is_featured' => true,
            ],
            [
                'title' => 'Contemporary Office Space',
                'slug' => 'contemporary-office-space',
                'description' => 'A comprehensive office redesign that combines functionality with contemporary aesthetics. Features collaborative workspaces, modern furniture, and innovative lighting solutions.',
                'client' => 'Tech Innovations Inc',
                'location' => 'San Francisco, CA',
                'completed_date' => '2023-12-20',
                'budget' => 75000,
                'category' => 'Commercial',
                'thumbnail' => 'projects/project-2.jpg',
                'gallery' => ['projects/project-2.jpg', 'projects/project-2-detail.jpg'],
                'is_featured' => true,
            ],
            [
                'title' => 'Luxury Bedroom Suite',
                'slug' => 'luxury-bedroom-suite',
                'description' => 'An elegant bedroom design featuring luxury materials, custom lighting, and sophisticated color scheme. This project emphasizes comfort and elegance.',
                'client' => 'Private Client',
                'location' => 'Los Angeles, CA',
                'completed_date' => '2023-11-10',
                'budget' => 45000,
                'category' => 'Residential',
                'thumbnail' => 'projects/project-3.jpg',
                'gallery' => ['projects/project-3.jpg', 'projects/project-3-detail.jpg'],
                'is_featured' => false,
            ],
            [
                'title' => 'Restaurant Dining Experience',
                'slug' => 'restaurant-dining-experience',
                'description' => 'A complete restaurant interior design creating an inviting atmosphere for diners. Features custom lighting, acoustic design, and carefully curated decor.',
                'client' => 'La Bella Restaurant',
                'location' => 'Chicago, IL',
                'completed_date' => '2023-10-05',
                'budget' => 120000,
                'category' => 'Commercial',
                'thumbnail' => 'projects/project-4.jpg',
                'gallery' => ['projects/project-4.jpg', 'projects/project-4-detail.jpg'],
                'is_featured' => true,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
