<?php

namespace App\Integrations\Instagram\Requests;

use App\Integrations\Instagram\Request;

class RecentSearchesRequest extends Request
{
	protected string $method = 'GET';

	public function getUrl(): string
	{
		return 'https://www.instagram.com/api/v1/web/search/recent_searches/';
	}
}
