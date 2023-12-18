<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

use App\Models\User;
use App\Models\Topic;
use App\Models\Word;
use App\Models\Region;
use App\Models\Constant;


class TrainingController extends Controller
{
    public function getNumberRepeats(): array
    {
        $constants = Constant::find(1);

        return [
            'v' => $constants->repeat_train_v,
            'r' => $constants->repeat_train_r,
            'w' => $constants->repeat_train_w
        ];
    }

    public function index(Request $request): View
    {
        $repeat = $this->getNumberRepeats();

        $allTopics = Topic::withCount('words')->where('active', 1)->get()->toArray();

        $userTopics =
            User::selectRaw('SUM(check_v + check_r + check_w) AS checked_sum, topic_word.topic_id AS id')
                ->join('user_word', 'users.id', '=', 'user_word.user_id')
                ->join('words', 'words.id', '=', 'user_word.word_id')
                ->join('topic_word', 'words.id', '=', 'topic_word.word_id')
                ->where('users.id', $request->user()->id)
                ->groupBy('topic_word.topic_id')
                ->get()
                ->toArray();

        foreach ($allTopics as $key => $topic)
        {
            $allTopics[$key]['progress'] = 0;

            foreach ($userTopics as $userTopic)
            {
                if ($topic['id'] == $userTopic['id'])
                {
                    $allTopics[$key]['progress'] =
                        round($userTopic['checked_sum'] / ($topic['words_count'] * array_sum($repeat)) * 100);

                    if ($allTopics[$key]['progress'] > 100)
                        $allTopics[$key]['progress'] = 100;

                    break;
                }
            }
        }

        return view('profile.pages.progress', ['topics' => $allTopics]);
    }

    public function train(string $topicId): View
    {
        $topic = Topic::findOrFail($topicId);

        return view('profile.pages.training', ['topic_id' => $topicId, 'topic_name' => $topic['name']]);
    }

    private function getWordCandidates(string $topicId, string $wordId)
    {
        $words = Word::select('words.*')
            ->join('topic_word', 'words.id', '=', 'topic_word.word_id')
            ->where('words.id', '!=', $wordId)
            ->where('topic_word.topic_id', $topicId)
            ->inRandomOrder()
            ->limit(3)
            ->get()
            ->toArray();

        $result = [];
        foreach ($words as $word)
            $result[] = [
                'name' => $word['text'],
                'control_id' => $word['id'],
            ];

        return $result;
    }

    private function getRegionCandidates(string $regionId): array
    {
        $regions = Region::select('id', 'name')
            ->where('id', '!=', $regionId)
            ->inRandomOrder()
            ->limit(3)
            ->get()
            ->toArray();

        $result = [];
        foreach ($regions as $region)
            $result[] = [
                'name' => $region['name'],
                'control_id' => $region['id'],
            ];

        return $result;
    }

    private function getVideoCandidates(string $topicId, string $regionId): array
    {
        $words = Word::selectRaw('words.tag, words.id, region_word.region_id')
            ->join('topic_word', 'words.id', '=', 'topic_word.word_id')
            ->join('region_word', 'words.id', '=', 'region_word.word_id')
            ->where('topic_word.topic_id', $topicId)
            ->where('region_word.region_id', '!=', $regionId)
            ->inRandomOrder()
            ->limit(3)
            ->get()
            ->toArray();

        $result = [];
        foreach ($words as $word)
            $result[] = [
                'video' => '/storage/videos/words/' . $word['tag'] . '_' . $word['id'] . '_' . $word['region_id'] . '.mp4',
                'control_id' => $word['region_id'],
            ];

        return $result;
    }

    public function getNewQuestion(Request $request): \Illuminate\Http\JsonResponse|Response
    {
        $params = $request->json()->all();

        if (isset($params['user_id']) && isset($params['topic_id']))
            $question = $this->createQuestion($params['topic_id'], $params['user_id']);
        else
            return response('Bad request', 400);

        return response()->json($question);
    }

