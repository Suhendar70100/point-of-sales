<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    public function index()
    {
        $items = Item::query()->get();

        return view('transaction.index', compact('items'));
    }

    public function dataTable(Request $request): JsonResponse
    {
        $query = Transaction::query();

        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $startDateFormatted = Carbon::parse($startDate)->startOfDay();
            $endDateFormatted = Carbon::parse($endDate)->endOfDay();

            $query->whereBetween('transaction_date', [$startDateFormatted, $endDateFormatted]);
        }

        $data = $query->get();

        return DataTables::of($data)
            ->addColumn('aksi', function ($row) {
                return " <a href='#' data-id='$row->id' class='mdi mdi-pencil text-warning btn-edit'></a>
                                <a href='#' data-id='$row->id' class='mdi mdi-trash-can text-primary btn-delete'></a>";
            })
            ->addColumn('item', function ($row) {
                return $row->item->name; 
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function store(TransactionRequest $request)
    {
        $transaction = Transaction::create($request->validated());

        return response()->json([
            'message' => 'Barang berhasil ditambahkan',
            'data' => $transaction
        ], 201);
    }

    public function show($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        return response()->json($transaction, 200);
    }

    public function update(TransactionRequest $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $transaction->update($request->validated());

        return response()->json([
            'message' => 'Barang berhasil diperbarui',
            'data' => $transaction
        ], 200);
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $transaction->delete();

        return response()->json(['message' => 'Barang berhasil dihapus'], 200);
    }

    // testing
}