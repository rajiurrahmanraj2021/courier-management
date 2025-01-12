<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class BasicControlController extends Controller
{
	public function pusherConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.pusherConfig', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());
			$validator = Validator::make($purifiedData, [
				'pusher_app_id' => 'required|integer|not_in:0',
				'pusher_app_key' => 'required|string|min:1',
				'pusher_app_secret' => 'required|string|min:1',
				'pusher_app_cluster' => 'required|string|min:1',
				'push_notification' => 'nullable|integer|min:0|in:0,1',
			]);
			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$envPath = base_path('.env');
			$env = file($envPath);
			$env = $this->set('PUSHER_APP_ID', $purifiedData->pusher_app_id, $env);
			$env = $this->set('PUSHER_APP_KEY', $purifiedData->pusher_app_key, $env);
			$env = $this->set('PUSHER_APP_SECRET', $purifiedData->pusher_app_secret, $env);
			$env = $this->set('PUSHER_APP_CLUSTER', $purifiedData->pusher_app_cluster, $env);

			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);

			$basicControl->push_notification = $purifiedData->push_notification;
			$basicControl->save();

			return back()->with('success', 'Configuration Changes Successfully');
		}
	}

	public function emailConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.emailConfig', compact('basicControl'));
		} else {
			$purifiedData = Purify::clean($request->all());

			$validateFor = [
				'mail_host' => 'required|string|min:5',
				'mail_port' => 'required|integer|not_in:0',
				'mail_username' => 'required|string|min:5',
				'mail_password' => 'required|string|min:5',
				'mail_from' => 'required|string|email',
				'email_notification' => 'nullable|integer|min:0|in:0,1',
				'email_verification' => 'nullable|integer|min:0|in:0,1',
			];
			$validator = Validator::make($purifiedData, $validateFor);
			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}


			$purifiedData = (object)$purifiedData;
			$basicControl->email_notification = $purifiedData->email_notification;
			$basicControl->email_verification = $purifiedData->email_verification;
			$basicControl->save();

			$envPath = base_path('.env');
			$env = file($envPath);

			$env = $this->set('MAIL_MAILER', '"smtp"', $env);
			$env = $this->set('MAIL_HOST', '"' . $purifiedData->mail_host . '"', $env);
			$env = $this->set('MAIL_PORT', '"' . $purifiedData->mail_port . '"', $env);
			$env = $this->set('MAIL_USERNAME', '"' . $purifiedData->mail_username . '"', $env);
			$env = $this->set('MAIL_PASSWORD', '"' . $purifiedData->mail_password . '"', $env);
			$env = $this->set('MAIL_FROM_ADDRESS', '"' . $purifiedData->mail_from . '"', $env);
			$env = $this->set('MAIL_ENCRYPTION', '"' . $purifiedData->mail_encryption . '"', $env);

			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);


			$emailtemplates = EmailTemplate::get();
			foreach ($emailtemplates as $emailtemplate) {
				$emailtemplate->email_from = $purifiedData->mail_from;
				$emailtemplate->save();
			}


			return back()->with('success', 'Successfully Updated');
		}
	}

	private function set($key, $value, $env)
	{
		foreach ($env as $env_key => $env_value) {
			$entry = explode("=", $env_value, 2);
			if ($entry[0] == $key) {
				$env[$env_key] = $key . "=" . $value . "\n";
			} else {
				$env[$env_key] = $env_value;
			}
		}
		return $env;
	}

	public function index($settings = null)
	{
		$settings = $settings ?? 'settings';
		abort_if(!in_array($settings, array_keys(config('generalsettings'))), 404);
		$settingsDetails = config("generalsettings.{$settings}");
		return view('admin.control_panel.settings', compact('settings', 'settingsDetails'));
	}

	public function basic_control(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			$data['allCountries'] = Country::where('status', 1)->get();
			return view('admin.control_panel.basic-control', $data, compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());
			$validator = Validator::make($purifiedData, [
				'site_title' => 'required|min:3',
				'operator_country' => 'required|exists:countries,id',
				'base_currency' => 'required',
				'currency_symbol' => 'required',
				'time_zone' => 'required',
				'fraction_number' => 'required|integer',
				'paginate' => 'required|integer',
				'primaryColor' => 'required',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}

			$purifiedData = (object)$purifiedData;

			$basicControl->site_title = $purifiedData->site_title;
			$basicControl->primaryColor = $purifiedData->primaryColor;
			$basicControl->secondaryColor = $purifiedData->secondaryColor;
			$basicControl->time_zone = $purifiedData->time_zone;
			$basicControl->operator_country = $purifiedData->operator_country;
			$basicControl->base_currency = $purifiedData->base_currency;
			$basicControl->currency_symbol = $purifiedData->currency_symbol;
			$basicControl->fraction_number = $purifiedData->fraction_number;
			$basicControl->paginate = $purifiedData->paginate;
			$basicControl->error_log = $purifiedData->error_log;
			$basicControl->strong_password = $purifiedData->strong_password;
			$basicControl->registration = $purifiedData->registration;
			$basicControl->is_active_cron_notification = $purifiedData->is_active_cron_notification;
			$basicControl->refund_time = $purifiedData->refund_time;
			$basicControl->save();

			config(['basic.site_title' => $basicControl->site_title]);
			config(['basic.primaryColor' => $basicControl->primaryColor]);
			config(['basic.secondaryColor' => $basicControl->secondaryColor]);
			config(['basic.time_zone' => $basicControl->time_zone]);
			config(['basic.operator_country' => $basicControl->operator_country]);
			config(['basic.base_currency' => $basicControl->base_currency]);
			config(['basic.currency_symbol' => $basicControl->currency_symbol]);
			config(['basic.fraction_number' => (int)$basicControl->fraction_number]);
			config(['basic.paginate' => (int)$basicControl->paginate]);

			config(['basic.error_log' => (int)$basicControl->error_log]);
			config(['basic.strong_password' => (int)$basicControl->strong_password]);
			config(['basic.registration' => (int)$basicControl->registration]);
			config(['basic.is_active_cron_notification' => (int)$basicControl->is_active_cron_notification]);
			config(['basic.refund_time' => $basicControl->refund_time]);

			$fp = fopen(base_path() . '/config/basic.php', 'w');
			fwrite($fp, '<?php return ' . var_export(config('basic'), true) . ';');
			fclose($fp);

			$envPath = base_path('.env');
			$env = file($envPath);
			$env = $this->set('APP_DEBUG', ($basicControl->error_log == 1) ? 'true' : 'false', $env);
			$env = $this->set('APP_TIMEZONE', '"' . $purifiedData->time_zone . '"', $env);

			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);

			session()->flash('success', ' Updated Successfully');
			Artisan::call('optimize:clear');
			return back();
		}
	}

	public function pluginConfig()
	{
		return view('admin.control_panel.pluginConfig');
	}

	public function tawkConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.tawkControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'tawk_id' => 'required|min:3',
				'tawk_status' => 'nullable|integer|min:0|in:0,1',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$basicControl->tawk_id = $purifiedData->tawk_id;
			$basicControl->tawk_status = $purifiedData->tawk_status;
			$basicControl->save();

			return back()->with('success', 'Successfully Updated');
		}
	}

	public function fbMessengerConfig(Request $request)
	{
		$basicControl = basicControl();

		if ($request->isMethod('get')) {
			return view('admin.control_panel.fbMessengerControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'fb_messenger_status' => 'nullable|integer|min:0|in:0,1',
				'fb_app_id' => 'required|min:3',
				'fb_page_id' => 'required|min:3',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$basicControl->fb_app_id = $purifiedData->fb_app_id;
			$basicControl->fb_page_id = $purifiedData->fb_page_id;
			$basicControl->fb_messenger_status = $purifiedData->fb_messenger_status;

			$basicControl->save();

			return back()->with('success', 'Successfully Updated');
		}
	}

	public function googleRecaptchaConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.googleReCaptchaControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'reCaptcha_status_login' => 'nullable|integer|min:0|in:0,1',
				'reCaptcha_status_registration' => 'nullable|integer|min:0|in:0,1',
				'NOCAPTCHA_SECRET' => 'required|min:3',
				'NOCAPTCHA_SITEKEY' => 'required|min:3',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$basicControl->reCaptcha_status_login = $purifiedData->reCaptcha_status_login;
			$basicControl->reCaptcha_status_registration = $purifiedData->reCaptcha_status_registration;
			$basicControl->save();


			$envPath = base_path('.env');
			$env = file($envPath);
			$env = $this->set('NOCAPTCHA_SECRET', $purifiedData->NOCAPTCHA_SECRET, $env);
			$env = $this->set('NOCAPTCHA_SITEKEY', $purifiedData->NOCAPTCHA_SITEKEY, $env);
			$fp = fopen($envPath, 'w');
			fwrite($fp, implode($env));
			fclose($fp);

			Artisan::call('config:clear');
			Artisan::call('cache:clear');

			return back()->with('success', 'Successfully Updated');
		}
	}

	public function googleAnalyticsConfig(Request $request)
	{
		$basicControl = basicControl();
		if ($request->isMethod('get')) {
			return view('admin.control_panel.analyticControl', compact('basicControl'));
		} elseif ($request->isMethod('post')) {
			$purifiedData = Purify::clean($request->all());

			$validator = Validator::make($purifiedData, [
				'MEASUREMENT_ID' => 'required|min:3',
				'analytic_status' => 'nullable|integer|min:0|in:0,1',
			]);

			if ($validator->fails()) {
				return back()->withErrors($validator)->withInput();
			}
			$purifiedData = (object)$purifiedData;

			$basicControl->MEASUREMENT_ID = $purifiedData->MEASUREMENT_ID;
			$basicControl->analytic_status = $purifiedData->analytic_status;
			$basicControl->save();

			return back()->with('success', 'Successfully Updated');
		}
	}
}
