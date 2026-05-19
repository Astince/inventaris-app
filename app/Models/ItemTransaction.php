<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ItemTransaction extends Model
{
    protected $table = 'item_transactions';
    protected $fillable = ['item_id','transaction_type','qty','date','source','note','stock_before','stock_after','created_by'];
    protected $casts = ['date' => 'date'];
    public function item() { return $this->belongsTo(MasterItem::class, 'item_id'); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}