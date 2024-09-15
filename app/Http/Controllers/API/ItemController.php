<?php

namespace App\Http\Controllers\API;

use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Models\Category;

class ItemController extends Controller
{
    public function index()
    {
        $category = Category::query()->get();

        return view('item.index', compact('category'));
    }

    public function dataTable(): JsonResponse
    {
        $data = Item::query()->get();

        return DataTables::of($data)
        ->addColumn('aksi', function ($row) {
            return " <a href='#' data-id='$row->id' class='mdi mdi-pencil text-warning btn-edit'></a>
                            <a href='#' data-id='$row->id' class='mdi mdi-trash-can text-primary btn-delete'></a>";
        })
        ->addColumn('category', function ($row) {
            return $row->category->name;
        })
        ->rawColumns(['aksi'])
        ->toJson();
    }


    public function store(ItemRequest $request)
    {
        $item = Item::create($request->validated());

        return response()->json([
            'message' => 'Barang berhasil ditambahkan',
            'data' => $item
        ], 201);
    }

    public function show($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        return response()->json($item, 200);
    }

    public function update(ItemRequest $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $item->update($request->validated());

        return response()->json([
            'message' => 'Barang berhasil diperbarui',
            'data' => $item
        ], 200);
    }

    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Barang berhasil dihapus'], 200);
    }
}