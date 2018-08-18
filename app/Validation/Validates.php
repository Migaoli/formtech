<?php


namespace App\Validation;


use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

trait Validates
{
    /**
     * Returns the data that should be validated.
     *
     * @return array
     */
    abstract protected function getData(): array;

    /**
     * Returns the rules used for validating the data.
     *
     * @return array
     */
    abstract public function rules(): array;

    /**
     * Override validation messages.
     *
     * @return array
     */
    protected function getMessages(): array
    {
        return [];
    }


    /**
     * Creates a new @see Validator factory.
     *
     * @return Factory
     */
    private function getValidatorFactory(): Factory
    {
        return Container::getInstance()->make(Factory::class);
    }

    /**
     * Create a new @see Validator with the data, rules and messages.
     *
     * @return Validator
     */
    private function getValidator(): Validator
    {
        return $this
            ->getValidatorFactory()
            ->make(
                $this->getData(),
                $this->rules(),
                $this->getMessages()
            );
    }

    /**
     * Check if the data is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return !$this->isInvalid();
    }

    /**
     * Check if the data is invalid.
     *
     * @return bool
     */
    public function isInvalid(): bool
    {
        return $this->getValidator()->fails();
    }

    /**
     * Validate data
     *
     * @throws ValidationException Thrown if the data fails the validation
     */
    public function validate(): void
    {
        $validator = $this->getValidator();

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * Get all validation error messages.
     *
     * @return MessageBag
     */
    public function errors(): MessageBag
    {
        return $this->getValidator()->errors();
    }
}