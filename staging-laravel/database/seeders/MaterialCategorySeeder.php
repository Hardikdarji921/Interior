<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaterialCategory;

class MaterialCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Paint',
                'slug' => 'paint',
                'icon' => 'fa-paint-brush',
                'description' => 'Interior and exterior wall paints with various finishes',
                'unit_type' => 'sq_ft',
                'has_color_options' => true,
                'order' => 1,
            ],
            [
                'name' => 'Furniture',
                'slug' => 'furniture',
                'icon' => 'fa-couch',
                'description' => 'Sofas, chairs, tables, and storage solutions',
                'unit_type' => 'piece',
                'has_color_options' => true,
                'order' => 2,
            ],
            [
                'name' => 'Flooring',
                'slug' => 'flooring',
                'icon' => 'fa-th-large',
                'description' => 'Tiles, hardwood, laminate, and vinyl flooring',
                'unit_type' => 'sq_ft',
                'has_color_options' => true,
                'order' => 3,
            ],
            [
                'name' => 'Lighting',
                'slug' => 'lighting',
                'icon' => 'fa-lightbulb',
                'description' => 'Ceiling lights, lamps, and decorative lighting',
                'unit_type' => 'piece',
                'has_color_options' => false,
                'order' => 4,
            ],
            [
                'name' => 'Wall Decor',
                'slug' => 'wall-decor',
                'icon' => 'fa-image',
                'description' => 'Wallpapers, wall art, and decorative panels',
                'unit_type' => 'sq_ft',
                'has_color_options' => true,
                'order' => 5,
            ],
            [
                'name' => 'Curtains & Blinds',
                'slug' => 'curtains',
                'icon' => 'fa-columns',
                'description' => 'Window treatments and coverings',
                'unit_type' => 'sq_ft',
                'has_color_options' => true,
                'order' => 6,
            ],
        ];

        foreach ($categories as $cat) {
            MaterialCategory::create($cat);
        }
    }
}