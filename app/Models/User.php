<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

#[Fillable(['name', 'email', 'password', 'avatar_url', 'timezone', 'is_active'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Roles assigned to this user.
     *
     * Many-to-many via role_user pivot.
     * Supports multiple roles per user (e.g., parent + student).
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user')
            ->withTimestamps();
    }

    /**
     * The student profile for this user.
     *
     * One-to-one: a user with role "student" has exactly one profile.
     */
    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    /**
     * Child student profiles this parent user is linked to.
     *
     * One-to-many via parent_user_id.
     * A parent account can monitor multiple children.
     */
    public function children(): HasMany
    {
        return $this->hasMany(StudentProfile::class, 'parent_user_id');
    }

    /**
     * Assessment results this admin has manually overridden.
     *
     * One-to-many: tracks which admin corrected which AI evaluation.
     */
    public function overriddenAssessmentResults(): HasMany
    {
        return $this->hasMany(AssessmentResult::class, 'overridden_by');
    }

    /**
     * Submission evaluations this admin has manually overridden.
     *
     * One-to-many: tracks admin corrections to AI essay evaluations.
     */
    public function overriddenEvaluations(): HasMany
    {
        return $this->hasMany(SubmissionEvaluation::class, 'overridden_by');
    }

    /**
     * AI interactions triggered by this user.
     *
     * One-to-many: nullable — most AI calls are system-triggered on behalf
     * of a student, not directly by a user action.
     */
    public function aiInteractionLogs(): HasMany
    {
        return $this->hasMany(AiInteractionLog::class);
    }

    /**
     * Notifications sent to this user.
     *
     * One-to-many: all in-app and email notification records.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * The subscription for this user.
     *
     * One-to-one: each user has one subscription record (free/pro/premium).
     */
    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    /**
     * Content versions changed by this admin user.
     *
     * One-to-many: audit trail of content edits.
     */
    public function contentVersions(): HasMany
    {
        return $this->hasMany(ContentVersion::class, 'changed_by');
    }
}
