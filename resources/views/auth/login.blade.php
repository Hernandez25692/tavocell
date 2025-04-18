<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TavoCell 504</title>
    <style>
        :root {
            --primary-dark: #1e3a8a;
            --primary-light: #3b82f6;
            --accent-color: #f59e0b;
            --text-light: #f8fafc;
            --text-dark: #1e293b;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-dark), #0f172a);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-dark);
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            position: relative;
            z-index: 1;
            transform-style: preserve-3d;
            transition: all 0.5s ease;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
                    transparent 0%,
                    rgba(255, 255, 255, 0.1) 50%,
                    transparent 100%);
            animation: shine 3s infinite;
            z-index: -1;
        }

        @keyframes shine {
            0% {
                transform: rotate(0deg) translate(-30%, -30%);
            }

            100% {
                transform: rotate(360deg) translate(-30%, -30%);
            }
        }

        .login-header {
            background: linear-gradient(to right, var(--primary-dark), var(--primary-light));
            padding: 30px 0;
            text-align: center;
            color: white;
            position: relative;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        .logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05) rotate(5deg);
        }

        .login-header h2 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .login-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            outline: none;
            background-color: white;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me input {
            margin-right: 10px;
            accent-color: var(--primary-dark);
            width: 18px;
            height: 18px;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, var(--primary-dark), var(--primary-light));
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .forgot-password {
            color: var(--primary-dark);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--accent-color);
            text-decoration: underline;
        }

        .motto {
            text-align: center;
            margin-top: 30px;
            color: var(--text-light);
            font-style: italic;
            font-size: 0.9rem;
            letter-spacing: 1px;
            opacity: 0.8;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .error-message {
            color: #dc2626;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 0 20px;
            }

            .login-body {
                padding: 25px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <img src="{{ asset('Logo/tavocell-logo.jpg') }}" alt="TavoCell 504" class="logo">
            <h2>Bienvenido a TavoCell 504</h2>
        </div>

        <div class="login-body">
            <!-- Session Status -->
            @if (session('status'))
                <div style="color: #16a34a; margin-bottom: 15px; font-weight: 500;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}"
                        required autofocus>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input id="password" class="form-control" type="password" name="password" required
                        autocomplete="current-password">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Recordar sesión</label>
                </div>

                <button type="submit" class="btn-login">Iniciar Sesión</button>

                <div class="login-footer">
                    @if (Route::has('password.request'))
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>
                <div class="motto" style="margin-top: 20px; text-align: center; font-size: 1.2rem; font-weight: bold; color: var(--primary-dark);">
                    <h2 style="margin: 0; font-style: italic; text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);">
                        "HONRADEZ, CALIDAD Y SERVICIO"
                    </h2>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
