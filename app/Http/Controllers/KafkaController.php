<?php

namespace App\Http\Controllers;

use App\Services\KafkaProducer;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class KafkaController extends BaseController
{
    protected $kafkaProducer;

    public function __construct(KafkaProducer $kafkaProducer)
    {
        $this->kafkaProducer = $kafkaProducer;
    }

    public function produce(Request $request)
    {
        $message = $request->input('message', 'Mensagem padrão');
        $topic = $request->input('topic', 'meu-topico');

        $result = $this->kafkaProducer->sendMessage($topic, $message);

        return response()->json(['status' => $result]);
    }
}
