<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'assignment_name',
        'grade',
        'max_grade',
        'comments',
    ];

    protected $casts = [
        'grade' => 'decimal:2',
        'max_grade' => 'decimal:2',
    ];

    // Relationships
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // Helper methods
    public function getPercentageAttribute(): float
    {
        if ($this->max_grade > 0) {
            return round(($this->grade / $this->max_grade) * 100, 2);
        }
        return 0;
    }

    public function getLetterGradeAttribute(): string
    {
        $percentage = $this->percentage;
        
        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'F';
    }
}