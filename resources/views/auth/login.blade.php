<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SORAÉ</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-primary: #561C24;
            --color-secondary: #6D2932;
            --color-tertiary: #C7B7A3;
            --color-light: #E8D8C4;
            --color-white: #FFFFFF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--color-light) 0%, var(--color-tertiary) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        h1, h2 {
            font-family: 'Playfair Display', serif;
        }
        
        .auth-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 1000px;
            width: 100%;
            background: var(--color-white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(86, 28, 36, 0.15);
        }
        
        .auth-visual {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--color-white);
        }
        
        .auth-visual img {
            max-width: 150px;
            margin-bottom: 30px;
            filter: brightness(0) invert(1);
        }
        
        .auth-visual h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .auth-visual p {
            text-align: center;
            opacity: 0.9;
            line-height: 1.6;
        }
        
        .auth-form {
            padding: 60px;
        }
        
        .form-header {
            margin-bottom: 40px;
        }
        
        .form-header h1 {
            font-size: 2rem;
            color: var(--color-primary);
            margin-bottom: 10px;
        }
        
        .form-header p {
            color: var(--color-secondary);
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: var(--color-primary);
            font-weight: 500;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--color-tertiary);
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--color-primary);
        }
        
        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-checkbox input {
            width: 18px;
            height: 18px;
        }
        
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .forgot-link {
            color: var(--color-secondary);
            text-decoration: none;
            font-size: 0.95rem;
        }
        
        .forgot-link:hover {
            color: var(--color-primary);
        }
        
        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: var(--color-primary);
            color: var(--color-white);
        }
        
        .btn-primary:hover {
            background: var(--color-secondary);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(86, 28, 36, 0.25);
        }
        
        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: var(--color-tertiary);
        }
        
        .divider span {
            background: var(--color-white);
            padding: 0 15px;
            position: relative;
            color: var(--color-tertiary);
        }
        
        .register-link {
            text-align: center;
            color: var(--color-secondary);
        }
        
        .register-link a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            background: #ffe6e6;
            color: #cc0000;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }
        
        @media (max-width: 768px) {
            .auth-container {
                grid-template-columns: 1fr;
            }
            
            .auth-visual {
                display: none;
            }
            
            .auth-form {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-visual">
            <img src="{{ asset('images/soraelogo.png') }}" alt="SORAÉ">
            <h2>Welcome Back!</h2>
            <p>Sign in to continue your style journey with SORAÉ. Discover the latest collections and elevate your wardrobe.</p>
        </div>
        
        <div class="auth-form">
            <div class="form-header">
                <h1>Login</h1>
                <p>Enter your credentials to access your account</p>
            </div>
            
            @if ($errors->any())
            <div class="error-message">
                <strong>Oops!</strong> {{ $errors->first() }}
            </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" 
                           value="{{ old('email') }}" 
                           placeholder="your@email.com" 
                           required autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" 
                           placeholder="Enter your password" 
                           required>
                </div>
                
                <div class="form-actions">
                    <label class="form-checkbox">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                </div>
                
                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
            
            <div class="divider">
                <span>or</span>
            </div>
            
            <p class="register-link">
                Don't have an account? <a href="{{ route('register') }}">Create one now</a>
            </p>
        </div>
    </div>
</body>
</html>


