<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSeekerProfile extends Model
{
  protected $guarded = [];

  protected $dates = ['date_available'];

  public function job_seeker(){
    return $this->belongsTo(User::class, 'user_id');
  }
}
