<?php
namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Http\Requests\Peserta\UpdateProfilePesertaRequest;
use App\Services\Peserta\ProfileService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(private ProfileService $service) {}

    public function edit() {
        return view('peserta.profile', ['peserta' => Auth::guard('peserta')->user()]);
    }
    public function update(UpdateProfilePesertaRequest $request) {
        $data = $request->validated();
        if ($request->hasFile('foto')) $data['foto'] = $request->file('foto');
        $this->service->update(Auth::guard('peserta')->user(), $data);
        return back()->with('success','Profil berhasil diperbarui.');
    }
}
