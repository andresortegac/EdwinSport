<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreItem extends Model
{
    protected $table = 'store_items';

    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'currency',
        'purchase_url',
        'image_path',
        'image_url',
        'company_name',
        'company_phone',
        'company_email',
        'company_location',
        'company_website',
        'company_logo_path',
        'company_logo_url',
        'catalog_summary',
        'catalog_images',
        'created_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'catalog_images' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
