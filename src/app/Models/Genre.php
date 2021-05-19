<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'en_title',
        'img',
        'description',
    ];

    /**
     * Movies in this genre
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }

    /**
     * User that added this genre
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Deletes the image file
     */
    public function deleteImage()
    {
        $path = img_upload_dir('/') . $this->img;

        if (is_file($path) && $this->img !== 'default.png') {
            unlink($path);
        }
    }
}
