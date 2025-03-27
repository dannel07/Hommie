<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function storeProvinces(Request $request)
    {
        $request->validate([
            'prov_name' => 'required|string|max:100'
        ]);

        try {
            DB::statement("CALL insert_province(?)", [
                $request->prov_name
            ]);

            return response()->json(['message' => 'Provinsi berhasil ditambahkan'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage()], 500);
        }
    }

    public function storeCities(Request $request)
    {
        $request->validate([
            'city_name' => 'required|string|max:100',
            'prov_id' => 'required|exists:provinces,id'
        ]);

        try {
            DB::statement("CALL insert_city(?, ?)", [
                $request->city_name,
                $request->prov_id
            ]);

            return response()->json(['message' => 'Kota berhasil ditambahkan'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage()], 500);
        }
    }

    public function storeDistricts(Request $request)
    {
        $request->validate([
            'district_name' => 'required|string|max:100',
            'city_id' => 'required|exists:cities,id'
        ]);

        try {
            DB::statement("CALL insert_district(?, ?)", [
                $request->district_name,
                $request->city_id
            ]);

            return response()->json(['message' => 'Kecamatan berhasil ditambahkan'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage()], 500);
        }
    }

    public function storeSubdistricts(Request $request)
    {
        $request->validate([
            'subdistrict_name' => 'required|string|max:100',
            'district_id' => 'required|exists:districts,id'
        ]);

        try {
            DB::statement("CALL insert_subdistrict(?, ?)", [
                $request->subdistrict_name,
                $request->district_id
            ]);

            return response()->json(['message' => 'Kelurahan berhasil ditambahkan'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage()], 500);
        }
    }

    public function getProvinces()
    {
        $provinces = DB::select("CALL getProvinces()");
        return response()->json($provinces);
    }

    public function getCities($province_id)
    {
        $cities = DB::select("CALL getCities(?)", [$province_id]);
        return response()->json($cities);
    }

    public function getDistricts($cities_id)
    {
        $districts = DB::select("CALL getDistricts(?)", [$cities_id]);
        return response()->json($districts);
    }

    public function getSubdistricts($district_id)
    {
        $subdistricts = DB::select("CALL getSubdistricts(?)", [$district_id]);
        return response()->json($subdistricts);
    }
}
