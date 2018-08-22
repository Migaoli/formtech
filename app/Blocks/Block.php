<?php


namespace App\Blocks;


use App\Fields\Field;
use App\Validation\Validatable;
use Illuminate\Container\Container;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

/**
 * App\Blocks\Block
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $page_id
 * @property string $type
 * @property string $container
 * @property int $position
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Blocks\Block whereContainer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Blocks\Block whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Blocks\Block whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Blocks\Block whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Blocks\Block wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Blocks\Block wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Blocks\Block whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Blocks\Block whereUpdatedAt($value)
 */
class Block extends \Eloquent implements Validatable
{
    protected $table = 'blocks';

    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
        'position' => 'integer',
    ];

    protected $name;

    private $validator;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->type = \get_class($this);
    }

    public function newFromBuilder($attributes = [], $connection = null)
    {

        $type = $attributes->type;

        $model = $model = new $type();

        $model->exists = true;

        $model->setConnection(
            $this->getConnectionName()
        );

        $model->setRawAttributes((array) $attributes, true);

        $model->setConnection($connection ?: $this->getConnectionName());

        $model->fireModelEvent('retrieved', false);

        return $model;
    }


    public function name(): string
    {
        if ($this->name === null) {
            return Str::snake(class_basename($this));
        }

        return $this->name;
    }

    public function fields(): array
    {
        return [];
    }

    public function template(): string
    {
        return '';
    }

    public function data(string $key = null, $default = null)
    {
        $data = $this->getAttribute('data');

        if ($key === null) {
            return $data;
        }

        return data_get($data, $key, $default);
    }

    public function toArray()
    {
        return array_merge(['name' => $this->name()], parent::toArray());
    }


    private function getValidator(): Validator
    {
        if ($this->validator === null) {
            $this->validator = Container::getInstance()
                ->make(Factory::class)
                ->make(
                    $this->data(),
                    $this->createValidationRules()
                );
        }
        return $this->validator;
    }

    private function createValidationRules()
    {
        return collect($this->rules())
            ->flatMap(function (Field $field) {
                return $field->createValidationRules();
            })
            ->toArray();
    }

    public function isValid(): bool
    {
        return !$this->isInvalid();
    }

    public function isInvalid(): bool
    {
        return $this->getValidator()->fails();
    }

    public function rules(): array
    {
        return static::$rules;
    }

    public function validate()
    {
        $validator = $this->getValidator();

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function errors(): MessageBag
    {
        return $this->getValidator()->errors();
    }


}