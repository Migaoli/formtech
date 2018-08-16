<?php

namespace App;

use App\Validation\ValidatableModel;
use App\Validation\Validates;

class Page extends ValidatableModel
{
    use Validates;

    protected $fillable = ['title', 'slug', 'settings'];

    protected $casts = [
        'settings' => 'array'
    ];

    protected $rules = [
        'title' => 'required|string|max:200',
        'slug' => 'required|alpha_dash|max:200',
        'settings' => 'json'
    ];

    public function title(): string
    {
        return $this->title;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function settings(): array
    {
        return $this->settings;
    }

}
