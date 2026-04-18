<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'client_id',
        'project_id',
        'invoice_number',
        'total',
        'paid',
        'due',
        'status',
        'due_date',
        'description'
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function updateStatus()
    {
        if ($this->paid >= $this->total) {
            $this->status = 'paid';
        } elseif ($this->paid > 0) {
            $this->status = 'partial';
        } else {
            $this->status = 'unpaid';
        }

        $this->due = $this->total - $this->paid;
        $this->save();
    }
}
