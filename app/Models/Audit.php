<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_management_id',
        'user_id',
        'action',
        'label',
        'created_at',
    ];

    public $timestamps = false;

    public function ipManagement()
    {
        return $this->belongsTo(IpManagement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
