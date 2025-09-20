<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected static function booted()
    {
        static::saving(function ($invoice) {
            if ($invoice->relationLoaded('items')) {
                $invoice->total = $invoice->items->sum('subtotal');
            }
        });
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'title',
        'description',
        'subtotal'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
