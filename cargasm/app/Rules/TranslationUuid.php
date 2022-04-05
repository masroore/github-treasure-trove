<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class TranslationUuid implements Rule
{
    protected $table;

    protected $lang;

    protected $id;

    /**
     * Create a new rule instance.
     */
    public function __construct(string $table, string $lang, $id = null)
    {
        $this->table = $table;
        $this->lang = $lang;
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (empty($value)) {
            return true;
        }

        if (DB::table($this->table)->where($attribute, $value)->exists() === false) {
            return false;
        }

        if (DB::table($this->table)
            ->where($attribute, $value)
            ->where('lang', $this->lang)
            ->where('id', '<>', $this->id)
            ->exists()) {
            return false;
        }

        if (empty($this->id) && DB::table($this->table)
            ->where($attribute, $value)
            ->where('lang', $this->lang)
            ->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
