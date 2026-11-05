<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id','sku','name','unit','purchase_price','selling_price',
        'stock','min_stock','image','is_active'
    ];
    protected $casts = ['is_active' => 'boolean'];

    public function category() { return $this->belongsTo(Category::class); }
    public function purchaseItems() { return $this->hasMany(PurchaseItem::class); }
    public function saleItems() { return $this->hasMany(SaleItem::class); }

    public function scopeActive($q) { return $q->where('is_active', true); }
    public function scopeLowStock($q) { return $q->whereColumn('stock', '<=', 'min_stock'); }
}