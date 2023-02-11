<?php

namespace App\Services\Instagram\Responses;

use App\Services\Instagram\Cookie;
use App\Services\Instagram\Models\Model;
use Illuminate\Http\Client\Response as HttpResponse;

abstract class Response
{
	public readonly HttpResponse $httpResponse;

	public function __construct(HttpResponse $httpResponse)
	{
		$this->httpResponse = $httpResponse;

		if (!$this->isSomethingWrong()) {
			$this->fill($this->httpResponse->json());
		}
	}

	abstract protected function fill(array $data): void;

	public function isSomethingWrong(): bool
	{
		return $this->httpResponse->failed();
	}

	public function getModel(): ?Model
	{
		return null;
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
}
