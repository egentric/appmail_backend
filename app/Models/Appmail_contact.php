<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Filters\BusinessFilter;
use App\Filters\CategoryFilter;

use Illuminate\Database\Eloquent\Builder;

class Appmail_contact extends Model
{
    use HasFactory;
    protected $fillable = ['appmail_contact_firstname', 'appmail_contact_lastname', 'appmail_contact_email', 'appmail_contact_business', 'user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appmail_category()
    {
        //Relation many to many avec appmail_categories
        return $this->belongsToMany('App\Models\Appmail_category');
    }

    public function scopeFilter(Builder $builder, $request)
    {
        return (new BusinessFilter($request))->filter($builder);
    }

    // public function scopeFilter1(Builder $builder, $request)
    // {
    //     return (new CategoryFilter($request))->filter($builder);
    // }
}
