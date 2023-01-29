<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'tags',
        'company',
        'logo',
        'location',
        'email',
        'website',
        'description'
    ];

    public function scopeFilter($query, array $filters)
    {

        if ($filters['tag']) {
            return $query->where('tags', 'like', '%' . $filters['tag'] . '%');
        }
        if ($filters['search']) {
            return $query->where('tags', 'like', '%' . $filters['search'] . '%')
                ->orWhere('title', 'like', '%' . $filters['search'] . '%')
                ->orWhere('description', 'like', '%' . $filters['search'] . '%');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
