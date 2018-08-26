<?php


namespace App\Pages;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Page extends Model
{

    protected $table = 'pages';

    protected $casts = [
        'data' => 'array',
        'parent_id' => 'integer',
    ];

    protected $fillable = ['title', 'slug', 'parent_id', 'data'];

    public function __construct(array $attributes = [])
    {
        $this->data = [];
        parent::__construct($attributes);
        $this->type = \get_class($this);
    }

    public function rules(): array
    {
        return [
            'type' => 'required|in:standard,menu_separator',
            'title' => 'required|string|max:200',
            'slug' => [
                'required',
                'alpha_dash',
                'max:200',
                Rule::unique('pages')
                    ->where(function ($query) {
                        $query->where('parent_id', $this->parent_id);
                    })
                    ->ignore($this->id)
            ],
        ];
    }

    public function addSubPage(Page $page)
    {
        $this->subPages()->save($page);
    }

    public function subPages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Pages::class, 'parent_id');
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