<?php
namespace AsceticCMS\Lib;

//TODO: render templates. maybe you should use simpleXML lib or another libs. Think it!
class Render {
	private $buf = array();

	/**
	 * @param $path - path to file *.tpl
	 * @todo        add functional
	 */
	public function run($path) {
		$handle = fopen($path, "r");
		if ($handle) {
			while (($line = fgets($handle)) !== false) {
				$res = trim(preg_replace('/\t+/', '', $line));
				array_push($this->buf, $this->convert($res));
			}
			fclose($handle);
		} else {
			// error opening the file.
			array_push($this->buf, 'Error open file!');
		}
	}

	public function show() {
		return $this->buf;
	}

	public function convert($data) {
		return $data;
	}

	/**
	 * include file with view, *.php
	 * forward data to view
	 */

	public static function renderView($data, $ViewName) {
		$path = __DIR__ . "/../MVC/Views/" . $ViewName;
		if (file_exists($path)) {
			$config = json_decode($data, true);
			$str = file_get_contents($path); //FIXME!!!
			return $str;
		} else {
			throw new \Exception('invalid params in Render::renderView();');
		}
	}
}
