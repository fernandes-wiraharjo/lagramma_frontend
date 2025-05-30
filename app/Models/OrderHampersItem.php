<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;

class OrderHampersItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_detail_id',
        'product_id',
        'product_variant_id',
        'product_name',
        'product_variant_name',
        'quantity',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationships
     */
    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
