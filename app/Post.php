<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //table name, by default table name is Post(model), to change the name, follow below
    protected $table='posts';//in'', can put any table name
    //primary key
    public $primaryKey='id';//in''can change to anything such as item_id,need to specify here
    //timestamps,for references
    public $timestamps=true;
//a post has a relatonship with a user and has the link with user
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
