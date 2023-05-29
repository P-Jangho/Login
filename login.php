<?php
// 데이터베이스 연결
try {
  $pdo = new PDO("sqlite:psw.db3");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("データベース接続エラー: " . $e->getMessage());
}

// POST로 전송된 데이터 확인 및 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // 사용자 인증
  $query = "SELECT * FROM pssw WHERE user_id = :username";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && $user['user_id'] === 'admin' && $password === '1999') {
    // 로그인 성공
    echo "ログインに成功しました";
    echo "<br>";
    echo '<a href="login.html">ログイン画面に戻る</a>';
    exit;
  } else {
    // 로그인 실패
    echo "ユーザーIDまたはパスワードが間違っています";
    echo "<br>";
    echo '<a href="login.html">ログイン画面に戻る</a>';
    exit;
  }
}
?>
