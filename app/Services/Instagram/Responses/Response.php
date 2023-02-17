<?php

namespace App\Services\Instagram\Responses;

use App\Services\Instagram\Cookie;
use Illuminate\Http\Client\Response as HttpResponse;

abstract class Response
{
	public readonly ?HttpResponse $httpResponse;

	public function __construct(?HttpResponse $httpResponse)
	{
		$this->httpResponse = $httpResponse;

		if (!$this->isSomethingWrong()) {
			$this->fill($this->httpResponse->json());
		}
	}

	public function isSomethingWrong(): bool
	{
		return !$this->httpResponse || $this->httpResponse->failed() || !$this->httpResponse->json();
	}

	/**
	 * Получить cookie ответа
	 */
	final public function getCookie(): Cookie
	{
		$cookiesJar = $this->httpResponse->cookies();

		$cookie = new Cookie();

		foreach ($cookiesJar as $cookieJar) {
			$cookie->add($cookieJar->getName(), $cookieJar->getValue());
		}

		return $cookie;
	}

	abstract protected function fill(array $responseData): void;
}
