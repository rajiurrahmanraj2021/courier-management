<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Traits\Notify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	use HasFactory, Notifiable, Notify;

	protected $appends = ['mobile'];

	public function siteNotificational()
	{
		return $this->morphOne(SiteNotification::class, 'siteNotificational', 'site_notificational_type', 'site_notificational_id');
	}

	public function funds()
	{
		return $this->hasMany(Fund::class)->latest()->where('status', '!=', 0);
	}

	public function payouts()
	{
		return $this->hasMany(Payout::class)->latest()->where('status', '==', 2);
	}

	public function profile()
	{
		return $this->hasOne(UserProfile::class, 'user_id', 'id');
	}

	public function getMobileAttribute()
	{
		return optional($this->profile)->phone_code . optional($this->profile)->phone;
	}

	public function profilePicture()
	{
		$filePath = 'assets/upload/userProfile/';
		$fileName = optional($this->profile)->profile_picture ?? 'boy.png';

		if (file_exists($filePath . $fileName)) {
			$url = asset($filePath . $fileName);
		} else {
			$hashEmail = md5(strtolower(trim($this->email)));
			$url = "https://www.gravatar.com/avatar/$hashEmail?s=500&d=mp";
		}
		return $url;
	}

	protected $guarded = ['id'];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function sendPasswordResetNotification($token)
	{
		$this->mail($this, 'PASSWORD_RESET', $params = [
			'message' => '<a href="' . url('password/reset', $token) . '?email=' . $this->email . '" target="_blank">Click To Reset Password</a>'
		]);

		/*
		$this->mail($this, 'PASSWORD_RESET', $params = [
//			'message' => '<a href="'.url('user/password/reset',$token).'" target="_blank">Click To Reset Password</a>',
			'message' => '<a href="'.url('user/password/reset',$token).'?email='.$this->email.'" target="_blank">Click To Reset Password</a>'

		]);

//			'message' => '<a href="'.url('user/password/reset',$token).'?email='.$this->email.'" target="_blank">Click To Reset Password</a>'

		$this->notify(new ResetPasswordNotification($token));
		*/
	}

	public function branch(){
		return $this->hasOne(BranchManager::class, 'admin_id');
	}

}