    public function createQuestion(string $topicId, string $userId): array
    {
        $repeat = $this->getNumberRepeats();

        $untrained = [];

        $userWords = DB::table('user_word')->select('*')->where('user_id', $userId);

        $word = Topic::selectRaw('
     `user_words`.`check_v`,
    `user_words`.`check_r`,
    `user_words`.`check_w`,
    `user_words`.`user_id`,
    `words`.*,
    `words`.`id` AS `word_id`,
    `regions`.`id` AS `region_id`,
    `regions`.`name` AS `region_name`,
    `regions`.`in_name` AS `region_in_name`')
            ->join('topic_word', 'topics.id', '=', 'topic_word.topic_id')
            ->join('words', 'words.id', '=', 'topic_word.word_id')
            ->leftJoinSub($userWords, 'user_words', function (JoinClause $join) {
                $join->on('words.id', '=', 'user_words.word_id');
            })
            ->join('region_word', 'words.id', '=', 'region_word.word_id')
            ->join('regions', 'regions.id', '=', 'region_word.region_id')
            ->where('topics.id', $topicId)
            ->where(function (Builder $query) use ($repeat, $userId) {
                $query
                    ->whereNull('user_words.user_id')
                    ->orWhereRaw('(check_v + check_r + check_w) < ' . array_sum($repeat));

            })
            ->inRandomOrder()
            ->limit(1)
            ->get()
            ->toArray();

        if (count($word) == 1)
            $word = $word[0];
        else
            return ['question' => null];

        if ($word['user_id'] == null || $word['user_id'] != $userId)
        {
            $this->addNewWordForTrain($userId, $word['word_id']);
            $untrained = array_keys($repeat);
        } else
        {
            foreach ($repeat as $type => $num)
                if ((int)$word['check_' . $type] < $num)
                    $untrained[] = $type;
        }

        $type = $untrained[array_rand($untrained)];

        $result = ['type' => $type, 'word_id' => $word['word_id']];

        switch ($type)
        {
            case 'v':
                $result['candidates'] = $this->getVideoCandidates($topicId, $word['region_id'], $word['id']);
                $result['candidates'][] = [
                    'video' => '/storage/videos/words/' . $word['tag'] . '_' . $word['word_id'] . '_' . $word['region_id'] . '.mp4',
                    'control_id' => $word['region_id'],
                ];
                shuffle($result['candidates']);

                $result['question'] = 'Как обозначается слово &laquo;' . $word['text'] . '&raquo; в ' . $word['region_in_name'] . '?';
                $result['control_id'] = $word['region_id'];
                break;
            case 'r':
                $result['candidates'] = $this->getRegionCandidates($word['region_id']);
                $result['candidates'][] = [
                    'name' => $word['region_name'],
                    'control_id' => $word['region_id'],
                ];
                shuffle($result['candidates']);

                $result['question'] = 'В каком регионе слово &laquo;' . $word['text'] . '&raquo; имеет следующее обозначение?';
                $result['video'] = '/storage/videos/words/' . $word['tag'] . '_' . $word['word_id'] . '_' . $word['region_id'] . '.mp4';

                $result['control_id'] = $word['region_id'];
                break;
            case 'w':
                $result['candidates'] = $this->getWordCandidates($topicId, $word['id']);
                $result['candidates'][] = [
                    'name' => $word['text'],
                    'control_id' => $word['word_id'],
                ];
                shuffle($result['candidates']);

                $result['question'] = 'В ' . $word['region_in_name'] . ' такое обозначение имеет слово ...';
                $result['video'] = '/storage/videos/words/' . $word['tag'] . '_' . $word['word_id'] . '_' . $word['region_id'] . '.mp4';

                $result['control_id'] = $word['id'];
                break;
        }

        return $result;
    }

    public function addNewWordForTrain(string $userId, string $wordId): void
    {
        $user = User::findOrFail($userId);
        $user->words()->attach($wordId);
    }

    public function setWordTrained(Request $request): Response
    {
        $params = $request->json()->all();

        if (isset($params['user_id']) && isset($params['word_id']) && isset($params['type']) && in_array($params['type'], ['v', 'w', 'r']))
        {
            $type = 'check_' . $params['type'];
            $user = User::findOrFail($params['user_id']);

            $word = DB::table('user_word')
                ->select('*')
                ->where('user_word.word_id', $params['word_id'])
                ->where('user_word.user_id', $params['user_id'])
                ->first();
            
            if ($word == null)
                return response('Bad request', 400);

            $user->words()
                ->syncWithoutDetaching([$params['word_id'] => [$type => (int)$word->$type + 1]]);

            return response('Ok', 200);
        } else
            return response('Bad request', 400);
    }

    public function resetTraining(Request $request, string $id): RedirectResponse
    {
        $words = DB::table('topic_word')
            ->select('word_id')
            ->where('topic_id', $id)
            ->get()
            ->pluck('word_id')
            ->toArray();

        $request->user()->words()->detach($words);

        return redirect()->route('training', $id);
    }
}

