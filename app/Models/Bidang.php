<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'name'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function usage()
    {
        return $this->hasMany(Usage::class);
    }
}
