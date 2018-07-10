<?php
require __DIR__ . '/vendor/autoload.php';

if (isset($_POST['address'])) {
    $address = $_POST['address'];
} else {
    $address = 'Москва';
}

$api = new \Yandex\Geo\Api();
// Можно искать по точке
//$api->setPoint(30.5166187, 50.4452705);
// Или можно икать по адресу
$api->setQuery($address);
// Настройка фильтров
$api
    ->setLimit(100) // кол-во результатов
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
    //$item->getAddress(); // вернет адрес
    $item->getLatitude(); // широта
    $item->getLongitude(); // долгота
    //$item->getData(); // необработанные данные
    $coordinats[] = [$item->getLatitude(), $item->getLongitude()];
    $json = json_encode($coordinats);
}
    //print_r($coordinats);
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
  
<title>Поиск по адресу</title>
</head> 
<body>
<form name="test" method="post" action="">
    <p><b>Введите адрес:</b><br>
   <input type="text" size="40" name="address">
   <button type="submit" name="search">Найти</button>
</form>
<table>
    
    <thead>
    <tr><th>Варианты координат введенного адреса:</th></tr>
    </thead>
    <tbody>
    <tr><td>Широта</td><td>Долгота</td><td>Ссылка</td><tr>
    <?php foreach ($coordinats as $value) {
            echo '<tr><td>' . $value[0] . '</td>' . '<td>'. $value[1] .'</td><td><a href="http://localhost/homework_5_1/map.php?latitude='.$value[0].'&longitude='.$value[1]. '">Показать на карте</a></td></tr>';
    }?>
    </tbody>
</table>
<div id="map" style="width: 600px; height: 400px"></div>
<script type="text/javascript">
  // Функция ymaps.ready() будет вызвана, когда
  // загрузятся все компоненты API, а также когда будет готово DOM-дерево.
    ymaps.ready(init);
        function init(){ 
        // Создание карты.    
        var myMap = new ymaps.Map("map", {
            // Координаты центра карты.
            // Порядок по умолчнию: «широта, долгота».
            // Чтобы не определять координаты центра карты вручную,
            // воспользуйтесь инструментом Определение координат.
            center: [<?php echo $item->getLatitude();?>, <?php echo $item->getLongitude();?>],
            // Уровень масштабирования. Допустимые значения:
            // от 0 (весь мир) до 19.
            zoom: 4
        });
        var coords = <?php echo $json;?>;
        var myCollection = new ymaps.GeoObjectCollection({}, {
            preset: 'islands#redIcon', //все метки красные
            draggable: true // и их можно перемещать
        });
        for (var i = 0; i < coords.length; i++) {
            myCollection.add(new ymaps.Placemark(coords[i]));
        }
        myMap.geoObjects.add(myCollection);
        }
</script>
</body> 
</html>