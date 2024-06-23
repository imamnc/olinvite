<?php

namespace Database\Seeders\Collections;

use App\Models\FormType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Input text
        FormType::create([
            'name' => 'Input Text',
            'code' => 'text'
        ]);
        // Input textarea
        FormType::create([
            'name' => 'Textarea',
            'code' => 'textarea'
        ]);
        // Upload image
        FormType::create([
            'name' => 'Upload Image',
            'code' => 'upload_image'
        ]);
        // Multi upload image
        FormType::create([
            'name' => 'Multi Upload Image',
            'code' => 'multi_upload_image'
        ]);
        // Input number
        FormType::create([
            'name' => 'Input Number',
            'code' => 'number'
        ]);
        // Input phone
        FormType::create([
            'name' => 'Input Phone',
            'code' => 'phone'
        ]);
        // Input link
        FormType::create([
            'name' => 'Input Link',
            'code' => 'link'
        ]);
        // Input youtube link
        FormType::create([
            'name' => 'Youtube Link',
            'code' => 'youtube'
        ]);
    }
}
