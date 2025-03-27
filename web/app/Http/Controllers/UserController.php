<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function showDetailProperty($id)
    {
        // Panggil Stored Procedure
        $property = DB::select('CALL viewAll_propertyById(?)', [$id]);

        // Ambil objek pertama, atau null jika tidak ditemukan
        $property = $property[0] ?? null;

        // Jika tidak ada property dengan ID tersebut, kembalikan error 404
        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        // Kembalikan response JSON
        return response()->json($property);
    }
}
