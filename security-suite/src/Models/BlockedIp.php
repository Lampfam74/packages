<?php

namespace Lampedev\SecuritySuite\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedIp extends Model
{
    protected $fillable = ['ip'];
}