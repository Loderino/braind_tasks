<?php
function is_circle($matrix, $active_pixels)
/*Проверяет, является ли изображённая фигура в матрице кругом.
Проверка проводится в несколько этапов:
1) сравнивается количество символов в матрице и количество чёрных пикселей.
2) проверяется, является ли матрица квадратной.
2) Проверяется горизонтальная и вертикальная симметрия матрицы.

На матрице присутствует круг, если матрица квадратная, она не полностью заполнена единицами, а также симметрична и по вертикали, и по горизонтали.
*/
{
    $matrix_symbols_count = count($matrix, COUNT_RECURSIVE) - count($matrix);
    if ($matrix_symbols_count==$active_pixels) return false; 
    else{
        if (count($matrix) != count($matrix[0])) return false;
        if (array_reverse($matrix) != $matrix) return false;
        
        $mirrored_matrix = [];
        foreach($matrix as $line){
            $mirrored_matrix[] = array_reverse($line);
        }
        if ($matrix!=$mirrored_matrix) return false;
        return true;
    } 
    return false;
}

function is_square($matrix){
/*Проверяет, является ли изображённая фигура в матрице квадратом.
Функция сделана с учётом возможности того, что квадрат может стоять на ребре.
Квадрат, в каком бы положении он ни находился, всегда будет симметричен относительно своей диагонали.

На матрице присутствует квадрат, если матрица, отражённая по горизонтали и вертикали равна исходной матрице (симметрична по диагонали).
*/
    $mirrored_matrix = array_reverse($matrix);
    foreach($mirrored_matrix as $line){
        $line = array_reverse($line);
    }

    if ($matrix==$mirrored_matrix) return true;
    return false;
    
}

function sum_for_matrix($matrix, $row_or_column, $index){
    /*row_or_column: 0 - row; 1 - column*/
    $result=0;
    if ($row_or_column){
        for ($i=0; $i< count($matrix); $i++){
            $result+=$matrix[$i][$index];
        }
    }
    else{
        $result = array_sum($matrix[$index]);
    }
    return $result;
}

function find_figure($matrix, $x_size, $y_size){
    /* Функция обрезает пустые строки и столбцы матрицы, оставляя только столбцы и строки, содержащие единицы*/
    $first_content = 0;
    $last_content = 0;
    for ($line=0; $line<$y_size; $line++){
        if (sum_for_matrix($matrix, 0, $line)>0){
            $first_content = $line;
            break;
        }
    }
    for ($line=$y_size-1; $line>$first_content; $line--){
        if (sum_for_matrix($matrix, 0, $line)>0){
            $last_content = $line;
            break;
        }
    }

    $matrix = array_slice($matrix, $first_content, $last_content-$first_content+1);

    for ($column=0; $column<$x_size; $column++){
        if (sum_for_matrix($matrix, 1, $column)>0){
            $first_content = $column;
            break;
        }
    }
    for ($column=$x_size-1; $column>$first_content; $column--){
        if (sum_for_matrix($matrix, 1, $column)>0){
            $last_content = $column;
            break;
        }
    }
    
    for ($line=0; $line<count($matrix); $line++){
        $matrix[$line] = array_slice($matrix[$line], $first_content, $last_content-$first_content+1);
    }
    return $matrix;
}

fscanf(STDIN, "%d %d", $x_size, $y_size);
$black_pixels = 0;
for ($i = 0; $i < $y_size; $i++) { // генерируем матрицу
    $line = trim(fgets(STDIN));
    $matrix[$i] = explode(" ", $line);
    $black_pixels += array_sum($matrix[$i]);  // считаем, сколько закрашенных пикселей
}
$matrix = find_figure($matrix, $x_size, $y_size); // обрезаем лишние строки и столбцы матрицы
if (is_circle($matrix, $black_pixels)) echo "circle";
else if (is_square($matrix)) echo "square";
else echo "triangle";
?>
