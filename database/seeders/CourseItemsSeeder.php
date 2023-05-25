<?php

namespace Database\Seeders;

use App\Courses\Models\Course;
use App\Courses\Models\CourseItems;
use App\Courses\Models\TypeOfItems;
use App\Courses\Quizzes\Models\Option;
use App\Courses\Quizzes\Models\Question;
use App\Courses\Quizzes\Models\Quiz;
use Illuminate\Database\Seeder;

class CourseItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $recordCount = 100;
        $fakeText = "Перед настройкой коммутатора необходимо включить его и разрешить ему пройти через пять шагов последовательности загрузки. Этот раздел посвящен основам настройки коммутатора и включает в себя лабораторную работу в конце.После включения коммутатор Cisco проходит следующие стадии загрузки:\r\n Шаг 1: Во-первых, коммутатор загружает программу самопроверки питания (POST), хранящуюся в ПЗУ. POST проверяет подсистему CPU. Он проверяет процессор, DRAM и часть флэш-устройства, которая составляет файловую систему флэш-памяти.\r\n Шаг 2: После этого на коммутаторе запускается программное обеспечение начального загрузчика. Начальный загрузчик — это небольшая программа, которая хранится в ПЗУ и запускается сразу после успешного завершения проверки POST.\r\n Шаг 3: Начальный загрузчик выполняет низкоуровневую инициализацию центрального процессора. Он инициализирует регистры ЦП, которые контролируют место отображения физической памяти, количество памяти и ее скорость.\r\n Шаг 4: Затем программа запускает файловую систему флеш-памяти на материнской плате.\r\n Шаг 5: Наконец, начальный загрузчик находит и загружает образ операционной системы IOS по умолчанию и передает ей управление коммутатором.";


        $quiz = Quiz::insert(['count_questions_to_pass' => 3]);
        $question1 = Question::insert(['question_body'=>'Каковы преимущества SSH по сравнению с Telnet?', 'quiz_id'=>1]);
        $question2 = Question::insert(['question_body'=>'Какая команда будет предоставлять информацию о состоянии всех интерфейсов, включая количество гигантских и карликовых кадров и коллизий на интерфейсе?', 'quiz_id'=>1]);
        $question3 = Question::insert(['question_body'=>'Какое первое действие в последовательности загрузки при включении коммутатора?', 'quiz_id'=>1]);
        $question4 = Question::insert(['question_body'=>'Какое утверждение описывает SVI?', 'quiz_id'=>1]);

        $quesion1Option1 = Option::insert(['question_id' => 1, 'is_correct'=>true, 'option_body'=>'шифрование']);
        $quesion1Option2 = Option::insert(['question_id' => 1, 'is_correct'=>false, 'option_body'=>'сервисы с установлением соедиения']);
        $quesion1Option3 = Option::insert(['question_id' => 1, 'is_correct'=>false, 'option_body'=>'аутентификация имени пользователя и пароля']);
        $quesion1Option4 = Option::insert(['question_id' => 1, 'is_correct'=>false, 'option_body'=>'больше линий подключения']);

        $quesion2Option2 = Option::insert(['question_id' => 2, 'is_correct'=>false, 'option_body'=>'show history']);
        $quesion2Option1 = Option::insert(['question_id' => 2, 'is_correct'=>true, 'option_body'=>'show interfaces']);
        $quesion2Option3 = Option::insert(['question_id' => 2, 'is_correct'=>false, 'option_body'=>'show ip interface brief']);
        $quesion2Option4 = Option::insert(['question_id' => 2, 'is_correct'=>false, 'option_body'=>'show running-config']);


        $quesion3Option1 = Option::insert(['question_id' => 3, 'is_correct'=>false, 'option_body'=>'низкоуровневая инициализация процессора']);
        $quesion3Option2 = Option::insert(['question_id' => 3, 'is_correct'=>true, 'option_body'=>'загрузить программу самотестирования при включении питания']);
        $quesion3Option3 = Option::insert(['question_id' => 3, 'is_correct'=>false, 'option_body'=>'поиск и загрузка программного обеспечения Cisco IOS']);
        $quesion3Option4 = Option::insert(['question_id' => 3, 'is_correct'=>false, 'option_body'=>'Запуск ПО начального загрузчика']);

        $quesion4Option1 = Option::insert(['question_id' => 4, 'is_correct'=>false, 'option_body'=>'SVI создается автоматически для каждой VLAN многоуровневого коммутатора.']);
        $quesion4Option2 = Option::insert(['question_id' => 4, 'is_correct'=>false, 'option_body'=>'При создании SVI автоматически создается связанная VLAN.']);
        $quesion4Option3 = Option::insert(['question_id' => 4, 'is_correct'=>true, 'option_body'=>'SVI по умолчанию создается для VLAN 1 для администрирования коммутатора.']);
        $quesion4Option4 = Option::insert(['question_id' => 4, 'is_correct'=>false, 'option_body'=>'SVI может быть создан только для управляющей VLAN.']);

        CourseItems::insert([
            [
                'course_id' => 1,
                'type_id' => 1,
                'title' => 'Последовательность загрузки коммутатора',
                'item_content' => json_encode($fakeText),
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'course_id' => 1,
                'type_id' => 2,
                'title' => 'Последовательность загрузки коммутатора',
                'item_content' => json_encode('storage/video/1/EXC73e4UOv6lfRde7nA5S1tYnFF7rICR7m4Zlkbu.mp4'),
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'course_id' => 1,
                'type_id' => 3,
                'title' => 'Принцп работы Telnet',
                'item_content' => json_encode('storage/image/20/lzsPc6EMgZn2T6DKSBc1NGdQi7hhzdRfxiffjT0i.png'),
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'course_id' => 1,
                'type_id' => 4,
                'title' => 'Контрольная по модулю - Базовая конфигурация устройства',
                'item_content' => '{"quiz_id":1}',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
        ]);



        for ($i = 0; $i < $recordCount; $i++) {
            $data[] = [
                'course_id' => rand(2,100),
                'type_id' => TypeOfItems::where('type', 'Текст')->first()->type_id,
                'title' => fake()->text(90),
                'item_content' => json_encode(fake()->text),
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ];
        }

        foreach (array_chunk($data, 1000) as $chunk) {
            CourseItems::insert($chunk);
        }
    }
}
