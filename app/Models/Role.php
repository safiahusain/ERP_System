<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'tag', 'is_system', 'linked_role_tag'];

    protected $casts = [
        'is_system' => 'boolean',
    ];

    // Users through user_roles (tag based)
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'role_tag', 'user_id', 'tag', 'id');
    }

    // Functionalities through role_functionalities (tag based)
    public function functionalities()
    {
        return $this->belongsToMany(Functionality::class, 'role_functionalities', 'role_tag', 'functionality_id', 'tag', 'id');
    }

    // Linked role relationship
    public function linkedRole()
    {
        return $this->belongsTo(Role::class, 'linked_role_tag', 'tag');
    }

    /**
     * Get all manager-type role tags
     */
    public static function getManagerRoleTags()
    {
        return self::where('tag', 'manager')
            ->orWhere('linked_role_tag', 'manager')
            ->pluck('tag')
            ->toArray();
    }

    /**
     * Get all client-type role tags
     */
    public static function getClientRoleTags()
    {
        return self::where('tag', 'client')
            ->orWhere('linked_role_tag', 'client')
            ->pluck('tag')
            ->toArray();
    }

    /**
     * Get all team-member-type role tags
     */
    public static function getTeamRoleTags()
    {
        return self::where('tag', 'team')
            ->orWhere('linked_role_tag', 'team')
            ->pluck('tag')
            ->toArray();
    }
}
