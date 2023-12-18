@extends('layouts.app', ['title' => ''])


@section('content')

    <div id="quest-block" class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 m-b30">
                        Тренируйте навыки владения жестовым языком по теме &laquo;{{ $topic_name }}&raquo;.<br>
                        <button type="button" class="btn mt-3" onclick="nextQuestionHandler()">Начать прохождение теста</button>

                </div>
            </div>
        </div>
    </div>
    <div id="msgModal" class="modal fade2" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div id="answer-msg" class="mb-3">
                    </div>
                    <span id="next-btn">
                        <button type="button" class="btn mr-2" onclick="nextQuestionHandler()">Далее</button>
                    </span>
                    <a href="{{ route('training.index') }}" class="btn btn-secondry ml-2">Завершить
                    </a>
                </div>
            </div>

        </div>
    </div>


    <script>
        const topic_id = {{ $topic_id }};
        let counter_true = 0;
        let counter = 0;
        let correct_answer = 0;
        let word_id = 0;
        let type = 0;

        const nextQuestionHandler = async () => {
            document.getElementById('quest-block').innerHTML = '';
            let status = await getNextQuestion();
            if (status)
                $('#msgModal').modal('hide');
        };

        const selectHandler = async (answer) => {
            $('#msgModal').modal('show');
            await checkAnswer(answer.value);
        };

        async function setWordTrained() {
            let response = await fetch(`{{ route('training.set-word') }}`, {
                method: 'POST',
                body: JSON.stringify({'user_id': '{{ Auth::user()->id }}', 'word_id': word_id, 'type': type})
            });
        }

        async function checkAnswer(answer) {
            counter++;

            if (answer == correct_answer) {
                counter_true++;
                document.getElementById('answer-video-item-' + answer).className += ' correct-answer';
                document.getElementById('answer-msg').innerHTML = `
                <div class="complete-msg"><img src="/images/icons/complete-icon.svg" alt="Успешно">
                <span>Правильный ответ!</span>
            </div>`;
                await setWordTrained();
            } else {
                document.getElementById('answer-video-item-' + answer).className += ' wrong-answer';
                document.getElementById('answer-msg').innerHTML = `
                <div class="danger-msg"><img src="/images/icons/danger-icon.svg" alt="Ошибка">
                <span>Неверный ответ!</span>
            </div>`;
            }

            if (counter_true >= 10 || counter >= 15) {
                displayResult();
            }
        }

        function displayResult()
        {
            let result = Math.round(counter_true / counter * 100);

            if (result >= 90)
                document.getElementById('answer-msg').innerHTML = `
                <span>У вас ${result} % верных ответов!</span><br><span class="emoji-msg-res">&#127881;</span><span>Отличный результат!</span><span class="emoji-msg-res">&#127881;</span>
            `;
            else if (result > 50)
                document.getElementById('answer-msg').innerHTML = `
                <span>У вас целых ${result} % верных ответов.</span><br><span class="emoji-msg-res">&#128521;</span><span>Хорошая работа.</span><span class="emoji-msg-res">&#128521;</span>
            `;
            else
                document.getElementById('answer-msg').innerHTML = `
                <span>У вас только ${result} % верных ответов.</span><br><span class="emoji-msg-res">&#128078;</span><span>Нужно больше тренироваться.</span><span class="emoji-msg-res">&#128078;</span>
            `;

            document.getElementById('next-btn').innerHTML = ``;
        }

        async function getNextQuestion() {
            let response = await fetch(`{{ route('training.next-quest') }}`, {
                method: 'POST',
                body: JSON.stringify({'user_id': '{{ Auth::user()->id }}', 'topic_id': '{{ $topic_id }}'})
            });

            if (response.ok) {
                let res = await response.json();
                if (res.question == null) {
                    displayResult();
                    document.getElementById('answer-msg').innerHTML += `<br><span>Вы закончили обучение!</span>`;
                    return false;
                }

                correct_answer = res.control_id;
                word_id = res.word_id;
                type = res.type;

                displayQuestion(res);
            } else {
                document.getElementById('answer-msg').innerHTML += `<div class="danger-msg"><img src="/images/icons/danger-icon.svg" alt="Ошибка">
                <span>Произошла ошибка!</span>
            </div>`;
                document.getElementById('next-btn').innerHTML = ``;

                return false;
            }

            return true;
        }

        function displayQuestion(res) {
            if (res.type == 'v') {

                let items = '';
                for (let i = 0; i < res.candidates.length; i++) {
                    items += `

    <div id="answer-video-item-${res.candidates[i].control_id}" class="quest-video-grid-item">
        <input type="radio" onclick="selectHandler(this);" value="${res.candidates[i].control_id}"/>
        <video width="100%" height="100%" controls="">
            <source src="${res.candidates[i].video}" type="video/mp4">
        </video>
    </div>

                        `;
                }

                document.getElementById('quest-block').innerHTML = `
<div class="container">
    <div class="row">
            <h3 class="m-b30 col-12">${res.question}</h3>
        <h4 class="col-12">Выберете правильный ответ</h4>
        <div class="col-12">
        <div class="quest-video-grid">
        ${items}
        </div>
        </div>
    </div>
</div>
                    `;

            } else {
                let items = '';
                for (let i = 0; i < res.candidates.length; i++) {
                    items += `
                        <div id="answer-video-item-${res.candidates[i].control_id}">
                            <input type="radio" onclick="selectHandler(this);" value="${res.candidates[i].control_id}"/>
                            <label>${res.candidates[i].name}</label>
                        </div>
                        `;
                }

                document.getElementById('quest-block').innerHTML = `
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 m-b30">
                                    <h3>${res.question}</h3>
                                </div>
                                <div class="col-lg-8 col-md-6 col-sm-12 m-b30">
                                    <video width="100%" height="100%" controls="">
                                        <source src="${res.video}" type="video/mp4">
                                    </video>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 m-b30 p-3 quest-items-body">
                                <h4>Выберете правильный ответ</h4>
                                    <div id="quest-items">
                                        ${items}
                                    </div>
                                </div>
                            </div>
                        </div>
</div>
                    `;
            }
        }



        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        document.onkeydown = function(e) {
            if(event.keyCode == 123) {
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
                return false;
            }
            if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
                return false;
            }
        }
    </script>

@endsection