<?php

namespace App\Rules;

use App\Station;
use Illuminate\Contracts\Validation\Rule;

class StationExists implements Rule
{
    protected $value;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $this->value = ucfirst($value);

        return (boolean) Station::find($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Station {$this->value} does not exist.";
    }
}
