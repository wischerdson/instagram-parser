<?php

namespace App\Services\Instagram\Models;

use Illuminate\Support\Str;

abstract class Model
{
	public function __construct(array $data)
	{
		foreach ($data as $key => $value) {
			$key = Str::camel($key);

			if (property_exists($this, $key)) {
				$this->$key = $value;
			}
		}
	}
}
