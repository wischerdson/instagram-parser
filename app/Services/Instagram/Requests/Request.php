<?php

namespace App\Services\Instagram\Requests;

use App\Services\Instagram\AuthCredentials;
use App\Services\Instagram\Headers;
use App\Services\Instagram\Responses\Response;
use Illuminate\Http\Client\Response as HttpResponse;

abstract class Request
{
	protected Headers $headers;

	abstract public function getUrl(): string;

	abstract public function getResponseInstance(HttpResponse $httpResponse): Response;

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

	public function getMethod(): string
	{
		return 'POST';
	}

	public function authorize(Headers $headers): void
	{
		$this->headers = $headers;
	}
}
