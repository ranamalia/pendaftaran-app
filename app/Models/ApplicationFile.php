<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\ApplicationFileType;

class ApplicationFile extends Model
{
    protected $fillable = [
        'application_id',
        'type',
        'path',
        'original_name',
        'uploaded_by',
    ];

    protected $casts = [
        'type' => ApplicationFileType::class,
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
