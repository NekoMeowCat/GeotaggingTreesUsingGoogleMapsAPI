<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use BenSampo\Enum\Enum;

class Tree extends Model
{
    use HasFactory;

    const HEALTHY = 'Healthy';
    const DECEASED = 'Diseased';

    protected $fillable = [
        'tree_name',
        'tree_description',
        'tree_status',
        'tree_image',
        'tree_id',
        'date_planted',
        'latitude',
        'longitude', 
        'area_id',
        'classification_id',
        'validated_at',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    // Define the relationship with Classification model (Many-to-One)
    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }
}
