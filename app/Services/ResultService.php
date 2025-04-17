<?php

namespace App\Services;

use App\Models\User;
use App\Models\Game;
use App\Models\Answer;
use App\Models\Result;
use Symfony\Component\HttpFoundation\Response;

class ResultService 
{

    public static function resultUser(array $data){
        $user = User::find($data['user_id']);
        $game = Game::with('question')->find($data['game_id']);

        if ($game->mode !== 'competitive') {
            return null;
        }

        $questions = $game->question->pluck('id');
        $answers = Answer::where('user_id', $user->id)
                            ->whereIn('question_id', $game->question->pluck('id'))
                            ->get();

        $achieved_score = 0;

        if ($answers->count() < $questions->count()) {
            return response()->json( [ 'error' => 'O jogador ainda não respondeu todas as questões.' ], Response::HTTP_OK);
        }

        foreach($answers as $answer){
            if($answer->is_correct === 'correct'){
                $achieved_score += $answer->question->score ?? 0;
            }
        }

        $result = Result::updateOrCreate([
            'user_id' => $user->id,
            'game_id' => $game->id,
            'achieved_score' => $achieved_score
        ]);

        return $result;
    }
}