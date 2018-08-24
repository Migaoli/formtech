<?php

namespace App\Media;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = ['type', 'name', 'file_path', 'mime_type'];
}
