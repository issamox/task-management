<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','user_id','assign_to','project_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function assigned(){
        return $this->belongsTo(User::class,'assign_to');
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    protected $with = ['user','assigned'];


}
