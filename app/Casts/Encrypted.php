<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Encryption\DecryptException;

class Encrypted implements CastsAttributes
{
    /**
     * Decrypts the given value.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     *
     * @return string|null
     */
    public function get($model, $key, $value, $attributes)
    {
        if (blank($value)) {
            return null;
        }

        try {
            return decrypt($value);
        } catch (DecryptException $e) {
            // it's possible that the decryption fails, for example  when API_KEys
            //  have been rotated/changed, we will just return null so that the user
            //  can resubmit a token
            return null;
        }
    }

    /**
     * Encrypts the given value
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param array $value
     * @param array $attributes
     *
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        // we most probably don't want to encrypt null values
        return transform($value, 'encrypt');
    }
}
