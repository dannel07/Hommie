<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PlatformAdminController extends Controller
{
    /**
     * Tampilkan dashboard Admin Platform.
     */
    public function dashboard()
    {
        // Data statistik
        $totalUsers = User::count();
        $bannedUsers = User::where('is_banned', true)->count();
        $activeUsers = $totalUsers - $bannedUsers;

        // Data Owner dan Penyewa
        $owners = User::where('user_role_id', 2)->get(); // Semua Owner
        $tenants = User::where('user_role_id', 3)->get(); // Semua Penyewa

        $activeOwners = $owners->where('is_banned', false); // Owner aktif
        $bannedOwners = $owners->where('is_banned', true); // Owner dibanned

        $activeTenants = $tenants->where('is_banned', false); // Penyewa aktif
        $bannedTenants = $tenants->where('is_banned', true); // Penyewa dibanned

        return view('platform_admin.dashboard', compact(
            'totalUsers',
            'bannedUsers',
            'activeUsers',
            'activeOwners',
            'bannedOwners',
            'activeTenants',
            'bannedTenants'
        ));
    }

    /**
     * Banned pengguna berdasarkan ID.
     */
    public function ban($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = true; // Set status banned
        $user->save();

        return redirect()->route('platform_admin.dashboard')->with('success', 'Pengguna berhasil dibanned.');
    }

    /**
     * Batalkan banned pengguna berdasarkan ID.
     */
    public function unban($id)
    {
        $user = User::findOrFail($id);
        $user->is_banned = false; // Batalkan status banned
        $user->save();

        return redirect()->route('platform_admin.dashboard')->with('success', 'Banned pengguna berhasil dibatalkan.');
    }
}