<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use App\Http\Responses\RegisterResponse;

class FortifyServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Fortify::createUsersUsing(CreateNewUser::class);
    VerifyEmail::toMailUsing(function ($notifiable, $url) {
      return (new MailMessage)
        ->subject('メールアドレスを確認してください')
        ->line('以下のボタンをクリックして、メールアドレスの確認を終了させてください。')
        ->action('メールアドレスを確認する', $url)
        ->line('アカウントを作成していない場合は、このメールを破棄してください。');
    });
    ResetPassword::toMailUsing(function ($notifiable, $token) {
      return (new MailMessage)
        ->subject('パスワードのリセット')
        ->line('以下のボタンをクリックして、パスワードリセットを行ってください、')
        ->action('パスワードのリセット', config('app.frontend_url').'/user/reset-password?email='.
          $notifiable->email.'&token='.$token)
        ->line('パスワードのリセットは' .
          config('auth.passwords.' . config('auth.defaults.passwords') . '.expire') .
          '分以内に行ってください。' .
          config('auth.passwords.' . config('auth.defaults.passwords') . '.expire') .
          '分を過ぎると、リンクが無効となります。')
        ->line('パスワードのリセットを要求していない場合は、このメールを破棄してください。');
    });

    Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
    Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
    Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

    RateLimiter::for('login', function (Request $request) {
      $email = (string)$request->email;

      return Limit::perMinute(5)->by($email . $request->ip());
    });

    RateLimiter::for('two-factor', function (Request $request) {
      return Limit::perMinute(5)->by($request->session()->get('login.id'));
    });

    $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
    $this->app->singleton(RegisterResponseContract::class, RegisterResponse::class);
  }
}
