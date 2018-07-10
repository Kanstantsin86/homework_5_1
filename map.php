<?php
$latitude = $_GET["latitude"];
$longitude = $_GET["longitude"];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Точка на карте</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
</head>
<body>
    <div id="map" style="width: 600px; height: 400px"></div>
        <script type="text/javascript">
        ymaps.ready(init);
        function init(){ 
            var myMap = new ymaps.Map("map", {
                center: [<?php echo $latitude;?>, <?php echo $longitude;?>],
                zoom: 8
            }); 
            var myPlacemark = new ymaps.Placemark([<?php echo $latitude;?>, <?php echo $longitude;?>], {
                //Хинт показывается при наведении мышкой на иконку метки.
                //hintContent: 'Содержимое всплывающей подсказки',
                //Балун откроется при клике по метке.
                //balloonContent: 'Содержимое балуна'
            });
            // После того как метка была создана, ее
            // можно добавить на карту.
            myMap.geoObjects.add(myPlacemark);
        }
    </script>
</body>
</html>

