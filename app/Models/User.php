<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;

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
        'nama',
        'email',
        'password',
        'role',
        'status',
        'foto',
        'no_hp'
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
        ];
    }

    /**
     * Accessor Email dengan penanganan dekripsi aman (backward compatible untuk data lama).
     */
    public function getEmailAttribute($value)
    {
        if (empty($value)) return $value;
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    /**
     * Mutator Email untuk enkripsi data baru.
     */
    public function setEmailAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['email'] = $value;
        } else {
            $this->attributes['email'] = Crypt::encryptString($value);
        }
    }

    /**
     * Accessor No HP dengan penanganan dekripsi aman.
     */
    public function getNoHpAttribute($value)
    {
        if (empty($value)) return $value;
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    /**
     * Mutator No HP untuk enkripsi data baru.
     */
    public function setNoHpAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['no_hp'] = $value;
        } else {
            $this->attributes['no_hp'] = Crypt::encryptString($value);
        }
    }

    public function appNotifications()
    {
        return $this->hasMany(AppNotification::class);
    }
}
