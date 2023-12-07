<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Image extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'page_id',
        'path_local',
        'path_local_thumbnail',
        'path_external',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:m/d/Y',
        'updated_at' => 'datetime:m/d/Y',
    ];

        /**
     * Get the phone associated with the user.
     */
    public function page(): hasMany
    {
        return $this->hasMany(Page::class,'id','page_id');
    }
}
