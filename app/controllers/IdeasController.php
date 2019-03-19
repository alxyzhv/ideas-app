<?php

namespace app\controllers;

use app\models\Idea;
use DateTime;

class IdeasController extends Controller
{
    public function view()
    {
        $id = $this->getParam('id');
        if ($id !== null) {
            $idea = Idea::findOne(['id' => $id]);
            if (empty($idea)) {
                return $this->json([
                    'error' => 'not found'
                ]);
            }
            return $this->json($this->encode($idea));
        }

        $ideas = Idea::findAll();
        $response = [
            'ideas' => []
        ];
        foreach ($ideas as $idea) {
            $response['ideas'][] = $this->encode($idea);
        }
        return $this->json($response);
    }

    public function create()
    {
        $text = $this->getParam('name');
        $idea = new Idea([
            'text' => $text,
            'likes' => 0,
            'dislikes' => 0,
            'created_at' => date("Y-m-d H:i:s", time())
        ]);
        $idea->save();

        return $this->json($this->encode($idea));
    }

    public function like()
    {
        $id = $this->getParam('id');
        if ($id !== null) {
            $idea = Idea::findOne(['id' => $id]);
            if (!empty($idea)) {
                $idea->like();
                return $this->json($this->encode($idea));
            }
        }
        return $this->json([
            'error' => 'not found'
        ]);
    }

    public function dislike()
    {
        $id = $this->getParam('id');
        if ($id !== null) {
            $idea = Idea::findOne(['id' => $id]);
            if (!empty($idea)) {
                $idea->dislike();
                return $this->json($this->encode($idea));
            }
        }
        return $this->json([
            'error' => 'not found'
        ]);
    }

    private function encode($idea)
    {
        $date = new DateTime($idea->created_at);
        $date = $date->getTimestamp();
        return [
            'id' => $idea->id,
            'text' => $idea->text,
            'likes' => $idea->likes,
            'dislikes' => $idea->dislikes,
            'created_at' => $date,
        ];
    }
}
