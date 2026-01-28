<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Publication;
use App\Models\Milestone;
use App\Models\Task;
use App\Models\Attachment;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /* 1. CREAZIONE AMMINISTRATORI (Esattamente 2 in tutto il DB) */
        User::factory()->create([
            'name' => 'Admin User 1',
            'email' => 'admin1@example.com',
            'role' => 'Admin/PI',
        ]);

        User::factory()->create([
            'name' => 'Admin User 2',
            'email' => 'admin2@example.com',
            'role' => 'Admin/PI',
        ]);

        /* 2. CREAZIONE UTENTI GENERICI (Ricercatori e Collaboratori) */
        $users = User::factory(48)->create(['role' => 'Researcher']);

        /* 3. GENERAZIONE PROGETTI */
        Project::factory(70)->create()->each(function ($project) use ($users) {

            // Stato del progetto per la logica a cascata
            $isProjectCompleted = ($project->status === 'completed');

            /* ASSOCIAZIONE UTENTI AL PROGETTO */
            $projectMembers = $users->random(rand(3, 7));

            // Logica: 1 solo Project Manager per progetto
            $pmAssigned = false;
            foreach ($projectMembers as $user) {
                $role = 'Researcher';
                if (!$pmAssigned) {
                    $role = 'Project Manager';
                    $pmAssigned = true;
                } else {
                    $role = fake()->randomElement(['Researcher', 'Collaborator']);
                }

                $project->users()->attach($user->id, ['project_role' => $role]);
            }

            /* CREAZIONE MILESTONE */
            $milestones = Milestone::factory(rand(2, 4))->create([
                'project_id' => $project->id,
                // Se progetto completo -> Milestone completata ('1')
                'status' => $isProjectCompleted ? '1' : fake()->randomElement(['0', '1'])
            ]);

            /* CREAZIONE TASK */
            for ($i = 0; $i < rand(3, 8); $i++) {
                $selectedMilestone = $milestones->random();

                // Se Progetto o Milestone sono completi -> Task completato
                $mustBeCompleted = ($isProjectCompleted || $selectedMilestone->status === '1');

                $task = Task::factory()->create([
                    'project_id' => $project->id,
                    'milestone_id' => $selectedMilestone->id,
                    'status' => $mustBeCompleted ? 'completed' : fake()->randomElement(['to_do', 'in_progress', 'completed'])
                ]);

                /* ASSOCIAZIONE UTENTI MULTIPLI AL TASK (Many-to-Many) */
                $assignedToTask = $projectMembers->random(rand(1, 3));
                $task->users()->attach($assignedToTask->pluck('id'));

                /* COMMENTI AI TASK (Utenti diversi del progetto) */
                $potentialCommenters = $projectMembers->shuffle();
                $numComments = rand(1, min(3, $potentialCommenters->count()));

                for ($j = 0; $j < $numComments; $j++) {
                    Comment::factory()->create([
                        'task_id' => $task->id,
                        'user_id' => $potentialCommenters[$j]->id,
                        'body' => fake()->sentence()
                    ]);
                }
            }

            /* ALLEGATI AL PROGETTO */
            $project->attachments()->createMany(
                Attachment::factory(2)->make()->toArray()
            );
        });

        /* 4. GENERAZIONE PUBBLICAZIONI */
        $publicationData = collect()
            ->concat(array_fill(0, 20, ['status' => 'published']))
            ->concat(array_fill(0, 10, ['status' => 'drafting']))
            ->concat(array_fill(0, 10, ['status' => 'submitted']));

        $publicationData->each(function ($data) use ($users) {
            $publication = Publication::factory()->create($data);

            // Collega a progetti casuali
            $publication->projects()->attach(Project::all()->random(rand(1, 3))->pluck('id'));

            // Autori in ordine di paternità
            $authors = $users->random(rand(1, 4));
            foreach ($authors as $index => $author) {
                $publication->authors()->attach($author->id, ['position' => $index + 1]);
            }

            $publication->attachments()->create(Attachment::factory()->make()->toArray());
        });
    }
}
