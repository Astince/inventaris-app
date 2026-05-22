<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MasterItem extends Model
{
    protected $table = 'master_items';
    protected $fillable = ['code','name','category_id','unit_id','stock','min_stock','location'];

    // Buat prefix dari nama kategori: "Alat Tulis Kantor" → "ATK"
    public static function prefixFromCategory(int $categoryId): string
    {
        $category = \App\Models\MasterCategory::find($categoryId);
        if (!$category) return 'ITM';

        // Ambil huruf pertama setiap kata, maksimal 4 huruf, uppercase
        $words  = preg_split('/\s+/', trim($category->name));
        $prefix = '';
        foreach ($words as $word) {
            $prefix .= strtoupper(substr($word, 0, 1));
        }

        return substr($prefix, 0, 4); // maksimal 4 karakter
    }

    // Generate kode otomatis berdasarkan kategori: ATK-001, ELK-002, dst.
    public static function generateCode(int $categoryId): string
    {
        $prefix = self::prefixFromCategory($categoryId);

        // Cari nomor urut terbesar untuk prefix ini
        $last = self::where('code', 'like', $prefix . '-%')
                    ->orderByRaw('CAST(SUBSTRING(code, ' . (strlen($prefix) + 2) . ') AS UNSIGNED) DESC')
                    ->value('code');

        if (!$last) {
            $num = 1;
        } else {
            $num = (int) substr($last, strlen($prefix) + 1) + 1;
        }

        return $prefix . '-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }
    public function category() { return $this->belongsTo(MasterCategory::class, 'category_id'); }
    public function unit() { return $this->belongsTo(MasterUnit::class, 'unit_id'); }
    public function transactions() { return $this->hasMany(ItemTransaction::class, 'item_id'); }
    public function isLowStock(): bool { return $this->stock <= $this->min_stock; }
}