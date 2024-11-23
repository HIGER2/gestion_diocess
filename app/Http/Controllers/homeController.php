<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pretre;
use App\Models\Diocese;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Cast\Object_;

class homeController extends Controller
{

    public function analytic()
    {
        $diocess_count = Diocese::count();
        $prete_count = Pretre::count();
        $user_count = User::count();
        return response()->json([
            'message' => 'analytic',
            'data' => (object)[
                "user_count" => $user_count,
                "prete_count" => $prete_count,
                "dio_count" => $diocess_count
            ],
        ], 201);
    }
}
