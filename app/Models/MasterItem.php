<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MasterItem extends Model
{
    protected $table = 'master_items';
    protected $fillable = ['code','name','category_id','unit_id','stock','min_stock','location','status'];
    public function category() { return $this->belongsTo(MasterCategory::class, 'category_id'); }
    public function unit() { return $this->belongsTo(MasterUnit::class, 'unit_id'); }
    public function transactions() { return $this->hasMany(ItemTransaction::class, 'item_id'); }
    public function isLowStock(): bool { return $this->stock <= $this->min_stock; }
}