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
    const FOR_REPLACEMENT = 'For Replacement';

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
        'beneficiary',
    ];

    protected $casts = [
        'area_id' => 'integer',
        'classification_id' => 'integer',
        'date_planted' => 'date',
        'latitude' => 'float',
        'longitude' => 'float',
    ];


    public function getLocationAttribute()
    {
        return [
            'lat' => $this->latitude,
            'lng' => $this->longitude,
        ];
    }

    // Define the 'setLocationAttribute' method
    public function setLocationAttribute(?array $location): void
    {
        if (is_array($location)) {
            $this->attributes['latitude'] = $location['lat'];
            $this->attributes['longitude'] = $location['lng'];
            unset($this->attributes['location']);
        }
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_id');
    }
}
