<?php

namespace App\Integrations\Instagram;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class Dto
{
	protected array $data;

	public function __construct(array $data)
	{
		$this->data = $data;
		$this->fill();
	}

	public function toArray(): array
	{
		$result = [];
		$properties = get_object_vars($this);

		unset($properties['data']);

		foreach ($properties as $propName => $propValue) {
			$result[Str::snake($propName)] = $propValue;
		}

		return $result;
	}

	protected function get(string $key, bool $allowTrim = true, bool $allowCastingEmptyStringsToNull = true, mixed $default = null): mixed
	{
		$value = Arr::get($this->data, $key, $default);

		if ($allowTrim && is_string($value)) {
			$value = trim($value);
		}

		if ($allowCastingEmptyStringsToNull && $value === '') {
			$value = null;
		}

		return $value;
	}

	abstract protected function fill(): void;
}
