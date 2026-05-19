<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MasterCategory extends Model
{
    protected $table = 'master_category';
    protected $fillable = ['name'];
    public function items() { return $this->hasMany(MasterItem::class, 'category_id'); }
}