<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FormFieldProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		\View::share('optsDialingCodes',self::getDialingCodes());
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}

	static function getDialingCodes() {
		$txtDebug = __CLASS__."".__FUNCTION__;
		$path = \App::basePath()."/resources/dialingcodes.csv";
		$txtDebug .= "\n  \$path - {$path}, exists - ".file_exists($path);
		$codes = array(''=>"Select");
		if (file_exists($path)) {
			$content = file($path);
			$txtDebug .= "\n  \$content: count - ".count($content);
			foreach ($content AS $i=>$line) {
				if ($i == 0) continue;
				$line = trim($line);
				$txtDebug .= "\n    line {$i}: {$line}";
				$s = preg_split('/;/', $line);
				$txtDebug .= ", \$s: count - ".count($s);
				//$codes[] = array('name'=>$s[0],'iso'=>$s[1],'code'=>$s[2]);
				$codes[$s[2]] = $s[0];
			}
		}
		$txtDebug .= "\n  \$codes: count - ".count($codes).", ".print_r($codes,1);
return $codes;
		die($txtDebug);
		die("<pre>{$txtDebug}</pre>");
	}
}
