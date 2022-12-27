<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class TravelPayment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'amount',
        'deleted_at'
    ];

    /**
     * @return MorphToMany
     */
    public function approvers()
    {
        return $this->morphToMany(
            User::class,
            'payment',
            'payment_approvals',
            'payment_id',
            'user_id'
        )->withPivot('status', 'deleted_at')->withTimestamps();
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        $sql = 'SELECT id FROM users WHERE type = "APPROVER" EXCEPT (SELECT user_id FROM payment_approvals WHERE payment_type ="App\\\Models\\\TravelPayment" AND status = "APPROVED" AND deleted_at IS NULL AND payment_id = ' . $this->id . ')';
        $result = DB::select($sql);
        return empty($result);
    }
}
