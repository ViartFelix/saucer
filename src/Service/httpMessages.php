<?php

namespace App\Service;

class httpMessages
{
	public function __construct(){}

	public function getMessage(?int $code): string
	{
		$toReturn = "Unknown error. Please retry in a couple of moments.";

		try {
			if(!empty($code))
			{
				switch ($code) {
					case 100: $toReturn = 'Continue'; break;
					case 101: $toReturn = 'Switching Protocols'; break;
					case 200: $toReturn = 'OK'; break;
					case 201: $toReturn = 'Created'; break;
					case 202: $toReturn = 'Accepted'; break;
					case 203: $toReturn = 'Non-Authoritative Information'; break;
					case 204: $toReturn = 'No Content'; break;
					case 205: $toReturn = 'Reset Content'; break;
					case 206: $toReturn = 'Partial Content'; break;
					case 300: $toReturn = 'Multiple Choices'; break;
					case 301: $toReturn = 'Moved Permanently'; break;
					case 302: $toReturn = 'Moved Temporarily'; break;
					case 303: $toReturn = 'See Other'; break;
					case 304: $toReturn = 'Not Modified'; break;
					case 305: $toReturn = 'Use Proxy'; break;
					case 400: $toReturn = 'Bad Request'; break;
					case 401: $toReturn = 'Unauthorized'; break;
					case 402: $toReturn = 'Payment Required'; break;
					case 403: $toReturn = 'Forbidden'; break;
					case 404: $toReturn = 'Not Found'; break;
					case 405: $toReturn = 'Method Not Allowed'; break;
					case 406: $toReturn = 'Not Acceptable'; break;
					case 407: $toReturn = 'Proxy Authentication Required'; break;
					case 408: $toReturn = 'Request Time-out'; break;
					case 409: $toReturn = 'Conflict'; break;
					case 410: $toReturn = 'Gone'; break;
					case 411: $toReturn = 'Length Required'; break;
					case 412: $toReturn = 'Precondition Failed'; break;
					case 413: $toReturn = 'Request Entity Too Large'; break;
					case 414: $toReturn = 'Request-URI Too Large'; break;
					case 415: $toReturn = 'Unsupported Media Type'; break;
					case 500: $toReturn = 'Internal Server Error'; break;
					case 501: $toReturn = 'Not Implemented'; break;
					case 502: $toReturn = 'Bad Gateway'; break;
					case 503: $toReturn = 'Service Unavailable'; break;
					case 504: $toReturn = 'Gateway Time-out'; break;
					case 505: $toReturn = 'HTTP Version not supported'; break;
				}
			}
		} catch (\Exception $e) {

		} finally {
			return $toReturn;
		}
	}
}