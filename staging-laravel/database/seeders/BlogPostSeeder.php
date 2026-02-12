<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;

class BlogPostSeeder extends Seeder
{
    public function run()
    {
        $posts = [
            [
                'title' => 'Top Interior Design Trends for 2024',
                'slug' => 'top-interior-design-trends-for-2024',
                'excerpt' => 'Discover the hottest interior design trends that are dominating 2024. From sustainable materials to bold colors, learn what\'s in this year.',
                'content' => '<p>The interior design world is constantly evolving, and 2024 brings exciting new trends that blend sustainability with style.</p><h2>1. Sustainable Materials</h2><p>Eco-friendly materials are becoming increasingly important in design. Reclaimed wood, recycled metals, and natural fabrics are top choices.</p><h2>2. Bold Color Choices</h2><p>Gone are the days of neutral everything. Bold jewel tones and rich earth tones are making a comeback.</p><h2>3. Maximalism</h2><p>More is more. Layering textures, patterns, and colors creates a luxurious and personal space.</p>',
                'featured_image' => 'blog/trend-2024.jpg',
                'author_name' => 'Design Team',
                'category' => 'Trends',
                'views' => 1250,
                'published_at' => '2024-01-20 10:00:00',
            ],
            [
                'title' => 'How to Choose the Perfect Color Palette',
                'slug' => 'how-to-choose-the-perfect-color-palette',
                'excerpt' => 'Color selection is one of the most important aspects of interior design. Learn how to choose colors that work together harmoniously.',
                'content' => '<p>Selecting the right color palette can make or break your interior design project. Here\'s how to choose colors that complement each other.</p><h2>The 60-30-10 Rule</h2><p>Use 60% dominant color, 30% secondary color, and 10% accent color for a balanced look.</p><h2>Consider Lighting</h2><p>Natural and artificial lighting dramatically affects how colors appear in your space. Always test colors in the actual lighting conditions.</p><h2>Personal Preference</h2><p>While trends are important, your personal style should always come first. Choose colors that make you happy.</p>',
                'featured_image' => 'blog/color-palette.jpg',
                'author_name' => 'Interior Expert',
                'category' => 'Design Tips',
                'views' => 890,
                'published_at' => '2024-01-15 14:30:00',
            ],
            [
                'title' => 'Maximizing Small Spaces with Smart Design',
                'slug' => 'maximizing-small-spaces-with-smart-design',
                'excerpt' => 'Living in a small space doesn\'t mean compromising on style. Learn proven strategies to make small rooms feel larger and more functional.',
                'content' => '<p>Small spaces can be beautifully designed with the right approach. Here are strategies to maximize every square inch.</p><h2>Vertical Storage</h2><p>Use wall space for storage to free up floor space. Tall shelving and wall-mounted cabinets are your friends.</p><h2>Multi-functional Furniture</h2><p>Choose furniture that serves multiple purposes. Ottomans with storage, sofa beds, and expandable tables are lifesavers.</p><h2>Light and Bright</h2><p>Light colors and good lighting make spaces feel larger. Use mirrors strategically to reflect light and create an illusion of space.</p>',
                'featured_image' => 'blog/small-spaces.jpg',
                'author_name' => 'Design Consultant',
                'category' => 'Tips',
                'views' => 2100,
                'published_at' => '2024-01-10 09:15:00',
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create($post);
        }
    }
}
