<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    public $timestamps = false;


    public function User()
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }
    public function Task()
    {
        return $this->hasMany(Task::class, 'projectid', 'id');
    }
}
