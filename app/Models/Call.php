<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        // you can use App\Contact but you have to import it at the top with " use "
        return $this->belongsTo(User::class, 'representative_id', 'representative_id');
    }
}
