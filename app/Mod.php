<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
// use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Mod extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    public $table = 'mods';

    // protected $appends = [
    //     'logo',
    // ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'platform',
        'app_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'filepath',
        'filename',
        'modimage',
        'modsliderimages',
    ];

    protected $casts = [
        'modsliderimages' => 'json'
    ];
    

    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this->addMediaConversion('thumb')->width(50)->height(50);
    // }

    public function app()
    {
        return $this->belongsTo(App::class, 'app_id');
    }

    


}
