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

    // 사용자 인증
    $query = "SELECT * FROM pssw WHERE user_id = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['md5hash'] === md5($password)) {
        // 로그인 성공
        echo "로그인에 성공했습니다.";
        echo "<br>";
        echo '<a href="login.html">로그인 화면으로 돌아가기</a>';
        exit;
    } else {
        // 로그인 실패
        echo "사용자 이름 또는 비밀번호가 잘못되었습니다.";
        echo "<br>";
        echo '<a href="login.html">로그인 화면으로 돌아가기</a>';
        exit;
    }
}
?>
