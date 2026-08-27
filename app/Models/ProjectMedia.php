<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMedia extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
