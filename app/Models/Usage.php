<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'room_id',
        'bidang_id',
        'date',
        'start',
        'end'
    ];

    protected $casts = [
        'date' => 'date',
    ];
    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
