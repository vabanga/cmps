<?php
require_once 'vendor/yandex/geo/autoload.php';

$shir = '';
$dolg = '';
$adress = '';

$api = new \Yandex\Geo\Api();


if($_POST['serch']){
    $adr = $_POST['adres'];
    $api->setQuery("$adr");
}

// Настройка фильтров
$api
    ->setLimit(1) // кол-во результатов
    ->setLang(\Yandex\Geo\Api::LANG_US) // локаль ответа
    ->load();

$response = $api->getResponse();
$response->getFoundCount(); // кол-во найденных адресов
$response->getQuery(); // исходный запрос
$response->getLatitude(); // широта для исходного запроса
$response->getLongitude(); // долгота для исходного запроса

// Список найденных точек
$collection = $response->getList();

foreach ($collection as $item) {
    $adress = $item->getAddress(); // вернет адрес
    $shir = $item->getLatitude(); // широта
    $dolg = $item->getLongitude(); // долгота
    $item->getData(); // необработанные данные
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="post">
    <input type="text" name="adres" placeholder="Введите адрес" style="width: 300px;">
    <input type="submit" name="serch" value="Искать">
</form>
<?php if(!empty($shir) and !empty($dolg) and !empty($adress)) {
    ?>
    <b>Широта: </b><?= $shir ?><br>
    <b>Долгота: </b><?= $dolg ?><br>
    <b>По адресу: </b><?= $adress?>
    <?php
}
?>
</body>
</html>

