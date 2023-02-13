<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $headers
 * @property string $status
 * @property string $sleeps_until
 * @property string $created_at
 */
class Worker extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = ['login', 'password', 'headers'];
}
