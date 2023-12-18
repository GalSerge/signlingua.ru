function init() {
    var myMap = new ymaps.Map('map', {
        center: [46.35, 48.03],
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

            document.getElementById('input_latitude').value = coords[0].toPrecision(6);
            document.getElementById('input_longitude').value = coords[1].toPrecision(6);

            myMap.balloon.open(coords, {
                contentHeader: '',
                contentBody: [
                    coords[0].toPrecision(6),
                    coords[1].toPrecision(6)
                ].join(', '),
                contentFooter: '<sup>Щелкните левой кнопкой мыши, чтобы закрыть</sup>'
            });
        }
    });
}

ymaps.ready(init);