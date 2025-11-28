@extends('layouts.app')

@section('hideNavbar', true)
@section('fullWidth', true)


@section('content')
    <style>
        :root {
            --dark: #27374D;
            --medium: #526D82;
            --light: #9DB2BF;
            --lightest: #DDE6ED;
        }

        body {
            background: var(--lightest);
            font-family: 'Segoe UI', sans-serif;
        }

        .auth-container {
            width: 850px;
            max-width: 95%;
            margin: 40px auto;
            display: flex;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .auth-container:hover {
            transform: translateY(-5px);
        }

        .buttons {
            margin-top: 23px;
        }

        /* LEFT PANEL */
        .side-panel {
            width: 40%;
            background: linear-gradient(135deg, var(--medium), var(--dark));
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px;
        }

        .side-panel h2 {
            font-size: 26px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .side-panel p {
            font-size: 15px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .side-panel button {
            padding: 12px 30px;
            background: white;
            color: var(--dark);
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .side-panel button:hover {
            background: var(--lightest);
        }

        /* FORM SIDE */
        .form-section {
            width: 60%;
            padding: 50px;
            background: var(--lightest);
            min-height: 420px;
        }

        .form-section h2 {
            text-align: center;
            margin-bottom: 25px;
            color: var(--dark);
            font-weight: 700;
        }

        .form-section input {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border-radius: 8px;
            border: 1px solid var(--light);
            outline: none;
            background: white;
            transition: border 0.3s ease, box-shadow 0.3s ease;
        }

        .form-section input:focus {
            border-color: var(--medium);
            box-shadow: 0 0 6px rgba(82, 109, 130, 0.4);
        }

        .form-section button {
            width: 100%;
            padding: 12px;
            background: var(--medium);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-section button:hover {
            background: var(--dark);
        }

        .switch-link {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: var(--dark);
        }

        .switch-link span {
            color: var(--medium);
            font-weight: 600;
            cursor: pointer;
        }

        .auth-logo {
            width: 30px;
            height: auto;
            position: absolute;
            left: 20.5%;
            top: 13%;
            /* margin-bottom: 20px; */
            filter: drop-shadow(0px 3px 5px rgba(0, 0, 0, 0.2));
            transition: transform 0.3s ease;
            z-index: 999;
        }

        .auth-logo:hover {
            transform: scale(1.05);
        }
    </style>

    {{-- <img src="{{ asset('logo/logo.png') }}" class="auth-logo" alt="Website Logo"> --}}
    <div class="auth-container" id="authBox">

        <div class="side-panel" id="sidePanel">
            <h2 id="panelTitle">Welcome Back!</h2>
            <p id="panelText">To stay connected, please login with your details.</p>
            <p id="panelText2" style="color: #E5DED1; font-weight: 500;">Don't have an account yet?</p>
            <button onclick="toggleSlide()" id="panelBtn">Sign Up</button>
        </div>

        <div class="form-section" id="formSection">

            <div id="loginForm">
                <h2>Sign In</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="email" name="email" placeholder="Email" required autofocus>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="buttons">Login</button>
                </form>
                {{-- <div class="switch-link">
                    Don't have an account? <span onclick="toggleSlide()">Register</span>
                </div> --}}
            </div>

            <div id="registerForm" style="display:none;">
                <h2>Create Account</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="text" name="name" placeholder="Full Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                    <button type="submit" class="buttons">Register</button>
                </form>
                {{-- <div class="switch-link">
                    Already have an account? <span onclick="toggleSlide()">Login</span>
                </div> --}}
            </div>
        </div>
    </div>

    <script>
        function toggleSlide() {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const panelTitle = document.getElementById('panelTitle');
            const panelText = document.getElementById('panelText');
            const panelText2 = document.getElementById('panelText2');
            const panelBtn = document.getElementById('panelBtn');

            if (loginForm.style.display === "none") {
                loginForm.style.display = "block";
                registerForm.style.display = "none";
                panelTitle.textContent = "Welcome Back!";
                panelText.textContent = "To stay connected, please login with your details.";
                panelText2.textContent = "Don't have an account?";
                panelBtn.textContent = "Sign Up";
            } else {
                loginForm.style.display = "none";
                registerForm.style.display = "block";
                panelTitle.textContent = "Hello, Friend!";
                panelText.textContent = "Enter your details and start your journey with us.";
                panelText2.textContent = "Already have an account?"
                panelBtn.textContent = "Sign In";
            }
        }
    </script>
@endsection
