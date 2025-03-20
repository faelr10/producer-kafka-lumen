<?php

namespace App\Services;

use RdKafka\Producer;
use RdKafka\ProducerTopic;

class KafkaProducer
{
    private $producer;

    public function __construct()
    {
        $conf = new \RdKafka\Conf();
        $conf->set('metadata.broker.list', env('KAFKA_BROKER', 'kafka:9092'));

        $this->producer = new Producer($conf);
    }

    public function sendMessage(string $topicName, string $message)
    {
        $topic = $this->producer->newTopic($topicName);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
        $this->producer->flush(1000); // Garante que a mensagem seja enviada

        return "Mensagem enviada para o tópico: $topicName";
    }
}
