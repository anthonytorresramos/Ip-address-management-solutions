<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpManagement extends Model
{
    use HasFactory;

    protected $table = 'ip_management';

    protected $fillable = [
        'mac_address',
        'label',
        'user_id',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function audits()
    {
        return $this->hasMany(Audit::class);
    }
}
