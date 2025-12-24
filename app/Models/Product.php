<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_id',
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'is_active',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the UMKM that owns the product
     */
    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }

    /**
     * Get the categories for the product
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    /**
     * Get the photos for the product
     */
    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

    /**
     * Get the primary photo
     */
    public function primaryPhoto()
    {
        return $this->photos()->where('is_primary', true)->first();
    }

    /**
     * Format harga to Indonesian Rupiah
     */
    public function getFormattedHargaAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->harga, 0, ',', '.');
    }
}
