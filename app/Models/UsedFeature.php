<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsedFeature extends Model
{
    use HasFactory;
    protected $fillable = [
        "feature_id",
        "credits",
        "user_id",
        'data'
    ];
    public function casts(): array
    {
        return ["data" => 'array'];
    }
    // relation to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // relation to feature
    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
