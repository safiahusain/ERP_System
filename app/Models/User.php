<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'address',
        'role_tag',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_tag', 'tag');
    }

    public function scopeManagers($query)
    {
        $managerTags = Role::getManagerRoleTags();

        return $query->whereIn('role_tag', $managerTags);
    }

    public function scopeClients($query)
    {
        $clientTags = Role::getClientRoleTags();

        return $query->whereIn('role_tag', $clientTags);
    }

    public function scopeTeamMem($query)
    {
        $teamTags = Role::getTeamRoleTags();

        return $query->whereIn('role_tag', $teamTags);
    }

    // User Model mein yeh ek method kaafi hai
    public function isManagerType()
    {
        $roleTag = $this->role_tag; // ya $this->roles->first()->tag

        if ($roleTag === 'manager') {
            return true;
        }

        $role = Role::where('tag', $roleTag)->first();
        return $role && $role->linked_role_tag === 'manager';
    }

    /// User Model mein yeh ek method kaafi hai
    public function isTeamMemberType()
    {
        $roleTag = $this->role_tag; // ya $this->roles->first()->tag

        if ($roleTag === 'team') {
            return true;
        }

        $role = Role::where('tag', $roleTag)->first();
        return $role && $role->linked_role_tag === 'team';
    }
    /**
     * Users jinke yeh user manager hai (team members)
     */
    public function teamMembers()
    {
        return $this->belongsToMany(
            User::class,           // Related model
            'manager_teams',        // Pivot table name
            'manager_id',           // Foreign key for this model in pivot table
            'team_member_id'        // Foreign key for related model in pivot table
        )->withTimestamps();        // Agar pivot table mein timestamps hain to
    }

    /**
     * Users jo is user ke managers hain
     */
    public function TeamManagers()
    {
        return $this->belongsToMany(
            User::class,           // Related model
            'manager_teams',        // Pivot table name
            'team_member_id',       // Foreign key for this model in pivot table
            'manager_id'            // Foreign key for related model in pivot table
        )->withTimestamps();        // Agar pivot table mein timestamps hain to
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    protected static function booted()
    {
        static::saved(function ($user)
        {
            /*
            CLIENT DETAIL HANDLE
            */

            if ($user->role_tag === 'client')
            {
                $user->detail()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'company_name'      => request('company_name'),
                        'company_contact'   => request('company_contact'),
                        'company_address'   => request('company_address'),
                    ]
                );
            }
            else
            {
                $user->detail()->delete();
            }


            /*
            MANAGER TEAM HANDLE
            */

            if ($user->isManagerType() && request()->has('team_member_ids'))
            {
                $user->teamMembers()->sync(request('team_member_ids'));
            }

            /*
            TEAM MEMBER MANAGER HANDLE
            */

            if ($user->isTeamMemberType() && request()->has('manager_ids'))
            {
                $user->teamManagers()->sync(request('manager_ids'));
            }
        });


        /*
        DELETE HANDLING
        */

        static::deleting(function ($user)
        {
            $user->detail()->delete();
            $user->teamMembers()->detach();
            $user->teamManagers()->detach();
        });
    }
}
