<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Register</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      margin: 0;
      height: 100vh;
      background-color: #F5EFE9;
      background-image: url('/assets/img/gambar.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    body::after {
      content: "";
      position: fixed;
      inset: 0;
      background-color: rgba(245, 239, 233, 0.6); 
      z-index: -1;
    }

    .register-container {
      width: 420px;
      padding: 40px;
       background-color: #e6dbcf;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      /* animation: float 5s ease-in-out infinite; */
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0px);
      }
      40% {
        transform: translateY(-50px);
      }
    }

    h2 {
      text-align: center;
      color: #5c2f0b;
      margin-bottom: 30px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px 16px;
      margin-bottom: 20px;
      border: none;
      border-radius: 12px;
      background: rgba(255, 255, 255, 0.3);
      color: #333;
      font-size: 1rem;
    }

    input::placeholder {
      color: #666;
    }

    input:focus {
      background: rgba(255, 255, 255, 0.45);
      outline: none;
    }

    button {
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 12px;
      background: linear-gradient(to right, #5c2f0b, #A0522D);
      color: white;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      /* transition: transform 0.3s ease; */
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    .error {
      background: rgba(255, 0, 0, 0.2);
      color: #a00;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 15px;
      font-size: 0.95em;
      text-align: center;
    }

    .register-link {
      text-align: center;
      margin-top: 15px;
    }

    .register-link a {
      color: #5c2f0b;
      text-decoration: underline;
      font-weight: bold;
    }
  </style>
</head>
<body>
    <div class="register-container">
        <h2 style="text-align:center;">Register</h2>
        <form action="{{ route('register.submit') }}" method="POST">
            @csrf
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Daftar</button>
        </form>
    </div>
</body>
</html>
