<?php

namespace App\Integrations\Instagram;

use App\Integrations\Instagram\Response as IgResponse;
use Illuminate\Http\Client\Response;

abstract class Request
{
	protected Headers $headers;

	protected ?Proxy $proxy = null;

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

	public function useProxy(Proxy $proxy): void
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

	public function send(): IgResponse
	{
		$client = new Client();
		return $client->send($this);
	}
}
