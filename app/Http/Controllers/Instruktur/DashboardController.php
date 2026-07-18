<?php
namespace App\Http\Controllers\Instruktur;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $instruktur = Auth::guard('instruktur')->user();

        $pelatihan = Pelatihan::where('instruktur_id', $instruktur->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('instruktur.dashboard', compact('instruktur', 'pelatihan'));
    }
}
