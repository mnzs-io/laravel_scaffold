<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Association;
use App\Models\MemoryCards\Alternative;
use App\Models\MemoryCards\Card;
use App\Models\MemoryCards\Course;
use App\Models\MemoryCards\Organization;
use App\Models\MemoryCards\Question;
use App\Models\MemoryCards\Subject;
use App\Models\MemoryCards\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MemoryCardsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'devmenezes@outlook.com')->first();

        if (!$user) {
            throw new \Exception('Usuário Rafael não encontrado!');
        }

        $json = File::get(database_path('seeders/data/memory_cards_seed.json'));
        $data = json_decode($json, true);

        // Organização
        $orgData = $data['organization'];
        $organization = Organization::firstOrCreate(
            ['slug' => $orgData['slug']],
            [
                'name' => $orgData['name'],
                'color' => $orgData['color'],
                'active' => $orgData['active'],
            ]
        );

        // Curso
        $courseData = $data['course'];
        $course = Course::create([
            'name' => $courseData['name'],
            'slug' => $courseData['slug'],
            'secret' => Str::random(32),
            'color' => $courseData['color'],
            'organization_id' => $organization->id,
            'active' => $courseData['active'],
        ]);

        foreach ($data['subjects'] as $subjectData) {
            $subject = Subject::create([
                'name' => $subjectData['name'],
                'slug' => Str::slug($subjectData['name']),
                'color' => $subjectData['color'] ?? 'gray',
                'organization_id' => $organization->id,
            ]);
            $subject->courses()->attach($course->id);

            // Associar usuário como TEACHER na disciplina (Subject)
            Association::firstOrCreate([
                'user_id' => $user->id,
                'role' => Role::TEACHER,
                'associable_type' => Subject::class,
                'associable_id' => $subject->id,
            ]);

            foreach ($subjectData['topics'] as $topicData) {
                $topic = Topic::create([
                    'name' => $topicData['name'],
                    'slug' => Str::slug($topicData['name']),
                    'subject_id' => $subject->id,
                ]);

                foreach ($topicData['cards'] as $cardData) {
                    Card::create([
                        'front' => $cardData['front'],
                        'back' => $cardData['back'],
                        'visible' => true,
                        'topic_id' => $topic->id,
                        'teacher_id' => $user->id,
                    ]);
                }

                foreach ($topicData['questions'] as $questionData) {
                    $question = Question::create([
                        'statement' => $questionData['statement'],
                        'comment' => $questionData['comment'],
                        'visible' => true,
                        'topic_id' => $topic->id,
                        'teacher_id' => $user->id,
                    ]);

                    foreach ($questionData['alternatives'] as $alt) {
                        Alternative::create([
                            'text' => $alt['text'],
                            'is_correct' => $alt['is_correct'],
                            'question_id' => $question->id,
                        ]);
                    }
                }
            }
        }
    }
}
