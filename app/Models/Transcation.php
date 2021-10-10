<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transcation extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref_no', 'trx_id', 'user_id', 'type', 'amount', 'source_id', 'description',
    ];

    public function source_user(){
        return $this->belongsTo(User::class,'source_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
