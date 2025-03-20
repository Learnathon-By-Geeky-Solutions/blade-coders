<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mailbox extends Model
{
    /** @use HasFactory<\Database\Factories\MailboxFactory> */
    use HasFactory;

    protected $fillable = [
        'subject',
        'read',
        'replied',
    ];

    protected function casts(): array
    {
        return [
            'read' => 'boolean',
            'replied' => 'boolean',
        ];
    }

    public function mailboxItems(): HasMany
    {
        return $this->hasMany(MailboxItem::class, 'mailbox_id');
    }
}
