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

        /* CREAZIONE UTENTE AMMINISTRATORE PER IL LOGIN */
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'Admin/PI',
        ]);

        /* CREAZIONE DI ALTRI UTENTI GENERICI */
        $users = User::factory(40)->create();

        /*  GENERAZIONE PROGETTI CON RELATIVE MILESTONE E ALLEGATI */
        Project::factory(70)->create()->each(function ($project) use ($users) {

            /* Crea 3 milestone per ogni progetto */
            $milestones = Milestone::factory(10)->create(['project_id' => $project->id]);

            /* Associa casualmente da 2 a 4 utenti al progetto tramite tabella pivot */
            $projectUsers = $users->random(rand(2, 6));
            foreach ($projectUsers as $user) {
                $project->users()->attach($user->id, [
                    'project_role' => fake()->randomElement(['Project Manager', 'Researcher', 'Collaborator'])
                ]);
            }

            /* TASK */
            $numberOfTasks = rand(3, 8);
            for ($i = 0; $i < $numberOfTasks; $i++) {
                $task = Task::factory()->create([
                    'project_id' => $project->id,
                    'user_id' => $projectUsers->random()->id,
                    'milestone_id' => $milestones->random()->id,
                ]);

                Comment::factory(rand(1, 4))->create([
                    'task_id' => $task->id,
                    'user_id' => $projectUsers->random()->id,
                ]);
            }
            /* RELAZIONE POLIMORFICA: Aggiunge 2 documenti tecnici al progetto */
            $project->attachments()->createMany(
                Attachment::factory(2)->make()->toArray()
            );
        });

        /* 4. GENERAZIONE PUBBLICAZIONI */

        // Definiamo quanti record vogliamo per tipo
        $totalPublished = 20;
        $totalDrafts = 10;
        $totalSubmi = 10;

        // Creiamo un unico insieme di pubblicazioni mescolando gli stati
        $publicationData = collect()
            ->concat(array_fill(0, $totalPublished, ['status' => 'published']))
            ->concat(array_fill(0, $totalDrafts, ['status' => 'drafting']))
            ->concat(array_fill(0, $totalSubmi, ['status' => 'submitted']));


        $publicationData->each(function ($data) use ($users) {
            // Creiamo la pubblicazione con lo stato specifico (published o drafting)
            $publication = Publication::factory()->create($data);

            /* Collega la pubblicazione a 1 o 2 progetti esistenti (Relazione N:N) */
            $publication->projects()->attach(
                Project::all()->random(rand(1, 5))->pluck('id')
            );

            /* Aggiunge autori con colonna 'position' (Requisito: Ordine di paternità) */
            $authors = $users->random(rand(1, 6));
            foreach ($authors as $index => $author) {
                $publication->authors()->attach($author->id, [
                    'position' => $index + 1
                ]);
            }

            /* RELAZIONE POLIMORFICA: Allegato PDF (Requisito: Upload materiali) */
            $publication->attachments()->create(
                Attachment::factory()->make()->toArray()
            );
        });
    }
}
