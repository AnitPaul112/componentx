<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // First, create the categories
        $categories = [
            'Passive Component' => 'Components that do not require a power source to function',
            'Optoelectronic' => 'Components that convert electrical energy to light or vice versa',
            'Semiconductor' => 'Electronic components made from semiconductor materials',
            'Integrated Circuit' => 'Complex electronic circuits on a single chip',
            'Sensor' => 'Devices that detect and respond to input from the physical environment',
            'Sensor Module' => 'Complete sensor units with additional circuitry',
            'Microcontroller Board' => 'Programmable circuit boards with microcontrollers',
            'Prototyping Tool' => 'Tools used for building and testing electronic circuits',
            'Prototyping Accessory' => 'Accessories used in electronic prototyping',
            'Actuator' => 'Devices that convert electrical signals into physical movement',
            'Communication Module' => 'Modules that enable wireless communication',
            'Single-Board Computer' => 'Complete computers built on a single circuit board'
        ];

        foreach ($categories as $name => $description) {
            DB::table('product_categories')->insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Then, create the products
        $products = [
            [
                'product_name' => 'Resistor (1kΩ, 0.25W)',
                'product_price' => 2,
                'product_description' => 'Limits current flow in circuits. Essential component for voltage division and current limiting applications.',
                'category' => 'Passive Component',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('Resistor (1kΩ, 0.25W)'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => 'Capacitor (100µF, 25V)',
                'product_price' => 8,
                'product_description' => 'Stores and releases electrical energy. Used for filtering, coupling, and decoupling applications.',
                'category' => 'Passive Component',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('Capacitor (100µF, 25V)'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => 'LED (5mm, Red)',
                'product_price' => 4,
                'product_description' => 'Emits light when current passes through. Common indicator light used in various electronic projects.',
                'category' => 'Optoelectronic',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('LED (5mm, Red)'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => 'Diode (1N4007)',
                'product_price' => 4,
                'product_description' => 'Allows current to flow in one direction. Used for rectification and protection circuits.',
                'category' => 'Semiconductor',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('Diode (1N4007)'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => 'Transistor (BC547)',
                'product_price' => 8,
                'product_description' => 'Amplifies or switches electronic signals. Versatile component for amplification and switching applications.',
                'category' => 'Semiconductor',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('Transistor (BC547)'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => '555 Timer IC',
                'product_price' => 20,
                'product_description' => 'Used for timing and pulse generation applications. Popular for creating oscillators and timing circuits.',
                'category' => 'Integrated Circuit',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('555 Timer IC'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => 'LDR (Light Dependent Resistor)',
                'product_price' => 15,
                'product_description' => 'Changes resistance based on light intensity. Used in light sensing applications.',
                'category' => 'Sensor',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('LDR (Light Dependent Resistor)'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => 'IR Sensor Module',
                'product_price' => 80,
                'product_description' => 'Detects infrared light for obstacle detection. Includes transmitter and receiver for proximity sensing.',
                'category' => 'Sensor Module',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('IR Sensor Module'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => 'Ultrasonic Sensor (HC-SR04)',
                'product_price' => 125,
                'product_description' => 'Measures distance using ultrasonic waves. Accurate distance measurement up to 400cm.',
                'category' => 'Sensor Module',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('Ultrasonic Sensor (HC-SR04)'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => 'Arduino Uno R3',
                'product_price' => 550,
                'product_description' => 'Open-source microcontroller board for prototyping. Based on ATmega328P, perfect for beginners.',
                'category' => 'Microcontroller Board',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('Arduino Uno R3'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => 'Breadboard (400 tie-points)',
                'product_price' => 100,
                'product_description' => 'Used for constructing prototypes without soldering. Essential tool for circuit prototyping.',
                'category' => 'Prototyping Tool',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('Breadboard (400 tie-points)'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => 'Jumper Wires (Male to Male, 40 pcs)',
                'product_price' => 60,
                'product_description' => 'Wires for making connections on a breadboard. High-quality copper wires with durable connectors.',
                'category' => 'Prototyping Accessory',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('Jumper Wires (Male to Male, 40 pcs)'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => 'Servo Motor (SG90)',
                'product_price' => 175,
                'product_description' => 'Provides precise control of angular position. Ideal for robotics and automation projects.',
                'category' => 'Actuator',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('Servo Motor (SG90)'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => 'ESP8266 Wi-Fi Module',
                'product_price' => 350,
                'product_description' => 'Enables Wi-Fi connectivity for microcontrollers. Popular for IoT projects and wireless communication.',
                'category' => 'Communication Module',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('ESP8266 Wi-Fi Module'),
                'stock_quantity' => 100
            ],
            [
                'product_name' => 'Raspberry Pi 4 Model B (4GB RAM)',
                'product_price' => 6500,
                'product_description' => 'Versatile SBC for various computing projects. Powerful single-board computer with 4GB RAM.',
                'category' => 'Single-Board Computer',
                'image_url' => 'https://placehold.co/300x200?text=' . urlencode('Raspberry Pi 4 Model B (4GB RAM)'),
                'stock_quantity' => 100
            ]
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'product_name' => $productData['product_name'],
                'product_price' => $productData['product_price'],
                'product_description' => $productData['product_description'],
                'image_url' => $productData['image_url'],
                'stock_quantity' => $productData['stock_quantity'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $categoryId = DB::table('product_categories')
                ->where('name', $productData['category'])
                ->value('id');

            DB::table('product_category')->insert([
                'product_id' => $product->id,
                'category_id' => $categoryId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
} 