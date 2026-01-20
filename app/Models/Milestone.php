<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Milestone extends Model
{
    protected $fillable = ['project_id', 'title', 'due_date', 'status'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relazione 1:N - Una milestone può raggruppare più attività (task).
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    use HasFactory;
}
