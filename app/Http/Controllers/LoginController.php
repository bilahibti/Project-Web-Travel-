<?php 
namespace App\Http\Controllers; 
 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 
 
class LoginController extends Controller 
{ 
    public function loginBackend() 
    { 
        return view('backend.v_login.login', [ 
            'judul' => 'Login', 
        ]); 
    } 
    
    public function loginFrontend() 
    { 
        return view('frontend.v_login.login', [ 
            'judul' => 'Login', 
        ]); 
    }
 
    public function authenticateBackend(Request $request) 
    { 
        $credentials = $request->validate([ 
            'email' => 'required|email', 
            'password' => 'required' 
        ]); 

        if (Auth::attempt($credentials)) { 
            
            $user = Auth::user();

            // cek status aktif
            if ($user->status == 0) { 
                Auth::logout(); 
                return back()->with('error', 'User belum aktif'); 
            } 

            $request->session()->regenerate(); 

            // 🔥 ROLE BASED REDIRECT
            switch ($user->role->slug) {

                case 'admin':
                    return redirect()->route('backend.admin.dashboard');

                case 'staff':
                    return redirect()->route('backend.staff.dashboard');

                case 'finance':
                    return redirect()->route('backend.finance.dashboard');

                default:
                    // kalau bukan role backend
                    Auth::logout();
                    return back()->with('error', 'Akses bukan untuk backend');
            }
        } 

        return back()->with('error', 'Login Gagal'); 
    }

    public function authenticateFrontend(Request $request) 
    { 
        $credentials = $request->validate([ 
            'email' => 'required|email', 
            'password' => 'required' 
        ]); 
 
        if (Auth::attempt($credentials)) { 
            if (Auth::user()->status == 0) { 
                Auth::logout(); 
                return back()->with('error', 'User belum aktif'); 
            } 
            $request->session()->regenerate(); 
            return redirect()->intended(route('frontend.beranda')); 
        } 
        return back()->with('error', 'Login Gagal'); 
    }
 
    public function logoutBackend() 
    { 
        Auth::logout(); 
        request()->session()->invalidate(); 
        request()->session()->regenerateToken(); 
        return redirect(route('backend.login')); 
    } 

    public function logoutFrontend() 
    { 
        Auth::logout(); 
        request()->session()->invalidate(); 
        request()->session()->regenerateToken(); 
        return redirect(route('frontend.login')); 
    }

    public function registerBackend()
    {
        return view('backend.v_login.register', [
            'judul' => 'Register'
        ]);
    }

    public function registerFrontend()
    {
        return view('frontend.v_login.register', [
            'judul' => 'Register'
        ]);
    }
    
    public function storeRegister(Request $request)
    {
        // nanti isi logika simpan user di sini
    }
} 