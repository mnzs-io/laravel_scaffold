<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\MemoryCards\Alternative;
use App\Models\MemoryCards\Card;
use App\Models\MemoryCards\Organization;
use App\Models\MemoryCards\Question;
use App\Models\MemoryCards\Subject;
use App\Models\MemoryCards\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class CedSeeder extends Seeder
{
    public function run(): void
    {
        $org = Organization::firstOrCreate([
            'slug' => 'ced-chqao',
        ], [
            'name' => 'CED CHQAO',
            'color' => '#3490dc',
            'logo_url' => 'https://via.placeholder.com/150',
            'active' => true,
        ]);

        $lira = User::firstOrCreate([
            'email' => 'owner@gmail.com',
        ], [
            'name' => 'Prof. Leandro Lira',
            'password' => bcrypt('12345678'),
            'avatar' => 'http://cedchqao.com.br/storage/profile-photos/V73xnCqoINVqXSmhVwh3z4rqie3nWx6DA9UYE1wM.jpg',
        ]);

        $lira->associations()->create([
            'role' => Role::ADMIN,
            'associable_type' => Organization::class,
            'associable_id' => $org->id,
        ]);

        $professorQuizard = User::firstOrCreate([
            'email' => 'quizard@gmail.com',
        ], [
            'name' => 'Prof. Teste',
            'password' => bcrypt('12345678'),
            'avatar' => 'http://cedchqao.com.br/storage/profile-photos/V73xnCqoINVqXSmhVwh3z4rqie3nWx6DA9UYE1wM.jpg',
        ]);

        $subjectsJson = json_decode(file_get_contents(__DIR__ . '/data/all.json'));

        foreach ($subjectsJson as $s) {
            $subject = Subject::create([
                'name' => $s->name,
                'color' => $s->color,
                'slug' => $s->slug,
                'organization_id' => $org->id,
                'description' => $s->description,
            ]);

            $lira->associations()->create([
                'role' => Role::TEACHER,
                'associable_type' => Subject::class,
                'associable_id' => $subject->id,
            ]);

            $professorQuizard->associations()->create([
                'role' => Role::TEACHER,
                'associable_type' => Subject::class,
                'associable_id' => $subject->id,
            ]);

            foreach ($s->topics as $t) {
                $topic = Topic::create([
                    'name' => $t->name,
                    'color' => $t->color,
                    'slug' => $t->slug,
                    'description' => $t->description ?? $t->name,
                    'subject_id' => $subject->id,
                ]);

                foreach ($t->questions as $q) {
                    $question = Question::create([
                        'statement' => $q->statement,
                        'comment' => $q->comment,
                        'image' => $q->image,
                        'visible' => $q->visible,
                        'topic_id' => $topic->id,
                        'teacher_id' => $lira->id,
                    ]);

                    foreach ($q->alternatives as $a) {
                        Alternative::create([
                            'text' => $a->text,
                            'is_correct' => $a->is_correct,
                            'question_id' => $question->id,
                        ]);
                    }
                }

                foreach ($t->cards as $index => $c) {
                    Card::create([
                        'front' => $c->front,
                        'back' => $c->back,
                        'visible' => true,
                        'teacher_id' => $index % 2 === 0 ? $lira->id : $professorQuizard->id,
                        'topic_id' => $topic->id,
                    ]);
                }
            }
        }

        $associations = json_decode(file_get_contents(__DIR__ . '/data/teachers.json'));

        foreach ($associations as $a) {
            $teacher = User::firstOrCreate([
                'email' => $a->teacher->email,
            ], [
                'name' => str()->title($a->teacher->name),
                'password' => bcrypt('12345678'),
                'avatar' => $a->teacher->profile_photo_url,
                'created_at' => $a->teacher->created_at ?? now(),
                'updated_at' => $a->teacher->updated_at ?? now(),
            ]);

            $subject = Subject::where('name', $a->subject->name)->first();

            if ($subject) {
                $teacher->associations()->create([
                    'role' => Role::TEACHER,
                    'associable_type' => Subject::class,
                    'associable_id' => $subject->id,
                ]);
            }
        }
    }
}
