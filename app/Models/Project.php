<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
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

    public function contributor()
    {
        return $this->hasMany(Contributor::class);
    }

    public function like()
    {
        return $this->hasMany(Like::class);
    }
}
