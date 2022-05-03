<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'projectid',
        'userid',
        'mission',
        'status',
        'description',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'userid', 'id');
    }
    public function Project()
    {
        return $this->belongsTo(Project::class, 'projectid', 'id');
    }
}
