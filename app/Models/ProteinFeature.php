<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProteinFeature extends Model
{
    public function feature()
    {
        return $this->belongsTo('App\Models\FeatureDefinition', 'feature_id', 'id');
    }
}
