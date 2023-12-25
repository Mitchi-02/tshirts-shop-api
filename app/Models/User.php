<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Mail\EmailVerificationMail;
use App\Mail\OrderCreatedMail;
use App\Mail\ResetPasswordMail;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
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
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];


    public function orders(){
        return $this->hasMany(Order::class);
    }

    

    public function SendEmailVerificationCode()
    {
        $code = rand(10000, 99999);
        $this->verification_code = $code;
        $this->save();
        Mail::to($this)->send(new EmailVerificationMail($code));

        return $code;
    }

    public function SendResetPasswordCode()
    {
        $code = rand(10000, 99999);
        $this->verification_code = $code;
        $this->save();
        Mail::to($this)->send(new ResetPasswordMail($code));

        return $code;
    }

    public function sendOrderCreatedMail($order)
    {
        Mail::to($this)->send(new OrderCreatedMail($order));
        return;
    }

    public function renderVerified()
    {
        $this->email_verified_at = Carbon::now();
        $this->save();
        return;
    }
}
