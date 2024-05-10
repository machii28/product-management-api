<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const TRANSACTION_PURCHASE = 'purchase';
    const TRANSACTION_RETURN = 'return';

    protected $table = 'transaction_logs';
}
