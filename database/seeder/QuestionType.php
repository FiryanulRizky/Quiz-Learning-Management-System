<?php

namespace Database\Seeders;

use App\Models\QuestionType as ModelsQuestionType;
use Illuminate\Database\Seeder;

class QuestionType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsQuestionType::create([
            'title' => 'PilihanGandaQuestion',
            'icon' => '',
            'is_mentor' => false
        ]);

        ModelsQuestionType::create([
            'title' => 'BenarSalahQuestion',
            'icon' => '',
            'is_mentor' => false
        ]);

        ModelsQuestionType::create([
            'title' => 'MultiChecklistQuestion',
            'icon' => '',
            'is_mentor' => false
        ]);

        ModelsQuestionType::create([
            'title' => 'EssayQuestion',
            'icon' => '',
            'is_mentor' => true
        ]);


        ModelsQuestionType::create([
            'title' => 'UploadFileQuestion',
            'icon' => '',
            'is_mentor' => true
        ]);

        ModelsQuestionType::create([
            'title' => 'JawabanSingkatQuestion',
            'icon' => '',
            'is_mentor' => true
        ]);

        
        ModelsQuestionType::create([
            'title' => 'PencocokanQuestion',
            'icon' => '',
            'is_mentor' => false
        ]);


        ModelsQuestionType::create([
            'title' => 'RekamSuaraQuestion',
            'icon' => '',
            'is_mentor' => true
        ]);
    }
}
