<?php

namespace app\models;

class Idea extends Model
{
    public $text;
    public $likes;
    public $dislikes;
    public $created_at;

    protected static $table = 'ideas';
    protected static $fillable = [
        'id',
        'text',
        'likes',
        'dislikes',
        'created_at'
    ];

    public function like()
    {
        $this->likes += 1;
        $this->save();
    }

    public function dislike()
    {
        $this->dislikes += 1;
        $this->save();
    }
}
