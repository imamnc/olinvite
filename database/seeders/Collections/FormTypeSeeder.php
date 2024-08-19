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
            'code' => 'text',
            'value_type' => 'single'
        ]);
        // Input textarea
        FormType::create([
            'name' => 'Textarea',
            'code' => 'textarea',
            'value_type' => 'single'
        ]);
        // Upload image
        FormType::create([
            'name' => 'Upload Image',
            'code' => 'upload_image',
            'value_type' => 'single'
        ]);
        // Multi upload image
        FormType::create([
            'name' => 'Multi Upload Image',
            'code' => 'multi_upload_image',
            'value_type' => 'mulitple'
        ]);
        // Input number
        FormType::create([
            'name' => 'Input Number',
            'code' => 'number',
            'value_type' => 'single'
        ]);
        // Input phone
        FormType::create([
            'name' => 'Input Phone',
            'code' => 'phone',
            'value_type' => 'single'
        ]);
        // Input link
        FormType::create([
            'name' => 'Input Link',
            'code' => 'link',
            'value_type' => 'single'
        ]);
        // Input youtube link
        FormType::create([
            'name' => 'Youtube Link',
            'code' => 'youtube',
            'value_type' => 'single'
        ]);
    }
}
