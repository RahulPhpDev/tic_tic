<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Filter;
use App\Http\Resources\Api\FilterResource;

class FilterController extends Controller
{
  public function detail($id)
  {
      return (new FilterResource(Filter::findOrFail($id)->load('category')) );

  }
}
