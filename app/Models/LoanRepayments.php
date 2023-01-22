<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRepayments extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'loan_id',
        'due_date',
        'status',
    ];

    protected $table = "loan_repayments";
    protected $primaryKey = "id";
}
