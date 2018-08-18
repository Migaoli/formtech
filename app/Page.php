<?php

namespace App;

use App\Blocks\Block;
use App\Validation\ValidatableModel;
use App\Validation\Validates;
use Illuminate\Validation\Rule;

class Page extends ValidatableModel
{
    use Validates;

    protected $fillable = ['title', 'slug', 'settings'];

    protected $casts = [
        'settings' => 'array'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct(
            array_merge(
                ['slug' => str_slug(array_get($attributes, 'title', ''))],
                $attributes
            ));
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:200',
            'slug' => ['required', 'alpha_dash', 'max:200',
                Rule::unique('pages')->where(function ($query) {
                    $query->where('parent_id', $this->parent_id);
                })],
            'settings' => 'json'
        ];
    }


    public function addSubPage(Page $page)
    {
        $this->subPages()->save($page);
    }

    public function subPages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function addBlock(Block $block)
    {
        $this->blocks()->save($block);
    }

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }

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
