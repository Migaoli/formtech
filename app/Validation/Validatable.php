<?php


namespace App\Validation;


use Illuminate\Support\MessageBag;

/**
 * Interface Validatable
 * @package App\Validation
 */
interface Validatable
{

    /**
     * @return bool
     */
    public function isValid(): bool;

    /**
     * @return bool
     */
    public function isInvalid(): bool;

    /**
     * @return array
     */
    public function rules(): array;

    /**
     * @return mixed
     */
    public function validate();

    /**
     * @return MessageBag
     */
    public function errors(): MessageBag;
}