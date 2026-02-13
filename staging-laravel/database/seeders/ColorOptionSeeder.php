<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ColorOption;
use App\Models\MaterialCategory;

class ColorOptionSeeder extends Seeder
{
    public function run()
    {
        $paintCategory = MaterialCategory::where('slug', 'paint')->first();
        $furnitureCategory = MaterialCategory::where('slug', 'furniture')->first();
        $flooringCategory = MaterialCategory::where('slug', 'flooring')->first();

        // PAINT COLORS (All at ₹30 per sq ft base, some premium colors cost more)
        $paintColors = [
            // Standard Colors - Base Price
            ['name' => 'Pure White', 'hex' => '#FFFFFF', 'multiplier' => 1.0, 'finish' => 'Matt'],
            ['name' => 'Creamy White', 'hex' => '#F5F5DC', 'multiplier' => 1.0, 'finish' => 'Matt'],
            ['name' => 'Light Grey', 'hex' => '#D3D3D3', 'multiplier' => 1.0, 'finish' => 'Matt'],
            ['name' => 'Beige', 'hex' => '#F5F5DC', 'multiplier' => 1.0, 'finish' => 'Matt'],
            
            // Premium Colors - 10% extra
            ['name' => 'Royal Blue', 'hex' => '#4169E1', 'multiplier' => 1.10, 'finish' => 'Satin'],
            ['name' => 'Crimson Red', 'hex' => '#DC143C', 'multiplier' => 1.10, 'finish' => 'Satin'],
            ['name' => 'Emerald Green', 'hex' => '#50C878', 'multiplier' => 1.10, 'finish' => 'Satin'],
            ['name' => 'Burnt Orange', 'hex' => '#CC5500', 'multiplier' => 1.10, 'finish' => 'Satin'],
            
            // Luxury Colors - 20% extra
            ['name' => 'Midnight Black', 'hex' => '#191970', 'multiplier' => 1.20, 'finish' => 'Glossy'],
            ['name' => 'Gold Metallic', 'hex' => '#FFD700', 'multiplier' => 1.20, 'finish' => 'Metallic'],
            ['name' => 'Silver Metallic', 'hex' => '#C0C0C0', 'multiplier' => 1.20, 'finish' => 'Metallic'],
            ['name' => 'Pearl White', 'hex' => '#FDEEF4', 'multiplier' => 1.20, 'finish' => 'Pearl'],
            
            // Special Textures - Fixed price ₹50
            ['name' => 'Texture Royal', 'hex' => '#D4AF37', 'fixed_price' => 50.00, 'finish' => 'Texture'],
            ['name' => 'Sand Finish', 'hex' => '#C2B280', 'fixed_price' => 50.00, 'finish' => 'Texture'],
        ];

        foreach ($paintColors as $color) {
            ColorOption::create(array_merge($color, [
                'category_id' => $paintCategory->id,
            ]));
        }

        // FURNITURE COLORS (Upholstery/Wood finishes)
        $furnitureColors = [
            // Fabric Colors
            ['name' => 'Charcoal Grey', 'hex' => '#36454F', 'multiplier' => 1.0, 'finish' => 'Fabric'],
            ['name' => 'Navy Blue', 'hex' => '#000080', 'multiplier' => 1.0, 'finish' => 'Fabric'],
            ['name' => 'Olive Green', 'hex' => '#808000', 'multiplier' => 1.0, 'finish' => 'Fabric'],
            ['name' => 'Rust Orange', 'hex' => '#B7410E', 'multiplier' => 1.05, 'finish' => 'Fabric'],
            ['name' => 'Teal', 'hex' => '#008080', 'multiplier' => 1.05, 'finish' => 'Fabric'],
            
            // Leather Colors - Premium
            ['name' => 'Black Leather', 'hex' => '#000000', 'multiplier' => 1.30, 'finish' => 'Genuine Leather'],
            ['name' => 'Tan Leather', 'hex' => '#D2B48C', 'multiplier' => 1.30, 'finish' => 'Genuine Leather'],
            ['name' => 'Cream Leather', 'hex' => '#FFFDD0', 'multiplier' => 1.30, 'finish' => 'Genuine Leather'],
            ['name' => 'Burgundy Leather', 'hex' => '#800020', 'multiplier' => 1.40, 'finish' => 'Genuine Leather'],
            
            // Wood Finishes
            ['name' => 'Walnut Brown', 'hex' => '#5C4033', 'multiplier' => 1.10, 'finish' => 'Wood'],
            ['name' => 'Oak Natural', 'hex' => '#C19A6B', 'multiplier' => 1.0, 'finish' => 'Wood'],
            ['name' => 'Mahogany', 'hex' => '#C04000', 'multiplier' => 1.15, 'finish' => 'Wood'],
            ['name' => 'White Gloss', 'hex' => '#FFFFFF', 'multiplier' => 1.05, 'finish' => 'Laminate'],
        ];

        foreach ($furnitureColors as $color) {
            ColorOption::create(array_merge($color, [
                'category_id' => $furnitureCategory->id,
            ]));
        }

        // FLOORING COLORS
        $flooringColors = [
            ['name' => 'White Carrara', 'hex' => '#F0F0F0', 'multiplier' => 1.0, 'finish' => 'Polished'],
            ['name' => 'Beige Travertine', 'hex' => '#E6D5C3', 'multiplier' => 1.0, 'finish' => 'Honed'],
            ['name' => 'Dark Walnut', 'hex' => '#4A3728', 'multiplier' => 1.10, 'finish' => 'Matte'],
            ['name' => 'Grey Oak', 'hex' => '#A9A9A9', 'multiplier' => 1.05, 'finish' => 'Brushed'],
            ['name' => 'Black Granite', 'hex' => '#2F2F2F', 'multiplier' => 1.20, 'finish' => 'Polished'],
            ['name' => 'Terracotta', 'hex' => '#E2725B', 'multiplier' => 1.0, 'finish' => 'Textured'],
        ];

        foreach ($flooringColors as $color) {
            ColorOption::create(array_merge($color, [
                'category_id' => $flooringCategory->id,
            ]));
        }
    }
}