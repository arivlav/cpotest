<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectModel extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectModelFactory> */
    use HasFactory;

    protected $table = 'projects';
}
