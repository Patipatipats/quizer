<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
  
    protected $fillable = ['module_title', 'question_text', 'options', 'correct_answer'];
    
      protected $casts = [
        'options' => 'array',
    ];
}
