<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'avatar',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get the role that owns the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Check if the user has any of the given roles.
     */
    public function hasAnyRole(array $roleNames): bool
    {
        return $this->role && in_array($this->role->name, $roleNames);
    }

    /**
     * Check if the user has permission to perform an action.
     */
    public function hasPermission(string $permissionSlug): bool
    {
        return $this->role && $this->role->hasPermission($permissionSlug);
    }

    /**
     * Check if the user has any of the given permissions.
     */
    public function hasAnyPermission(array $permissionSlugs): bool
    {
        return $this->role && $this->role->hasAnyPermission($permissionSlugs);
    }

    /**
     * Check if the user has all of the given permissions.
     */
    public function hasAllPermissions(array $permissionSlugs): bool
    {
        return $this->role && $this->role->hasAllPermissions($permissionSlugs);
    }

    /**
     * Check if the user has staff role.
     */
    public function isStaff(): bool
    {
        return $this->is_admin || ($this->role && in_array($this->role->name, ['admin', 'dj', 'marketing', 'beheer', 'redactie']));
    }

    /**
     * Get the DJ availabilities for the user.
     */
    public function availabilities()
    {
        return $this->hasMany(DjAvailability::class);
    }

    /**
     * Get the DJ assignments for the user.
     */
    public function assignments()
    {
        return $this->hasMany(DjAssignment::class);
    }
public function vacatures()
{
    return $this->hasMany(Vacature::class);
}

}
