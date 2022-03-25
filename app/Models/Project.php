<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'users',
        'programming_languages',
        'document_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
