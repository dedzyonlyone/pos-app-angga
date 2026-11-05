<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_number','user_id','customer_id','sale_date','subtotal','discount',
        'total','payment_method','paid_amount','change_amount','status','note'
    ];
    protected $casts = ['sale_date' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function customer() { return $this->belongsTo(Customer::class); }
    public function items() { return $this->hasMany(SaleItem::class); }
}