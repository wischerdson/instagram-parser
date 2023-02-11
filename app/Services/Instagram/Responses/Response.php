<?php

namespace App\Services\Instagram\Responses;

use App\Services\Instagram\Models\Model;
use Illuminate\Http\Client\Response as HttpResponse;

abstract class Response
{
	public readonly HttpResponse $httpResponse;

	public function __construct(HttpResponse $httpResponse)
	{
		$this->httpResponse = $httpResponse;
	}

	public function isSomethingWrong(): bool
	{
		return $this->httpResponse->failed();
	}

	public function getModel(): ?Model
	{
		return null;
	}
}
