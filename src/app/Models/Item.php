<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'item_image_id',
        'condition_id',
        'brand_id',
        'description',
        'sale_price',
        'user_id',
    ];

    public static function getItems()
    {
        $items = Item::with(['condition', 'brand', 'user'])->with(
            'favorites',
            function ($query) {
                $query->where('user_id', Auth::id());
            }
        )->get();

        return $items;
    }

    public function scopeSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                ->orWhereHas('brand', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                })
                    ->orWhereHas('categories', function ($q) use ($keyword) {
                        $q->where('name', 'like', '%' . $keyword . '%')
                        ->orWhereHas('parentCategory', function ($q) use ($keyword) {
                            $q->where('name', 'like', '%' . $keyword . '%');
                        });
                    });
            });
        }
    }

    /**
     * ユーザーとのリレーション (多対1)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * アイテム画像とのリレーション (1対多)
     */
    public function itemImages()
    {
        return $this->hasMany(ItemImage::class);
    }

    /**
     * 状態テーブルとのリレーション (多対1)
     */
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    /**
     * ブランドとのリレーション (多対1)
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * カテゴリとのリレーション (多対多)
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item')
            ->withTimestamps();
    }

    /**
     * コメントとのリレーション (1対多）
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * お気に入りとのリレーション (多対多)
     */
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    /**
     * 購入履歴とのリレーション (1対1)
     */
    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }
}
