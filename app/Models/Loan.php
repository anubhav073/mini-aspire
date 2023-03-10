<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'user_id',
        'loan_term',
        'is_approved',
        'status',
    ];

    protected $table = "loan";
    protected $primaryKey = "id";
}
