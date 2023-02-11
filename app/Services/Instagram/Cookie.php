<?php

namespace App\Services\Instagram;

use Illuminate\Support\Arr;

class Cookie
{
	private array $cookie;

	public function __construct(array $cookie)
	{
		$this->cookie = $cookie;
	}

	/**
	 * @param string $rawCookie Создает свой объект на основе "сырых" cookie,
	 * Пример: csrftoken=B2xNK6WldFTsoa5MgPem4hy8FkFlZRBY; mid=Y-VAjwAEAAFkkXNCIe12aICf_pfX;
	 */
	public static function parse(string $rawCookie): self
	{
		$pairs = explode('; ', $rawCookie);

		$cookie = array_reduce($pairs, function ($carry, $pair) {
			[$key, $value] = explode('=', $pair, 2);

			$carry[trim($key)] = trim($value);

			return $carry;
		}, []);

		return new self($cookie);
	}

	public function toArray(): array
	{
		return $this->cookie;
	}

	public function set(array $cookie): void
	{
		$this->cookie = $cookie;
	}

	public function isNotEmpty(): bool
	{
		return !!$this->cookie;
	}

	/**
	 * Удаляет все cookie, неперечисленные в массиве $allowed
	 */
	public function filter(array $allowed): void
	{
		$this->cookie = Arr::only($this->cookie, $allowed);
	}

	/**
	 * Отдает "сырую" строку Cookie, пример:
	 *
	 * csrftoken=B2xNK6WldFTsoa5MgPem4hy8FkFlZRBY; mid=Y-VAjwAEAAFkkXNCIe12aICf_pfX;
	 */
	public function toString(): string
	{
		return implode(
			"; ",
			Arr::map($this->cookie, fn ($value, $key) => $key.'='.$value)
		);
	}
}
