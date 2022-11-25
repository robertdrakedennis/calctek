<?php

namespace App\Http\Controllers\Api;

use App\Contracts\HasCalculator;
use App\Http\Controllers\Controller;
use App\Support\InteractsWithCalculator;
use Illuminate\Http\Request;

class CalculatorController extends Controller implements HasCalculator
{
    use InteractsWithCalculator;

    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $equation = $request->get('equation');

        $result = InteractsWithCalculator::calculate($equation);

        return response()->json(['result' => $result]);
    }
}
