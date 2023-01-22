<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedLoanRepayments extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'loan_id',
        'status',
    ];

    protected $table = "submitted_loan_repayments";
    protected $primaryKey = "id";
}
