<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use App\Notifications\ResetPassword;

class User extends Authenticatable implements CanResetPassword
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    
    use HasFactory, Notifiable, CanResetPasswordTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'pekerjaan',
        'ktp_no',
        'ktp_foto',
        'alamat',
        'phone',
    ];

    /**
     * get admins with phone number
     * for notifiable wablas
     */
    public function scopeAdmins($query)
    {
        return $query->where('is_admin', 1)
                     ->whereNotNull('phone')
                     ->where('phone', '!=', '');
    }
    
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
     * Phone number normalizator
     */
    public function setPhoneAttribute($value): void
    {
        $phone = (string) $value;

        // remove anything except digits
        $phone = preg_replace('/[^0-9]/', '', $phone) ?? '';

        // convert 0xxxx -> 62xxxx
        if ($phone !== '' && str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        $this->attributes['phone'] = $phone;
    }

    public function permohonans()
    {
        return $this->hasMany(Permohonan::class);
    }

    public function phoneVerification()
    {
        return $this->hasOne(PhoneVerification::class);
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function routeNotificationForWablas(): ?string
    {
        return $this->phone;
    }


}
