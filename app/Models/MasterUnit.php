<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MasterUnit extends Model
{
    protected $table = 'master_unit';
    protected $fillable = ['name'];
    public function items() { return $this->hasMany(MasterItem::class, 'unit_id'); }
}