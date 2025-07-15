<?php
// app/Models/StockTransactions.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransactions extends Model
{
    protected $table = 'stock_transactions';
    protected $fillable = ['product_id', 'admin_id', 'type', 'quantity', 'note'];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}