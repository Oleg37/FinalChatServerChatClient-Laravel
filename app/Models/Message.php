<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 * @method static find(int $id)
 */
class Message extends Model {
    use HasFactory;

    protected $table = 'message';
    public $timestamps = false;
    protected $fillable = ['userMessage', 'userSend', 'userReceiver', 'messageDate'];
}
