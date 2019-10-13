<?php

namespace App;

use Storage;
use Bkwld\Cloner\Cloneable;
// use Sofa\Eloquence\Eloquence;
// use App\Traits\Media;

use Illuminate\Database\Eloquent\Model;

class bahan_baku extends Model
{
    use Cloneable;
    protected $table = 'bahan_bakus';
    protected $fillable = ['company_id', 'nama', 'jenis', 'description', 'sale_price', 'purchase_price', 'quantity', 'category_id', 'tax_id', 'enabled'];

    /**
     * Sortable columns.
     *
     * @var array
     */
    protected $sortable = ['name', 'jenis', 'quantity', 'sale_price', 'purchase_price', 'enabled'];
    protected $searchableColumns = [
        'nama'        => 10,
        'jenis'         => 5,
        'description' => 2,
    ];
    public function scopeAutocomplete($query, $filter)
    {
        return $query->where(function ($query) use ($filter) {
            foreach ($filter as $key => $value) {
                $query->orWhere($key, 'LIKE', "%" . $value  . "%");
            }
        });
    }
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function monitoring()
    {
        return $this->hasOne('App\Monitoring', 'id');
    }
    public function ukuran()
    {
        return $this->hasOne('App\Ukuranbahan', 'id');
    }
    public function produk()
    {
        return $this->hasOne('App\Ukuranbahan', 'id');
    }

    // protected $table = 'bahan_bakus';
}
