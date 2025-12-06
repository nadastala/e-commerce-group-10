<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SORAÉ</title>
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
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .form-header {
            margin-bottom: 35px;
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
            margin-bottom: 20px;
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
            align-items: flex-start;
            gap: 10px;
        }
        
        .form-checkbox input {
            width: 18px;
            height: 18px;
            margin-top: 3px;
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
            margin-top: 10px;
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
            margin: 25px 0;
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
        
        .login-link {
            text-align: center;
            color: var(--color-secondary);
        }
        
        .login-link a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
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
        
        .error-list {
            margin-top: 8px;
            padding-left: 20px;
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
            <h2>Join SORAÉ</h2>
            <p>Create your account and start your fashion journey with exclusive collections and personalized recommendations.</p>
        </div>
        
        <div class="auth-form">
            <div class="form-header">
                <h1>Create Account</h1>
                <p>Fill in your details to get started</p>
            </div>
            
            @if ($errors->any())
            <div class="error-message">
                <strong>Please fix the following errors:</strong>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-input" 
                           value="{{ old('name') }}" 
                           placeholder="John Doe" 
                           required autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" 
                           value="{{ old('email') }}" 
                           placeholder="your@email.com" 
                           required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-input" 
                           value="{{ old('phone') }}" 
                           placeholder="08123456789" 
                           required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" 
                           placeholder="Minimum 8 characters" 
                           required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-input" 
                           placeholder="Re-enter your password" 
                           required>
                </div>
                
                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="terms" required>
                        <span>I agree to the <a href="#" style="color: var(--color-primary);">Terms & Conditions</a> and <a href="#" style="color: var(--color-primary);">Privacy Policy</a></span>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary">Create Account</button>
            </form>
            
            <div class="divider">
                <span>or</span>
            </div>
            
            <p class="login-link">
                Already have an account? <a href="{{ route('login') }}">Sign in here</a>
            </p>
        </div>
    </div>
</body>
</html>

