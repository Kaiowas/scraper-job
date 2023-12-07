<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Page extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'namePage',
        'url'
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
     * Get the user that owns the phone.
     */
    public function images(): hasMany
    {
        return $this->hasMany(Image::class,'page_id');
    }
    public function imagesBK(): BelongsTo
    {
        return $this->belongsTo(Image::class,'id','page_id');
    }
}
