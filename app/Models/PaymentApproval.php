<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *  Model created for testing purposes, used in DatabaseSeeder
 *
 * Class PaymentApproval
 * @package App\Models
 */

class PaymentApproval extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
}
