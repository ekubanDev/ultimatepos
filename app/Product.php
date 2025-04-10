<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    
    public function product_variations()
    {
        return $this->hasMany('App\ProductVariation');
    }
    
    /**
     * Get the brand associated with the product.
     */
    public function brand()
    {
        return $this->belongsTo('App\Brands');
    }
    
     /**
     * Get the unit associated with the product.
     */
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
    /**
     * Get category associated with the product.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    /**
     * Get sub-category associated with the product.
     */
    public function sub_category()
    {
        return $this->belongsTo('App\Category', 'sub_category_id', 'id');
    }
    
    /**
     * Get the brand associated with the product.
     */
    public function product_tax()
    {
        return $this->belongsTo('App\TaxRate', 'tax', 'id');
    }

    /**
     * Get the variations associated with the product.
     */
    public function variations()
    {
        return $this->hasMany('App\Variation');
    }
}
