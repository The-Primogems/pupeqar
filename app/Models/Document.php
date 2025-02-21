<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'filename',
        'submission_id',
        'submission_type'
    ];
 
    public function research() {
        return $this->hasMany(\App\Models\Research::class);
    }
}
