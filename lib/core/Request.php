<?php

namespace core;

use \Singleton;

class Request extends Singleton {

	protected static $instance;

	private $body;

	private $params;

	private $headers;

	public function __construct() {

		$method = $_SERVER["REQUEST_METHOD"];

		if ($method === "POST") {

			$this->body = $_POST;

		} else if ($method === "PUT" || $method === "DELETE") {

			parse_str(file_get_contents("php://input"), $this->body);
		}

		$this->params = $_GET;

		$this->headers = getallheaders();
	}

	public static function param($key) {

		$params = static::getInstance()->params;

		if (isset($params[$key])) {

			return $params[$key];
		}

		return null;
	}

	public static function params($key = null) {

		if (is_null($key)) {

			return static::getInstance()->params;
		}

		return static::param($key);
	}

	public static function body($key = null) {

		$body = static::getInstance()->body;

		if (is_null($key)) {

			return $body;
		}

		if (isset($body[$key])) {

			return $body[$key];
		}

		return null;
	}

	public static function header($key = null) {

		$headers = static::getInstance()->headers;

		if (isset($headers[$key])) {

			return $headers[$key];
		}

		return null;
	}

	public static function headers($key = null) {

		if (is_null($key)) {

			return static::getInstance()->headers;
		}

		return static::header($key);
	}

}
