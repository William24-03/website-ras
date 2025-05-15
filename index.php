<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Algoritma RAS: Enkripsi dan Dekripsi Nama</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(180deg, #000000, #1e2a38);
      color: #e0e6f0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 20px;
      overflow: hidden;
      position: relative;
    }

    /* Gembok jatuh */
    .lock {
      position: fixed;
      top: -20px;
      font-size: 18px;
      animation-name: fall;
      animation-timing-function: linear;
      animation-iteration-count: infinite;
      opacity: 0.9;
    }

    @keyframes fall {
      0% {
        transform: translateY(0);
        opacity: 0.9;
      }
      100% {
        transform: translateY(120vh);
        opacity: 0;
      }
    }

    header {
      margin-bottom: 40px;
      text-align: center;
      text-shadow: 0 2px 6px rgba(0,0,0,0.7);
      z-index: 10;
      position: relative;
    }

    header h1 {
      font-weight: 600;
      font-size: 2.4rem;
      letter-spacing: 1px;
      margin: 0;
      user-select: none;
      color: #c0d8ff;
    }

    .container {
      background: rgba(30, 42, 56, 0.85);
      backdrop-filter: blur(12px);
      border-radius: 20px;
      padding: 30px 40px;
      width: 100%;
      max-width: 480px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.85);
      display: flex;
      flex-direction: column;
      align-items: stretch;
      z-index: 10;
      position: relative;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-bottom: 25px;
    }

    input[type="text"] {
      padding: 14px 20px;
      border-radius: 15px;
      border: none;
      font-size: 1rem;
      font-weight: 500;
      outline: none;
      background: rgba(255,255,255,0.15);
      color: #d7e3ff;
      box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }

    input[type="text"]::placeholder {
      color: #a3b1cc;
      font-style: italic;
    }

    input[type="text"]:focus {
      box-shadow: inset 0 0 10px #6ea0ff;
      background: rgba(255,255,255,0.25);
      color: #fff;
    }

    .button-group {
      display: flex;
      gap: 15px;
      justify-content: space-between;
    }

    button {
      flex: 1;
      background: linear-gradient(145deg, #5878c7, #39548a);
      border: none;
      border-radius: 15px;
      padding: 14px 0;
      font-weight: 700;
      font-size: 1rem;
      color: #d7e3ff;
      cursor: pointer;
      box-shadow: 0 6px 12px rgba(30, 45, 90, 0.8);
      transition: all 0.3s ease;
      user-select: none;
      text-align: center;
    }

    button:hover {
      background-color: #000000 !important;
      color: #ffffff !important;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.8);
      transform: translateY(-2px);
    }

    button:active {
      background-color: #000000;
      color: #a3b1cc;
      transform: translateY(1px);
    }

    .result {
      background: rgba(30, 42, 56, 0.6);
      border-radius: 15px;
      padding: 20px 25px;
      font-size: 1.1rem;
      font-weight: 600;
      color: #cbd7ff;
      text-shadow: 0 1px 3px rgba(0,0,0,0.7);
      word-break: break-word;
      box-shadow: inset 0 0 15px rgba(105, 125, 165, 0.4);
      user-select: text;
      min-height: 60px;
    }
  </style>
</head>
<body>

  <header>
    <h1>Algoritma RAS: Enkripsi dan Dekripsi Nama</h1>
  </header>

  <div class="container">
    <form method="POST" autocomplete="off" spellcheck="false">
      <input type="text" name="input_name" placeholder="Masukkan nama..." required />
      <div class="button-group">
        <button type="submit" name="encrypt">🔒Enkripsi</button>
        <button type="submit" name="decrypt">🔓Dekripsi</button>
      </div>
    </form>

    <?php
    function encryptRAS($text) {
      $result = [];
      for ($i = 0; $i < strlen($text); $i++) {
        $binary = str_pad(decbin(ord($text[$i])), 8, "0", STR_PAD_LEFT);
        $result[] = $binary;
      }
      return implode(' ', $result);
    }

    function decryptRAS($binary) {
      $text = '';
      $chunks = explode(' ', $binary);
      foreach ($chunks as $chunk) {
        if (preg_match('/^[01]{8}$/', $chunk)) {
          $text .= chr(bindec($chunk));
        }
      }
      return $text;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = $_POST["input_name"];
      $result = "";

      if (isset($_POST["encrypt"])) {
        $result = encryptRAS($name);
      } elseif (isset($_POST["decrypt"])) {
        $result = decryptRAS($name);
      }

      echo '<div class="result"><strong>Hasil:</strong><br>' . htmlspecialchars($result) . '</div>';
    }
    ?>
  </div>

  <script>
    const numLocks = 30;
    for(let i = 0; i < numLocks; i++) {
      const lock = document.createElement('div');
      lock.classList.add('lock');
      lock.textContent = '🔒';
      lock.style.left = Math.random() * 100 + 'vw';
      lock.style.animationDuration = (Math.random() * 8 + 8) + 's';
      lock.style.animationDelay = (Math.random() * 10) + 's';
      document.body.appendChild(lock);
    }
  </script>

</body>
</html>
