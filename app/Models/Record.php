<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class Record extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     * $fillable: array of attributes that are mass assignable
     * $guarded: array of attributes that are not mass assignable
     * REMARK: the save() methode does not pass the guarded attributes!
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Relationship between models
     * hasMany('model', 'foreign_key', 'primary_key'):  method name is lowercase and plural case
     * belongsTo('model', 'foreign_key', 'primary_key')->withDefaults():  method name is lowercase and singular case
     */


    /**
     * Accessors and mutators (method name is the attribute name)
     * get: transform the attribute after it has retrieved from database
     * set: transform the attribute before it is sent to database
     */


    /**
     * Add additional attributes that do not have a corresponding column in your database
     * REMARK: additional attributes are not automatically included to the model!
     *    - add the attributes to the $appends array to include them always to the model
     *    - or append the attributes in runtime with Model::get()->append([])
     */

    protected function genreName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => Genre::find($attributes['genre_id'])->name,
        );
    }

    protected function priceEuro(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>  '€ ' . number_format($attributes['price'], 2),
        );
    }

    protected function cover(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (Storage::disk('public')->exists('covers/' . $attributes['mb_id'] . '.jpg')) {
                    return [
                        'exists' => true,
                        'url' => Storage::url('covers/' . $attributes['mb_id'] . '.jpg'),
                    ];
                } else {
                    return [
                        'exists' => false,
                        'url' => Storage::url('covers/no-cover.png'),
                    ];
                }
            },
        );
    }

    protected $appends = ['genre_name', 'price_euro', 'cover'];


    /**
     * Apply the scope to a given Eloquent query builder
     * prefix the method name with 'scope' e.g. 'scopeIsActive()'
     * Utilize the scope in the controller  Model::is_active()->get();
     */

    public function scopeMaxPrice($query, $price = 100)
    {
        return $query->where('price', '<=', $price);
    }

    public function scopeSearchTitleOrArtist($query, $search)
    {
        return $query->where('title', 'like', "%{$search}%")
            ->orWhere('artist', 'like', "%{$search}%");
    }


    /**
     * Add attributes that should be hidden to the $hidden array
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class)->withDefault();  // a record belongs to a genre
    }
}
