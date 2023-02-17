<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface TaskResult
{
	public function task(): MorphOne;
}
