<?php

namespace App\Models;

use App\Casts\EncryptedOrPlainDecimal;
use App\Casts\EncryptedOrPlainString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    protected $fillable = ['source_name', 'amount', 'date'];

    protected function casts(): array
    {
        return [
            'source_name' => EncryptedOrPlainString::class,
            'amount' => EncryptedOrPlainDecimal::class . ':2',
            'date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
