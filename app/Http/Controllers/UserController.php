<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UserController extends Controller
{
    private $waApiKey = "2vVzEvLuqnU8B48GfLKF";

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function showProfile()
    {
        return view('profile');
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
        ]);

        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->address = $validatedData['address'] ?? $user->address;
        $user->phone_number = $validatedData['phone_number'] ?? $user->phone_number;

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $filePath = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $filePath;
        }

        try {
            $user->save();
            return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui profil: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal memperbarui profil.']);
        }
    }

    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // $user = Auth::user();
        $user = User::findOrFail($id);
        $user->password = Hash::make($request->new_password);
        
        try {
            $user->save();
            return redirect()->route('profile.show')->with('success', 'Kata sandi berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui kata sandi: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal memperbarui kata sandi.']);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:1,2,3',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        if ($request->hasFile('profile_photo')) {
            $filePath = $request->file('profile_photo')->store('profile_photos', 'public');
            $validatedData['profile_photo'] = $filePath;
        }

        $user = User::create($validatedData);

        // Mengirim pesan WhatsApp
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $request->phone_number,
                'message' =>
                "Hai " . $request->name . ",\n\n" .
                    "Selamat datang di Sistem Keamanan Pondok Pesantren Salafiyah Sholawat! Berikut adalah informasi login untuk akses ke sistem website kami: \n\n" .
                    "Username : " . $request->username . "\n" .
                    "Password : " . $request->password . "\n\n" .
                    "Silakan gunakan informasi di atas untuk login di web Kost Rosanty. \n\n" .
                    "Salam hangat, \nAdmin Sistem Keamanan Pondok Pesantren Salafiyah Sholawat",
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: " . $this->waApiKey,
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        // Log aktivitas
        ActivityLog::log("Created user '{$user->name}' with role '{$user->role}'");

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|integer|in:1,2,3',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
        ]);

        $oldName = $user->name;
        $oldRole = $user->role;

        $user->name = $request->name;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->address = $request->address;
        $user->phone_number = $request->phone_number;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $filePath = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $filePath;
        }

        try {
            $user->save();
            ActivityLog::log("Updated user '{$oldName}' with role '{$oldRole}'");
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Gagal memperbarui user.']);
        }
    }

    public function getDashboardData()
    {
        $jumlahPengguna = User::count();

        return response()->json([
            'jumlahPengguna' => $jumlahPengguna,
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Log aktivitas sebelum penghapusan
        ActivityLog::log("Deleted user '{$user->name}' with role '{$user->role}'");

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function showActivityLogs(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $logs = ActivityLog::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        return view('users.activity_logs', compact('logs'));
    }
}
