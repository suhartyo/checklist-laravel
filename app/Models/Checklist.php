<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'checklists';

    protected $casts = [
        'is_completed' => 'boolean'
    ];

    protected $fillable = [
        'object_domain',
        'object_id',
        'task_id',
        'due',
        'urgency',
        'description',
        'is_completed',
        'completed_at',
        'created_by',
        'last_update_by',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
