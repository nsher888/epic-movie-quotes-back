<?php

namespace App\Notifications;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
	use Queueable;

	use Notifiable;

	public static $createUrlCallback;

	public static $toMailCallback;

	public function via($notifiable): array
	{
		return ['mail'];
	}

	public function toMail($notifiable): MailMessage
	{
		$verificationUrl = $this->verificationUrl($notifiable);

		return $this->buildMailMessage($verificationUrl);
	}

	private function buildMailMessage($url): MailMessage
	{
		return (new MailMessage)
		   ->subject(Lang::get('Verify Email Address'))
		   ->view('verify', ['url' => $url]);
	}

	private function verificationUrl($notifiable): string
	{
		$user = User::find($notifiable->id);
		if ($user)
		{
			return URL::temporarySignedRoute(
				'verification.verify',
				Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
				[
					'locale'   => app()->getLocale(),
					'id'       => $user->getKey(),
					'hash'     => sha1($user->getEmailForVerification()),
				]
			);
		}
	}
}
