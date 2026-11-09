<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningHour extends Model
{
    protected $fillable = [
        'day_of_week',
        'day_name',
        'is_closed',
        'open_time_1',
        'close_time_1',
        'open_time_2',
        'close_time_2',
        'note',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_closed' => 'boolean',
            'day_of_week' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function getFormattedHoursAttribute(): string
    {
        if ($this->is_closed) {
            return 'Closed';
        }

        $ranges = [];
        if ($this->open_time_1 && $this->close_time_1) {
            $ranges[] = date('g:i A', strtotime($this->open_time_1)) . ' - ' . date('g:i A', strtotime($this->close_time_1));
        }
        if ($this->open_time_2 && $this->close_time_2) {
            $ranges[] = date('g:i A', strtotime($this->open_time_2)) . ' - ' . date('g:i A', strtotime($this->close_time_2));
        }

        return empty($ranges) ? 'Closed' : implode(', ', $ranges);
    }
}
