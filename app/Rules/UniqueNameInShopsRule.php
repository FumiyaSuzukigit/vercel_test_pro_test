<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Shop;

class UniqueNameInShopsRule implements Rule
{
    public function passes($attribute, $value)
    {
        return !Shop::where('name', $value)->exists();
    }

    public function message()
    {
        return 'この店舗名は既に存在します。';
    }
}
