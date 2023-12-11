<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'original_name',
        'path',
        'size',
        'attachmentable_id',
        'attachmentable_type',
    ];

    public function attachmentable(): MorphTo
    {
        return $this->morphTo();
    }
}
