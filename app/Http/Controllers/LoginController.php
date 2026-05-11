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

            $request->session()->regenerate(); 

            // 🔥 ROLE BASED REDIRECT
            switch ($user->role->slug) {

                case 'admin':
                    return redirect()->route('v1.backend.dashboard.admin');

                case 'staff':
                    return redirect()->route('v1.backend.dashboard.staff');

                default:
                    // kalau bukan role backend
                    Auth::logout();
                    return back()->with('error', 'Access is not allowed for backend users');
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
            $request->session()->regenerate(); 
            return redirect()->intended(route('v1.frontend.dashboard')); 
        } 
        return back()->with('error', 'Login Failed'); 
    }
 
    public function logoutBackend() 
    { 
        Auth::logout(); 
        request()->session()->invalidate(); 
        request()->session()->regenerateToken(); 
        return redirect(route('v1.backend.login.login')); 
    } 

    public function logoutFrontend() 
    { 
        Auth::logout(); 
        request()->session()->invalidate(); 
        request()->session()->regenerateToken(); 
        return redirect(route('v1.frontend.login.login')); 
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $customerRole = \App\Models\Role::where('slug', 'customer')->first();

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role_id' => $customerRole->id,
        ]);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('v1.frontend.dashboard');
    }
} 