<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\MaterialCategory;

class MaterialSeeder extends Seeder
{
    public function run()
    {
        $paintCategory = MaterialCategory::where('slug', 'paint')->first();
        $furnitureCategory = MaterialCategory::where('slug', 'furniture')->first();
        $flooringCategory = MaterialCategory::where('slug', 'flooring')->first();

        // PAINT MATERIALS
        $paints = [
            [
                'name' => 'Premium Emulsion',
                'slug' => 'premium-emulsion',
                'description' => 'High-quality washable emulsion paint for interior walls',
                'base_price' => 30.00, // ₹30 per sq ft
                'brand' => 'Asian Paints',
                'specifications' => ['coverage' => '140-160 sq ft/litre', 'finish' => 'Matt'],
            ],
            [
                'name' => 'Royal Luxury',
                'slug' => 'royal-luxury',
                'description' => 'Premium luxury emulsion with Teflon surface protector',
                'base_price' => 45.00,
                'brand' => 'Asian Paints',
                'specifications' => ['coverage' => '130-150 sq ft/litre', 'finish' => 'Soft Sheen'],
            ],
            [
                'name' => 'Ultima Protek',
                'slug' => 'ultima-protek',
                'description' => 'Exterior weatherproof paint with 10-year warranty',
                'base_price' => 55.00,
                'brand' => 'Asian Paints',
                'specifications' => ['coverage' => '120-140 sq ft/litre', 'finish' => 'Semi-Gloss'],
            ],
            [
                'name' => 'Tractor Emulsion',
                'slug' => 'tractor-emulsion',
                'description' => 'Economy interior emulsion for budget projects',
                'base_price' => 18.00,
                'brand' => 'Asian Paints',
                'specifications' => ['coverage' => '150-170 sq ft/litre', 'finish' => 'Matt'],
            ],
        ];

        foreach ($paints as $paint) {
            Material::create(array_merge($paint, ['category_id' => $paintCategory->id]));
        }

        // FURNITURE MATERIALS
        $furniture = [
            [
                'name' => '3-Seater Leather Sofa',
                'slug' => '3-seater-leather-sofa',
                'description' => 'Genuine Italian leather sofa with hardwood frame',
                'base_price' => 45000.00,
                'brand' => 'Stanley',
                'specifications' => ['dimensions' => '84" x 36" x 32"', 'material' => 'Top-grain leather'],
            ],
            [
                'name' => 'Fabric Sofa Set',
                'slug' => 'fabric-sofa-set',
                'description' => 'Modern fabric sofa with customizable upholstery',
                'base_price' => 25000.00,
                'brand' => 'Urban Ladder',
                'specifications' => ['dimensions' => '78" x 34" x 30"', 'material' => 'Premium fabric'],
            ],
            [
                'name' => 'Dining Table 6-Seater',
                'slug' => 'dining-table-6-seater',
                'description' => 'Solid wood dining table with marble top',
                'base_price' => 35000.00,
                'brand' => 'Home Centre',
                'specifications' => ['dimensions' => '60" x 36" x 30"', 'material' => 'Sheesham wood + Marble'],
            ],
            [
                'name' => 'King Size Bed',
                'slug' => 'king-size-bed',
                'description' => 'Upholstered king size bed with storage',
                'base_price' => 40000.00,
                'brand' => 'Sleepwell',
                'specifications' => ['dimensions' => '78" x 72"', 'material' => 'Engineered wood + Fabric'],
            ],
            [
                'name' => 'Wardrobe 4-Door',
                'slug' => 'wardrobe-4-door',
                'description' => 'Spacious 4-door wardrobe with mirror',
                'base_price' => 28000.00,
                'brand' => 'Godrej Interio',
                'specifications' => ['dimensions' => '72" x 72" x 22"', 'material' => 'Ply + Laminate'],
            ],
        ];

        foreach ($furniture as $item) {
            Material::create(array_merge($item, ['category_id' => $furnitureCategory->id]));
        }

        // FLOORING MATERIALS
        $flooring = [
            [
                'name' => 'Vitrified Tiles',
                'slug' => 'vitrified-tiles',
                'description' => 'Double-charged vitrified tiles for living areas',
                'base_price' => 85.00,
                'brand' => 'Kajaria',
                'specifications' => ['size' => '2x2 feet', 'thickness' => '8mm'],
            ],
            [
                'name' => 'Italian Marble',
                'slug' => 'italian-marble',
                'description' => 'Imported Italian marble for premium flooring',
                'base_price' => 450.00,
                'brand' => 'Bhandari',
                'specifications' => ['type' => 'Carrara/Statuario', 'finish' => 'Polished'],
            ],
            [
                'name' => 'Wooden Flooring',
                'slug' => 'wooden-flooring',
                'description' => 'Engineered oak wood flooring',
                'base_price' => 180.00,
                'brand' => 'Quick-Step',
                'specifications' => ['type' => 'Engineered wood', 'thickness' => '12mm'],
            ],
            [
                'name' => 'Vinyl Planks',
                'slug' => 'vinyl-planks',
                'description' => 'Waterproof vinyl flooring for kitchens/bathrooms',
                'base_price' => 65.00,
                'brand' => 'Tarkett',
                'specifications' => ['type' => 'SPC Vinyl', 'thickness' => '4mm'],
            ],
        ];

        foreach ($flooring as $floor) {
            Material::create(array_merge($floor, ['category_id' => $flooringCategory->id]));
        }
    }
}