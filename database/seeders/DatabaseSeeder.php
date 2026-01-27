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
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* 1. CREAZIONE UTENTE AMMINISTRATORE */
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'Admin/PI',
        ]);

        /* 2. CREAZIONE DI ALTRI UTENTI GENERICI */
        $users = User::factory(40)->create();

        /* 3. GENERAZIONE PROGETTI CON LOGICA A CASCATA */
        Project::factory(70)->create()->each(function ($project) use ($users) {

            // Determiniamo se il progetto è completato (basandoci sul tuo factory)
            $isProjectCompleted = ($project->status === 'completed');

            /* CREAZIONE MILESTONE */
            $milestones = Milestone::factory(rand(2, 4))->create([
                'project_id' => $project->id,
                // Se progetto completo -> Milestone completata (1), altrimenti casuale
                'status' => $isProjectCompleted ? '1' : fake()->randomElement(['0', '1'])
            ]);

            /* ASSOCIAZIONE UTENTI AL PROGETTO */
            $projectUsers = $users->random(rand(2, 6));
            foreach ($projectUsers as $user) {
                $project->users()->attach($user->id, [
                    'project_role' => fake()->randomElement(['Project Manager', 'Researcher', 'Collaborator'])
                ]);
            }

            /* CREAZIONE TASK */
            $numberOfTasks = rand(3, 8);
            for ($i = 0; $i < $numberOfTasks; $i++) {

                // Selezioniamo una milestone casuale tra quelle del progetto
                $selectedMilestone = $milestones->random();

                // Logica: se il progetto è completo OPPURE la milestone è completa, il task DEVE essere completed
                $mustBeCompleted = ($isProjectCompleted || $selectedMilestone->status === '1');

                $task = Task::factory()->create([
                    'project_id' => $project->id,
                    'user_id' => $projectUsers->random()->id,
                    'milestone_id' => $selectedMilestone->id,
                    'status' => $mustBeCompleted ? 'completed' : fake()->randomElement(['to_do', 'in_progress', 'completed'])
                ]);

                /* COMMENTI AI TASK */
                Comment::factory(rand(1, 4))->create([
                    'task_id' => $task->id,
                    'user_id' => $projectUsers->random()->id,
                ]);
            }

            /* ALLEGATI AL PROGETTO (Polimorfica) */
            $project->attachments()->createMany(
                Attachment::factory(2)->make()->toArray()
            );
        });

        /* 4. GENERAZIONE PUBBLICAZIONI */
        $totalPublished = 20;
        $totalDrafts = 10;
        $totalSubmi = 10;

        $publicationData = collect()
            ->concat(array_fill(0, $totalPublished, ['status' => 'published']))
            ->concat(array_fill(0, $totalDrafts, ['status' => 'drafting']))
            ->concat(array_fill(0, $totalSubmi, ['status' => 'submitted']));

        $publicationData->each(function ($data) use ($users) {
            $publication = Publication::factory()->create($data);

            /* Collega a progetti esistenti */
            $publication->projects()->attach(
                Project::all()->random(rand(1, 5))->pluck('id')
            );

            /* Aggiunge autori */
            $authors = $users->random(rand(1, 6));
            foreach ($authors as $index => $author) {
                $publication->authors()->attach($author->id, [
                    'position' => $index + 1
                ]);
            }

            /* Allegati pubblicazione */
            $publication->attachments()->create(
                Attachment::factory()->make()->toArray()
            );
        });
    }
}
