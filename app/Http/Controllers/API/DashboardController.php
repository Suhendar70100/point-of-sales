<?php

namespace App\Http\Controllers\API;

use App\Models\Item;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function getDashboardData(): JsonResponse
    {
        $totalCategories = Category::count();
        $totalItems = Item::count();
        $totalTransactions = Transaction::count();

        $highestTransaction = Transaction::select('item_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('item_id')
            ->orderBy('total_quantity', 'desc')
            ->with('item')
            ->first();

        $lowestTransaction = Transaction::select('item_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('item_id')
            ->orderBy('total_quantity', 'asc')
            ->with('item')
            ->first();

        return response()->json([
            'totalCategories' => $totalCategories,
            'totalItems' => $totalItems,
            'totalTransactions' => $totalTransactions,
            'highestTransaction' => $highestTransaction,
            'lowestTransaction' => $lowestTransaction,
        ]);
    }
}
