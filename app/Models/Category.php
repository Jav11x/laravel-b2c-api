<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Category: entidad simple con relación 1:N a Product.
 */

class Category extends Model
{
    use HasFactory;

    /** Campos asignables en masa desde Request. */
    protected $fillable = ['name'];


    /** Relación: una categoría tiene muchos productos. */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
