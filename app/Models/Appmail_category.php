<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appmail_category extends Model
{
    use HasFactory;
    protected $fillable = ['appmail_category_name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appmail_contacts()
    {
        //Relation many to many avec appmail_contact
        return $this->belongsToMany('App\Models\Appmail_contact');
    }
}
