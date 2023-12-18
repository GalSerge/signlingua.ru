<!DOCTYPE html>
<html>
<head>
    <title>Поиск организаций и геопоиск</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--
        Укажите свой API-ключ. Тестовый ключ НЕ БУДЕТ работать на других сайтах.
        Получить ключ можно в Кабинете разработчика: https://developer.tech.yandex.ru/keys/
    -->
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=c108a624-d641-4fa5-bc87-13605f8aa04e" type="text/javascript"></script>
    <script type="text/javascript">
        function init() {
            var myMap = new ymaps.Map('map', {
                center: [55.74, 37.58],
                zoom: 13,
                controls: []
            });

            var searchControl = new ymaps.control.SearchControl({
                options: {
                    provider: 'yandex#search'
                }
            });

            myMap.controls.add(searchControl);

            myMap.events.add('click', function (e) {
                if (myMap.balloon.isOpen()) {
                    myMap.balloon.close();
                }
            });

            myMap.events.add('contextmenu', function (e) {
                if (!myMap.balloon.isOpen()) {
                    var coords = e.get('coords');
                    var coordsStr = [
                        coords[0].toPrecision(6),
                        coords[1].toPrecision(6)
                    ].join(', ');

                    document.getElementById('mapId').value = coordsStr;

                    myMap.balloon.open(coords, {
                        contentHeader: document.getElementById('wordName').value,
                        contentBody: coordsStr,
                        contentFooter: '<sup>Щелкните левой кнопкой, чтобы закрыть</sup>'
                    });
                }
            });
        }

        ymaps.ready(init);

    </script>
    <style>
        html, body, #map {
            width: 100%; height: 80%; padding: 0; margin: 0;
        }
    </style>
</head>
<body>
<div id="map"></div>
<input type="text" id="wordName" name="map" value=""/>
<input type="text" id="mapId" name="map" value=""/>
</body>
</html>
