<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function trees()
    {
        return $this->hasMany(Tree::class);
    }
}
