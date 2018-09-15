<?php

namespace App\Pages\Blocks\Rules;

use App\Pages\Blocks\Blocks;
use Illuminate\Contracts\Validation\Rule;

class ValidBlockType implements Rule
{
    /**
     * @var Blocks
     */
    private $blocks;

    /**
     * Create a new rule instance.
     *
     * @param Blocks $blocks
     */
    public function __construct(Blocks $blocks)
    {
        $this->blocks = $blocks;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->blocks->isRegistered($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is not a registered block type.';
    }
}
