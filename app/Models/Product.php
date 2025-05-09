<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    // Add fillable property
    protected $fillable = [
        'product_name',
        'product_price',
        'product_description',
        'image_url',
        'stock_quantity'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_product', 'product_id', 'ingredient_id');
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }

    /**
     * Get the users who have favorited this product.
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_user_favorites', 'product_id', 'user_id')
                    ->withTimestamps();
    }

    /**
     * Get the categories associated with the product.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'product_category', 'product_id', 'category_id')
                    ->withTimestamps();
    }

    /**
     * Get the tags associated with the product.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ProductTag::class, 'product_tag', 'product_id', 'tag_id')
                    ->withTimestamps();
    }

    /**
     * Get related products based on categories and tags.
     */
    public function getRelatedProducts(int $limit = 4)
    {
        return Product::whereHas('categories', function ($query) {
                $query->whereIn('product_categories.id', $this->categories->pluck('id'));
            })
            ->orWhereHas('tags', function ($query) {
                $query->whereIn('product_tags.id', $this->tags->pluck('id'));
            })
            ->where('id', '!=', $this->id)
            ->limit($limit)
            ->get();
    }

    public function setImage($image)
    {
        if ($image) {
            // Generate a unique filename
            $filename = time() . '_' . $image->getClientOriginalName();
            
            // Move the uploaded file to the products directory
            $image->move(public_path('images/products'), $filename);
            
            // Update the image_url field
            $this->image_url = '/images/products/' . $filename;
            $this->save();
        }
    }

    public function getImageUrlAttribute()
    {
        // If image_url is empty, return a default image
        if (empty($this->image_url)) {
            return '/images/default-product.png';
        }
        
        // If image_url is a full URL, return it as is
        if (filter_var($this->image_url, FILTER_VALIDATE_URL)) {
            return $this->image_url;
        }
        
        // Otherwise, prepend the base URL
        return asset($this->image_url);
    }
}

