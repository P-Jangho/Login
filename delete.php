<?php
// 데이터베이스 연결
try {
  $pdo = new PDO("sqlite:psw_v2.db3");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("データベース接続エラー: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // 사용자 인증
  $query = "SELECT * FROM pssw WHERE user_id = :username";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && $user['md5hash'] === md5($password)) {
    // 비밀번호 일치하여 회원 탈퇴 진행
    $deleteQuery = "DELETE FROM pssw WHERE user_id = :username";
    $deleteStmt = $pdo->prepare($deleteQuery);
    $deleteStmt->bindParam(':username', $username);
    $deleteStmt->execute();

    echo "회원탈퇴가 완료되었습니다.";
    echo "<br>";
    echo '<a href="login.html">로그인 화면으로 돌아가기</a>';
    exit;
  } else {
    // 비밀번호 불일치
    echo "비밀번호가 일치하지 않습니다.";
    echo "<br>";
    echo '<a href="login.html">회원탈퇴 화면으로 돌아가기</a>';
    exit;
  }
}
?>
