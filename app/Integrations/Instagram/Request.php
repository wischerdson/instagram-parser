<?php

namespace App\Integrations\Instagram;

use Illuminate\Http\Client\Response;

abstract class Request
{
	protected Headers $headers;

	protected ?Proxy $proxy;

	protected string $method;

	abstract public function getUrl(): string;

	public function getMethod(): string
	{
		return $this->method;
	}

	public function getQuery(): array
	{
		return [];
	}

	public function getBody(): array | string
	{
		return [];
	}

	public function getHeaders(): Headers
	{
		return $this->headers;
	}

	public function authorize(Headers $headers): void
	{
		$this->headers = $headers;
	}

	public function setProxy(Proxy $proxy): void
	{
		$this->proxy = $proxy;
	}

	public function getProxy(): ?Proxy
	{
		return $this->proxy;
	}

	public function castToDto(Response $response): ?Dto
	{
		return null;
	}
}
