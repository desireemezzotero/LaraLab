<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Publication;
use App\Models\Milestone;
use App\Models\Task;
use App\Models\Attachment;
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
        $users = User::factory(10)->create();

        /*  GENERAZIONE PROGETTI CON RELATIVE MILESTONE E ALLEGATI */
        Project::factory(5)->create()->each(function ($project) use ($users) {

            /* Crea 3 milestone per ogni progetto */
            $milestones = Milestone::factory(3)->create(['project_id' => $project->id]);

            /* Associa casualmente da 2 a 4 utenti al progetto tramite tabella pivot */
            $projectUsers = $users->random(rand(2, 4));
            foreach ($projectUsers as $user) {
                $project->users()->attach($user->id, [
                    'project_role' => fake()->randomElement(['Project Manager', 'Researcher', 'Collaborator'])
                ]);
            }

            /* Crea 8 task assegnati agli utenti del progetto e collegati alle milestone */
            Task::factory(8)->create([
                'project_id' => $project->id,
                'user_id' => $projectUsers->random()->id,
                'milestone_id' => $milestones->random()->id,
            ]);

            /* RELAZIONE POLIMORFICA: Aggiunge 2 documenti tecnici al progetto */
            $project->attachments()->createMany(
                Attachment::factory(2)->make()->toArray()
            );
        });

        /* 4. GENERAZIONE PUBBLICAZIONI CON AUTORI E ALLEGATI PDF */
        Publication::factory(10)->create()->each(function ($publication) use ($users) {

            /* Collega la pubblicazione a 1 o 2 progetti esistenti (Relazione N:N) */
            $publication->projects()->attach(Project::all()->random(rand(1, 2))->pluck('id'));

            /* Aggiunge autori gestendo la colonna 'position' per l'ordine di paternità */
            $authors = $users->random(rand(1, 3));
            foreach ($authors as $index => $author) {
                $publication->authors()->attach($author->id, [
                    'position' => $index + 1
                ]);
            }

            /* RELAZIONE POLIMORFICA: Aggiunge il file PDF della pubblicazione scientifica */
            $publication->attachments()->create(
                Attachment::factory()->make()->toArray()
            );
        });
    }
}
