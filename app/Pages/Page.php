<?php


namespace App\Pages;


use App\Fields\Checkbox;
use App\Fields\Row;
use App\Fields\Slug;
use App\Fields\TextWithSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Page extends Model
{

    protected $table = 'pages';

    protected $casts = [
        'data' => 'array',
        'parent_id' => 'integer',
        'order' => 'integer',
        'in_menu' => 'boolean',
        'published' => 'boolean'
    ];

    protected $fillable = ['title', 'slug', 'parent_id', 'data', 'in_menu', 'published'];

    public function __construct(array $attributes = [])
    {
        $this->data = [];
        parent::__construct($attributes);
        $this->type = \get_class($this);
    }

    public function fields(): array
    {
        return [
            new Row([
                TextWithSlug::make('Title')
                    ->slug('slug')
                    ->rules(['required', 'max:200']),

                Slug::make('Slug')
                    ->rules([
                        'required',
                        'max:200',
                        Rule::unique('pages')
                            ->where(function ($query) {
                                $query->where('parent_id', $this->parent_id);
                            })
                            ->ignore($this->id)
                    ]),
            ]),

            new Row([
                Checkbox::make('Show in menu', 'in_menu')
                    ->rules(['required'])
                    ->defaultTo(true),

                Checkbox::make('Published', 'published')
                    ->rules(['required'])
                    ->defaultTo(false),
            ])
        ];
    }

    public function rules(): array
    {
        return collect($this->fields())
            ->flatMap(function ($field) {
                return $field->createValidationRules();
            })
            ->merge([
                'title' => 'required|string',
                'slug' => ['required', 'alpha_dash',],
                'in_menu' => ['required', 'boolean'],
                'published' => ['required', 'boolean'],
            ])
            ->toArray();
    }

    public function getData(string $key = null, $default = null)
    {
        $data = $this->data;

        if ($key === null) {
            return $data;
        }

        return data_get($data, $key, $default);
    }

    public function addSubPage(Page $page)
    {
        $this->subPages()->save($page);
    }

    public function subPages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public static function tree()
    {
        $elements = Page::all()->toArray();
        return static::buildTree($elements, null);
    }

    private static function buildTree(array &$elements, $parentId = 0): array
    {
        $branch = array();

        foreach ($elements as &$element) {

            if ($element['parent_id'] == $parentId) {
                $children = static::buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['id']] = $element;
                unset($element);
            }
        }
        return $branch;
    }

    public function newFromBuilder($attributes = [], $connection = null)
    {
        $type = $attributes->type;

        /** @var Model $model */
        $model = $model = new $type();

        $model->exists = true;

        $model->setConnection(
            $this->getConnectionName()
        );

        $model->setRawAttributes((array)$attributes, true);

        $model->setConnection($connection ?: $this->getConnectionName());

        $model->fireModelEvent('retrieved', false);

        $model->load($model->with);

        return $model;
    }
}