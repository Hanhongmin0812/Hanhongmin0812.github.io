<?php
date_default_timezone_set('Asia/Seoul');

// MySQL 연결 정보 (네 환경에 맞게 수정)
$host = 'localhost';
$db   = 'ticket';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("DB 연결 실패: " . $e->getMessage());
}

// 티켓 가격 정보
$prices = [
    "입장권" => ["child" => 7000, "adult" => 10000],
    "BIG3" => ["child" => 12000, "adult" => 18000],
    "자유이용권" => ["child" => 21000, "adult" => 28000],
    "연간이용권" => ["child" => 70000, "adult" => 90000],
];

$total_child = 0;
$total_adult = 0;
$total_price = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['customer_name'];

    // 트랜잭션 시작
    $pdo->beginTransaction();

    try {
        foreach ($prices as $type => $price) {
            $c = intval($_POST[$type . "_child"]);
            $a = intval($_POST[$type . "_adult"]);

            if ($c === 0 && $a === 0) continue; // 구매없으면 저장 안함

            $total_child += $c;
            $total_adult += $a;
            $item_price = ($c * $price['child']) + ($a * $price['adult']);
            $total_price += $item_price;

            $stmt = $pdo->prepare("INSERT INTO ticket (customer_name, ticket_type, child_qty, adult_qty, total_price) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $type, $c, $a, $item_price]);
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        die("저장 중 오류 발생: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>티켓 예매</title>
    <style>
        body {
            font-family: 'Malgun Gothic', sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px 10px;
            text-align: center;
        }

        input[type="text"] {
            width: 80px;
            font-size: 12px;
            margin-left: 8px;
        }

        input[type="submit"] {
            margin-left: 260px;
        }

        .result {
            margin-top: 20px;
            font-size: 12px;
        }

        /* 가격에 오른쪽 경계선 */
        .price-select-wrapper span.price {
            padding: 0 8px;
            border-right: 1px solid #000;
            user-select: none; /* 가격 텍스트 선택 방지 */
        }

        /* select 박스 좌측 여백 */
        .price-select-wrapper select {
            margin-left: 10px;
        }
    </style>
</head>
<body>

<form method="post">
    고객성명 <input type="text" name="customer_name" required>
    <input type="submit" value="합계">
    <br><br>

    <table>
        <tr>
            <th>No</th>
            <th>구분</th>
            <th>어린이</th>
            <th>어른</th>
            <th>비고</th>
        </tr>
        <?php
        $index = 1;
        foreach ($prices as $type => $price) {
            echo "<tr>
                <td>{$index}</td>
                <td>{$type}</td>
                <td>
                    <div class='price-select-wrapper'>
                        <span class='price'>{$price['child']}</span>
                        <select name='{$type}_child'>";
            for ($i = 0; $i <= 10; $i++) echo "<option>$i</option>";
            echo "      </select>
                    </div>
                </td>";

            echo "<td>
                    <div class='price-select-wrapper'>
                        <span class='price'>{$price['adult']}</span>
                        <select name='{$type}_adult'>";
            for ($i = 0; $i <= 10; $i++) echo "<option>$i</option>";
            echo "      </select>
                    </div>
                </td>";

            $memo = "입장";
            if ($type === "BIG3") $memo = "입장+이용3종";
            elseif ($type === "자유이용권" || $type === "연간이용권") $memo = "입장+이용자유";

            echo "<td>{$memo}</td></tr>";
            $index++;
        }
        ?>
    </table>
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <div class="result">
        <br>
        <?= date("Y년 m월 d일 A h:i") ?> <br>
        <?= htmlspecialchars($name) ?> 고객님 감사합니다. <br>

        <?php
        // 구매한 티켓 수량별로 출력
        foreach ($prices as $type => $price) {
            $c = intval($_POST[$type . "_child"]);
            $a = intval($_POST[$type . "_adult"]);

            if ($c > 0) {
                echo "어린이 {$type} {$c}매<br>";
            }
            if ($a > 0) {
                echo "어른 {$type} {$a}매<br>";
            }
        }
        ?>

        합계 <?= number_format($total_price) ?>원입니다.
    </div>
<?php endif; ?>

</body>
</html>
