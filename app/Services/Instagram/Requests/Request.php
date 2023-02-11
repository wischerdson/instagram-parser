<?php

namespace App\Services\Instagram\Requests;

use App\Services\Instagram\Headers;

abstract class Request
{
	protected Headers $headers;

	abstract public function getUrl(): string;

	abstract public function getMethod(): string;

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
}
