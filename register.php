<?php
// 데이터베이스 연결
try {
    $pdo = new PDO("sqlite:psw_v2.db3");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("데이터베이스 연결 오류: " . $e->getMessage());
}

// POST로 전송된 데이터 확인 및 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 비밀번호를 해시화하여 저장
    $md5hash = md5($password);

    // 사용자 정보를 데이터베이스에 삽입
    $query = "INSERT INTO pssw (user_id, md5hash) VALUES (:username, :md5hash)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':md5hash', $md5hash);
    $stmt->execute();

    echo "회원가입이 완료되었습니다.";
    echo "<br>";
    echo '<a href="login.html">로그인 화면으로 돌아가기</a>';
    exit;
}
?>
