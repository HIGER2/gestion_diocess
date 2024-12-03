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
        $diocess = Diocese::orderBy('created_at', 'desc')->get();
        $prete_count = Pretre::where('status', 'active')->count();
        $prete_count_inactive = Pretre::where('status', 'inactive')->count();
        $prete_inactive = Pretre::with('diocese')->where('status', 'inactive')->orderBy('created_at', 'desc')->get();
        $user_count = User::count();
        return response()->json([
            'message' => 'analytic',
            'data' => (object)[
                "user_count" => $user_count,
                "prete_count" => $prete_count,
                "dio_count" => $diocess_count,
                "prete_count_inactive" => $prete_count_inactive,
                "prete_inactive" => $prete_inactive,
                "diocess" => $diocess,
            ],
        ], 201);
    }
}
