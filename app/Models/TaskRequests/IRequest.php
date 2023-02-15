<?php

namespace App\Models\TaskRequests;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface IRequest
{
	public function task(): MorphOne;
}
