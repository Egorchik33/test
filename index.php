<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        h3:hover{
            text-shadow: 1px 1px 6px rgba(255, 255, 0, 1);
            transition-delay: 0.3s;
        }
        .text{
            display: none;
        }
        .show{
            display: block;
        }
    </style>
</head>
<body>
<div id='div' class='div'>
    <h3>Показать поле text</h3>
</div>
<?php
$db = "celina_heats";
$serv = "localhost";
$user = "test";
$pass = "test";
$link = mysqli_connect($serv , $user , $pass , $db ) or die(mysqli_connect_error());

//получение данных из таблицы
function getData(){
    global $link;
    $i = 0;
    $query = mysqli_query($link,"SELECT * FROM data");
    //вывод данных в цикле
    //присвоение $id к input для сворачивания/разворачивания поля text
    while ($row = mysqli_fetch_array($query)){
      $i++;
    echo $row['name'] . "-" . $row['email'] . "-" . $row['value'] ."<div id='text$i' class='text'>" . $row['text'] ."</div>". "<br>" ;
    }
    echo "<hr>";
}
getData();
//получение данных с таблицы
function getTree(): array
{
    global $link;
    $query = mysqli_query($link,"SELECT * FROM data"); //объявление переменной массивом
    $result = [];
    while ($row = mysqli_fetch_array($query)){ //преобразование в двумерный массив , где первый ключ id родителя
        $result[$row["parent"]][] = $row;
    }
    return $result; //возвращение массива
}

$tree_arr = getTree();
//вывод дерева
function showTree($parent , $level){
    global $tree_arr;
    if (isset($tree_arr[$parent])){ //если такой родитель существует
        foreach($tree_arr[$parent] as $value){
            //вывод данных
            echo "<div style='margin-left:" . ($level * 25) . "px; '>" .
                $value["name"] . ",email=" . $value["email"] . ",value=" . $value["value"] .',sum=' . $value['sum'] . "</div>";
            $level = $level + 1; //повышение уровня вложенности
            showTree($value["id"], $level); //рекурсивный вызов этой же функции , но с новым id и уровнем
            $level = $level - 1; //понижение уровня вложенности
        }
    }
}

showTree(0,0);

//вывод и валидация email-адресов
function getEmail(){
    echo "<hr>";
    echo "Список адресов:" . "<br>";
    global $link;
    $query = mysqli_query($link,"SELECT email FROM data");
    while ($row = mysqli_fetch_array($query)){
        foreach ($row as $email){
            //проверка через filter_var
            //если не отвечает условию имя@имя.домен , то адрес является невалидным
            if (filter_var($email , FILTER_VALIDATE_EMAIL )){
                echo $email . " - указан верно" . "<br>";
            } else {
                echo $email . " - указан неверно" . "<br>";
            }
            break;
        }
    }
}

getEmail();

?>
<hr>

<script src="lol.js"></script>

</body>
</html>


