ymaps.ready(init);
var myMap = null;

function init() {
    myMap = new ymaps.Map('map', {
        center: [55.753994, 37.622093],
        zoom: 4,
        controls: []
    });
}

function setWordRegions(word_id) {
    let word = words.find(obj => obj.id == word_id);

    if (word) {
        myMap.geoObjects.removeAll();

        for (let i = 0; i < word.regions.length; i++) {
            var videoSrc = `/storage/videos/words/${word.tag}_${word.id}_${word.regions[i].id}.mp4`;
            var myPlacemark = new ymaps.Placemark([word.regions[i].latitude, word.regions[i].longitude], {
                balloonContentHeader: word.regions[i].name,
                iconCaption: word.regions[i].name,
                balloonContentBody: `<video width="100%" height="100%" controls> <source src="${videoSrc}" type="video/mp4"></sourse> </video>`,
            });

            myMap.geoObjects
                .add(myPlacemark);
        }
    }

}

const onChangeHandler = async () => {
    await searchWord();
};

async function searchWord() {
    document.getElementById('words-list').innerHTML = '';

    if (document.getElementById('search-word-input').value == '') {
        for (let i = 0; i < words.length; i++) {
            document.getElementById('words-list').innerHTML +=
                `<a href="##" class="btn m-1 px-2" onclick="setWordRegions('${words[i]['id']}')">${words[i]['text']}</a>`;
        }
        return;
    }

    let response = await fetch(`${search_url}?q=${document.getElementById('search-word-input').value}&topic=${topic_id}`, {
        method: 'GET',
    });

    if (response.ok) {
        let result = await response.json();

        if (result.length == 0)
            document.getElementById('words-list').innerHTML += `<p>Ничего не найдено...</p>`

        for (let i = 0; i < result.length; i++) {
            document.getElementById('words-list').innerHTML +=
                `<a href="##" class="btn m-1 px-2" onclick="setWordRegions('${result[i]['id']}')">${result[i]['text']}</a>`;
        }
    }
}