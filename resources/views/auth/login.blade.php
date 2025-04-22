<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TavoCell 504</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-dark: #1e3a8a;
            --primary-light: #3b82f6;
            --accent-color: #f59e0b;
            --text-light: #f8fafc;
            --text-dark: #1e293b;
            --success-color: #10b981;
            --error-color: #ef4444;
            --glass-effect: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-dark), #0f172a);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-dark);
            position: relative;
            overflow: hidden;
        }

        /* Background animation elements */
        .bg-bubbles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .bg-bubbles li {
            position: absolute;
            list-style: none;
            display: block;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.15);
            bottom: -160px;
            animation: square 25s infinite;
            transition-timing-function: linear;
            border-radius: 10px;
        }

        .bg-bubbles li:nth-child(1) {
            left: 10%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
            animation-duration: 17s;
        }

        .bg-bubbles li:nth-child(2) {
            left: 20%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }

        .bg-bubbles li:nth-child(3) {
            left: 25%;
            animation-delay: 4s;
        }

        .bg-bubbles li:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .bg-bubbles li:nth-child(5) {
            left: 70%;
        }

        .bg-bubbles li:nth-child(6) {
            left: 80%;
            width: 120px;
            height: 120px;
            animation-delay: 3s;
        }

        .bg-bubbles li:nth-child(7) {
            left: 32%;
            width: 160px;
            height: 160px;
            animation-delay: 7s;
        }

        .bg-bubbles li:nth-child(8) {
            left: 55%;
            width: 20px;
            height: 20px;
            animation-delay: 15s;
            animation-duration: 40s;
        }

        .bg-bubbles li:nth-child(9) {
            left: 25%;
            width: 10px;
            height: 10px;
            animation-delay: 2s;
            animation-duration: 40s;
        }

        .bg-bubbles li:nth-child(10) {
            left: 90%;
            width: 160px;
            height: 160px;
            animation-delay: 11s;
        }

        @keyframes square {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
            }
        }

        /* Main container */
        .login-wrapper {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 1200px;
            margin: 20px;
            transition: all 0.3s ease;
        }

        .login-container {
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
            transition: all 0.5s ease;
            display: flex;
            flex-direction: column;
        }

        /* Header section */
        .login-header {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
            padding: 40px 0;
            text-align: center;
            color: white;
            position: relative;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin-bottom: 20px;
        }

        .logo {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .logo-glow {
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.8) 0%, transparent 70%);
            animation: pulse 2s infinite alternate;
            z-index: 1;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                opacity: 0.7;
            }
            100% {
                transform: scale(1.05);
                opacity: 0.9;
            }
        }

        .logo:hover {
            transform: scale(1.05) rotate(5deg);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        }

        .login-header h2 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        /* Body section */
        .login-body {
            padding: 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--primary-dark);
            font-size: 0.95rem;
        }

        .input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            color: var(--primary-light);
            font-size: 1.1rem;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            outline: none;
            background-color: white;
            padding-left: 50px;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            cursor: pointer;
            color: var(--primary-light);
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary-dark);
        }

        /* Checkbox custom style */
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            position: relative;
            cursor: pointer;
        }

        .remember-me input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: relative;
            height: 20px;
            width: 20px;
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 5px;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .remember-me:hover .checkmark {
            border-color: var(--primary-light);
        }

        .remember-me input:checked ~ .checkmark {
            background-color: var(--primary-light);
            border-color: var(--primary-light);
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .remember-me input:checked ~ .checkmark:after {
            display: block;
        }

        /* Button styles */
        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-light));
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.6);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.1) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(30deg);
            transition: all 0.3s ease;
        }

        .btn-login:hover::after {
            animation: shine 1.5s infinite;
        }

        @keyframes shine {
            0% {
                left: -100%;
                top: -100%;
            }
            100% {
                left: 100%;
                top: 100%;
            }
        }

        /* Footer links */
        .login-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .forgot-password {
            color: var(--primary-dark);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .forgot-password i {
            margin-right: 5px;
        }

        .forgot-password:hover {
            color: var(--accent-color);
            text-decoration: underline;
        }

        /* Motto section */
        .motto {
            text-align: center;
            margin-top: 30px;
            padding: 15px;
            background: linear-gradient(to right, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.1));
            border-radius: 10px;
            color: var(--primary-dark);
            font-style: italic;
            font-size: 1.1rem;
            font-weight: bold;
            letter-spacing: 1px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        /* Status messages */
        .status-message {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            animation: fadeIn 0.5s ease;
        }

        .status-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--error-color);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-message i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .error-message {
            color: var(--error-color);
            font-size: 0.85rem;
            margin-top: 8px;
            display: flex;
            align-items: center;
        }

        .error-message i {
            margin-right: 5px;
            font-size: 0.9rem;
        }

        /* Social login options */
        .social-login {
            margin-top: 30px;
            text-align: center;
        }

        .social-divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #64748b;
            font-size: 0.9rem;
        }

        .social-divider::before,
        .social-divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
            margin: 0 10px;
        }

        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
        }

        .social-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .facebook {
            background-color: #3b5998;
        }

        .google {
            background-color: #db4437;
        }

        .twitter {
            background-color: #1da1f2;
        }

        /* Responsive design */
        @media (min-width: 768px) {
            .login-wrapper {
                flex-direction: row;
                min-height: 600px;
            }
            
            .login-container {
                flex-direction: row;
                max-width: 900px;
            }
            
            .login-header {
                width: 40%;
                clip-path: polygon(0 0, 100% 0, 85% 100%, 0 100%);
                justify-content: center;
                padding: 40px;
            }
            
            .login-body {
                width: 60%;
                padding: 50px;
            }
            
            .logo-container {
                width: 150px;
                height: 150px;
            }
        }

        @media (max-width: 480px) {
            .login-body {
                padding: 30px;
            }
            
            .login-header {
                padding: 30px 0;
            }
            
            .logo-container {
                width: 100px;
                height: 100px;
            }
            
            .motto {
                font-size: 1rem;
                padding: 10px;
            }
            
            .social-buttons {
                gap: 10px;
            }
            
            .social-btn {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .login-container {
                background: rgba(15, 23, 42, 0.95);
                color: var(--text-light);
            }
            
            .form-control {
                background-color: rgba(30, 41, 59, 0.7);
                border-color: rgba(74, 85, 104, 0.5);
                color: var(--text-light);
            }
            
            .form-control:focus {
                background-color: rgba(30, 41, 59, 0.9);
            }
            
            .form-group label {
                color: var(--primary-light);
            }
            
            .checkmark {
                background-color: rgba(30, 41, 59, 0.7);
                border-color: rgba(74, 85, 104, 0.5);
            }
            
            .motto {
                background: linear-gradient(to right, rgba(245, 158, 11, 0.2), rgba(245, 158, 11, 0.3), rgba(245, 158, 11, 0.2));
                color: var(--accent-color);
            }
            
            .forgot-password {
                color: var(--primary-light);
            }
        }
    </style>
</head>

<body>
    <!-- Background animation elements -->
    <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>

    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <div class="logo-container">
                    <div class="logo-glow"></div>
                    <img src="{{ asset('Logo/tavocell-logo.jpg') }}" alt="TavoCell 504" class="logo">
                </div>
                <h2>Bienvenido a TavoCell 504</h2>
            </div>

            <div class="login-body">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="status-message status-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <div class="input-container">
                            <i class="fas fa-envelope input-icon"></i>
                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}"
                                required autofocus placeholder="tu@email.com">
                        </div>
                        @error('email')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-container">
                            <i class="fas fa-lock input-icon"></i>
                            <input id="password" class="form-control" type="password" name="password" required
                                autocomplete="current-password" placeholder="••••••••">
                            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                        </div>
                        @error('password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
                        Iniciar Sesión
                    </button>

                    <div class="login-footer">
                        @if (Route::has('password.request'))
                            <a class="forgot-password" href="{{ route('password.request') }}">
                                <i class="fas fa-key"></i>
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    <br>
                    <br>
                    

                    <div class="motto">
                        "HONRADEZ, CALIDAD Y SERVICIO"
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
        
        // Add focus effects
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('.input-icon').style.color = 'var(--primary-dark)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.querySelector('.input-icon').style.color = 'var(--primary-light)';
            });
        });
        
        // Responsive adjustment
        function adjustLayout() {
            const container = document.querySelector('.login-container');
            if (window.innerWidth >= 768) {
                container.style.flexDirection = 'row';
            } else {
                container.style.flexDirection = 'column';
            }
        }
        
        window.addEventListener('resize', adjustLayout);
        window.addEventListener('load', adjustLayout);
    </script>
</body>

</html>