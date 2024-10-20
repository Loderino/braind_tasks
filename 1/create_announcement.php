<?php

function create_announcement($text, $link) {
    /**
     * Функция для создания анонса к статье.
     * Принимает текст статьи и ссылку на неё.
     * Возвращает тест анонса, содержащий ссылку на на статью.
    */
    $symbols_limit = 250;
    $tag_offset = 3;

    // Обрезаем текст до лимита символов
    $truncated_text = mb_substr($text, 0, $symbols_limit, "UTF-8");
    
    // Находим позицию последнего пробела. Он должен быть максимум на такой позиции, чтобы ещё влезло многоточие
    $last_space = mb_strrpos($truncated_text, " ", -1, "UTF-8"); 
    
    if ($last_space > $symbols_limit-3){
        $last_space = mb_strrpos(mb_substr($truncated_text, 0, $symbols_limit-3, "UTF-8"), " ", -1, "UTF-8");
    }

    // Обрезаем текст до последнего полного слова
    $announcement_text = mb_substr($truncated_text, 0, $last_space, "UTF-8");

    // Разбиваем на слова
    $words = explode(' ', $announcement_text);

    // Определяем позицию для вставки ссылки
    $tag_index = max(0, count($words) - $tag_offset);

    // Формируем финальный текст анонса
    $result = implode(' ', array_slice($words, 0, $tag_index));
    $result .= ' <a href="' . htmlspecialchars($link) . '">';
    $result .= implode(' ', array_slice($words, $tag_index));
    $result .= '...</a>';

    return $result;
}

$link = fgets(STDIN);
$article_text = "";

while ($line = fgets(STDIN)) {
    $article_text .= $line;
}

echo (create_announcement($article_text, $link));


?>