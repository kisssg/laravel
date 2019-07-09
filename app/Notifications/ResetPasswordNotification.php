<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Lang;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{

    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Create a new notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback)
        {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }
        return (new MailMessage)
                        ->subject(Lang::getFromJson('Password resetting 重置密码提醒'))
                        ->line(Lang::getFromJson('We\'re receiving your request to reset your password,click below button and follow the instructions.'))
                        ->line(Lang::getFromJson('我们收到您重置密码的请求，请点击以下按钮设置新密码。'))
                        ->action(Lang::getFromJson('设置新密码'), url(config('app.url') . route('password.reset', ['token' => $this->token], false)))
                        ->line(Lang::getFromJson('The request will be expired in :count minutes.', ['count' => config('auth.passwords.users.expire')]))
                        ->line(Lang::getFromJson('链接有效时间为 :count 分钟。', ['count' => config('auth.passwords.users.expire')]))
                        ->line(Lang::getFromJson('If this is not your request, ignore it.'))
                        ->line(Lang::getFromJson('如果您没有申请过重置密码，请忽略此邮件。'));
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }

}
