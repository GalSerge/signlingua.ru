<input type="text" class="form-control" onchange="onChangeHandler()" id="search_word_input"/>
<div id="search_word_results">
</div>

<script>
    const onChangeHandler = async () => {
        await searchWord();
    };

    async function searchWord() {
        document.getElementById('search_word_results').innerHTML = '';

        let response = await fetch(`{{ route('words.search') }}?q=${document.getElementById('search_word_input').value}`, {
            method: 'GET',
        });

        if (response.ok) {
            let result = await response.json();

            for (let i = 0; i < result.length; i++) {
                document.getElementById('search_word_results').innerHTML +=
                    `${result[i]['text']} <a href="/admin/words/${result[i]['id']}/edit">Редактировать</a> <a href="/admin/words/${result[i]['id']}">Удалить</a>`;
            }
        }
    }

</script>