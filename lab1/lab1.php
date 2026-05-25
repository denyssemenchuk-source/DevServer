<?php
// 1
    echo "\n Введіть масив чисел:";
    $input=trim(fgets(STDIN));
    $numbers = explode(",", $input);
    $product = 1;
    $hasNumbers = false;
    foreach ($numbers as $num) {
        if(is_numeric($num)){
            $product *= (float)$num;
            $hasNumbers = true;
        }
    }
    if($hasNumbers){
        echo "Добуток: {$product}";
    }
    else{
        echo "Не введено жодного числа";
    }

// 2
$perfectNumbers = [1, 6, 12, 28, 991, 456, 883, 123, 345, 789, 109, 234, 674, 432, 307];
$foundPerfects = [];
foreach ($perfectNumbers as $num) {
    if ($num < 6) {
        continue;
    }
    $sum = 0;
    for ($j = 1; $j <= $num / 2; $j++) {
        if ($num % $j == 0) {
            $sum += $j;
        }
    }
    if ($sum == $num) {
        $foundPerfects[] = $num;
    }
}
if (!empty($foundPerfects)) {
    echo "Знайдені досконалі числа в масиві: " . implode(', ', $foundPerfects) . "\n";
} else {
    echo "У масиві немає досконалих чисел.\n";
}


// 3
    echo "\n Введіть масив чисел:";
    $input2=trim(fgets(STDIN));
    $mass = explode(",", $input2);
    $zero_count = 0;
    foreach ($mass as $num) {
        if($num == 0){
            $zero_count++;
        }
    }
    echo "Кількість нулів у масиві:{$zero_count}";
//-------------------------------------------------------------------------------
// 4
    $randomNumbers=[];
    $sumRand= 0;
    echo "\n Масив рандомних чисел:";
    for($i = 0;$i < 20;$i++){
        $randomNumbers[]=rand(1,100);
        echo "{$randomNumbers[$i]}, ";
    }
    foreach ($randomNumbers as $num) {
        if($num%2 != 0){
           $sumRand+=pow($num,2);
        }
    }
    echo "Сума квадратів непарних чисел: {$sumRand}";

//-------------------------------------------------------------------------------
// 5
echo "\n Обмін першого та останнього елементів:\n";
$arr = [];
for ($i = 0; $i < 8; $i++) {
    $arr[] = rand(1, 100);
}

echo "Початковий масив: " . implode(', ', $arr) . "\n";

$temp = $arr[0];
$lastIndex = count($arr) - 1;

$arr[0] = $arr[$lastIndex];
$arr[$lastIndex] = $temp;

echo "Масив після обміну: " . implode(', ', $arr) . "\n";

//-------------------------------------------------------------------------------
// 6
echo "\n Середнє арифметичне додатних чисел:\n";
$arr = [];
$sum = 0;
$count = 0;

for ($i = 0; $i < 10; $i++) {
    $arr[] = rand(-50, 50);
}

echo "Масив: " . implode(', ', $arr) . "\n";

foreach ($arr as $num) {
    if ($num > 0) {
        $sum += $num;
        $count++;
    }
}

if ($count > 0) {
    $average = $sum / $count;
    echo "Середнє арифметичне: $average\n";
} else {
    echo "Додатніх чисел немає.\n";
}

//-------------------------------------------------------------------------------
// 7
echo "\n Введіть ПІБ (наприклад, Гарбузюк Олег): ";
$fullName = trim(fgets(STDIN));
$translitMap = [
    'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'h', 'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'є' => 'ie',
    'ж' => 'zh', 'з' => 'z', 'и' => 'y', 'і' => 'i', 'ї' => 'i', 'й' => 'i', 'к' => 'k', 'л' => 'l',
    'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
    'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ь' => '', 'ю' => 'iu', 'я' => 'ia',
    ' ' => '.' // Пробіл замінюємо на крапку
];
$lowerName = mb_strtolower($fullName, 'UTF-8');

$emailPrefix = strtr($lowerName, $translitMap);

$email = $emailPrefix . "@example.com";
echo "Email: $email\n";

//-------------------------------------------------------------------------------
// 8
echo "\n Введіть рік для перевірки кратності 400: ";
$year = (int)trim(fgets(STDIN));

if ($year % 400 == 0) {
    echo "Рік $year є кратним 400.\n";
} else {
    echo "Рік $year НЕ є кратним 400.\n";
}
//-------------------------------------------------------------------------------
// 9
echo "\n Робота з індексами масиву:\n";
$arr = [];
for ($i = 0; $i < 10; $i++) {
    $arr[] = rand(0, 100);
}

echo "Згенерований масив:\n";
print_r($arr);

$productEvenIndices = 1;
$hasEvenPositive = false;
$oddIndicesElements = [];

foreach ($arr as $index => $value) {
    if ($value > 0) {
        if ($index % 2 == 0) {
            $productEvenIndices *= $value;
            $hasEvenPositive = true;
        } else {
            $oddIndicesElements[] = "Індекс $index: $value";
        }
    }
}

if ($hasEvenPositive) {
    echo "Добуток елементів (>0) з парними індексами: $productEvenIndices\n";
}

echo "Елементи (>0) з непарними індексами:\n";
foreach ($oddIndicesElements as $item) {
    echo $item . "\n";
}
//-------------------------------------------------------------------------------
// 10
echo "\n Введіть рік (від 1 до 9999) для перевірки на високосність: ";
$year = (int)trim(fgets(STDIN));

if ($year >= 1 && $year <= 9999) {
    if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
        echo "Рік $year — високосний.\n";
    } else {
        echo "Рік $year — НЕ високосний.\n";
    }
} else {
    echo "Помилка: введіть рік у діапазоні від 1 до 9999.\n";
}

?>