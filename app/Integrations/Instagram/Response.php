<?php

namespace App\Integrations\Instagram;

use App\Integrations\Instagram\Cookie;
use Illuminate\Http\Client\Response as HttpResponse;

class Response
{
	public readonly HttpResponse $httpResponse;

	public readonly Request $request;

	private ?Dto $dto = null;

	public function __construct(?HttpResponse $httpResponse, Request $request)
	{
		$this->httpResponse = $httpResponse;
		$this->request = $request;
	}

	public function isSomethingWrong(): bool
	{
		return !$this->httpResponse || $this->httpResponse->failed() || !$this->httpResponse->json();
	}

	/**
	 * Получить cookie ответа
	 */
	public function getCookie(): Cookie
	{
		$cookiesJar = $this->httpResponse->cookies();

		$cookie = new Cookie();

		foreach ($cookiesJar as $cookieJar) {
			$cookie->add($cookieJar->getName(), $cookieJar->getValue());
		}

		return $cookie;
	}

	public function dto(): Dto
	{
		return $this->dto ?: $this->request->castToDto($this->httpResponse);
	}
}
