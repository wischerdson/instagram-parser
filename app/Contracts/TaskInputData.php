<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface TaskInputData
{
	public function task(): MorphOne;
}
