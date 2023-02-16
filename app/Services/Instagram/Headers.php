<?php

namespace App\Services\Instagram;

use Illuminate\Support\Arr;

class Headers
{
	private array $headers;

	private ?Cookie $cookie;

	public function __construct(array $headers, ?Cookie $cookie)
	{
		unset($headers['cookie']);
		$this->headers = $headers;
		$this->cookie = $cookie;
	}

	/**
	 * Парсит "сырой" запрос, пример запроса:
	 *
	 * GET /api/v1/web/search/recent_searches/ HTTP/2
	 * Host: i.instagram.com
	 * User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:105.0) Gecko/20100101 Firefox/105.0
	 * X-CSRFToken: PYu5ESmPmVeC2mp4wOm0aff03l5FQHth
	 * Cookie: csrftoken=...; mid=...; ig_did=...; ig_nrcb=1; sessionid=...; ds_user_id=...;"
	 */
	public static function parse(string $rawHeaders)
	{
		$requestRows = explode("\n", $rawHeaders);

		$headers = array_reduce($requestRows, function ($carry, $row) {
			// Пропускаем строки в которых нет :
			if (!preg_match('/\w:\s/i', $row)) {
				return $carry;
			}

			[$key, $value] = explode(':', $row, 2);
			$key = mb_strtolower(trim($key));

			$carry[$key] = trim($value);

			return $carry;
		}, []);

		if (array_key_exists('cookie', $headers)) {
			$cookie = Cookie::parse($headers['cookie']);
		}

		return new self($headers, $cookie ?? null);
	}

	/**
	 * Отдает массив http-заголовков в формате ключ-значение вместе с cookie
	 */
	public function toArray(): array
	{
		$cookie = ($this->cookie && $this->cookie->isNotEmpty()) ? ['Cookie' => $this->cookie->toString()] : [];

		return array_merge($this->headers, $cookie);
	}

	public function getCookie(): ?Cookie
	{
		return $this->cookie;
	}

	/**
	 * Удаляет все заголовки, неперечисленные в массиве $allowed
	 */
	public function filter(array $allowed): void
	{
		$this->headers = Arr::only($this->headers, $allowed);
	}

	/**
	 * Отдает "сырую" строку заголовков, пример:
	 *
	 * Host: i.instagram.com
	 * User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:105.0) Gecko/20100101 Firefox/105.0
	 * X-CSRFToken: PYu5ESmPmVeC2mp4wOm0aff03l5FQHth
	 * Cookie: csrftoken=...; mid=...; ig_did=...; ig_nrcb=1; sessionid=...; ds_user_id=...;"
	 */
	public function toString(): string
	{
		return implode(
			"\n",
			Arr::map($this->toArray(), fn ($value, $key) => $key.': '.$value)
		);
	}
}
