<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class EncryptedOrPlainDecimal implements CastsAttributes
{
    protected int $precision;

    public function __construct(int|string $precision = 2)
    {
        $this->precision = (int) $precision;
    }

    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null) {
            return null;
        }

        $resolvedValue = $this->decryptOrPlain((string) $value);

        if (!is_numeric($resolvedValue)) {
            return $resolvedValue;
        }

        return number_format((float) $resolvedValue, $this->precision, '.', '');
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null || $value === '') {
            return null;
        }

        $normalized = is_numeric($value)
            ? number_format((float) $value, $this->precision, '.', '')
            : (string) $value;

        return Crypt::encryptString($normalized);
    }

    protected function decryptOrPlain(string $value): string
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException) {
            // Backward compatibility for legacy plaintext rows.
            return $value;
        }
    }
}
