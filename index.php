<?php
// Добавлять в отчет все ошибки PHP (см. список изменений)
error_reporting(E_ALL);

// То же, что и error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

function echo_var($name){
    if(!empty($_POST[$name])){
        return $_POST[$name];
    };
    return '';
};


function year_word($age){  // Первая функция для написания лет
    $words = [
        'лет' => [11, 12, 13, 14, 0, 5, 6, 7, 8, 9,],
        'год' => [1,],
        'года' => [2, 3, 4,],
    ];
    for ($i=2; $i > 0; $i--){
        $age = substr($age, -$i);
        foreach ($words as $word => $years) {
            foreach ($years as $year) {
                if ($age == $year) {
                    return $word;
                };
            };
        };
    };
};

function year_word2($age){   //вторая функция для напсиания лет
    $ar_1 = [11, 12, 13, 14];
    $ar_2 = [2, 3, 4];
    if(substr($age,-2, 2)>=11 && substr($age,-2, 2)<=14 ){
        $znach = substr($age,-2, 2);
    }else{
        $znach = substr($age,-1);
    };
    switch($znach){
        case ($ar_1[(array_search($znach, $ar_1))]):
            return 'лет';
            break;
        default:
            switch ($znach){
                case 1:
                    return 'год';
                    break;
                case ($ar_2[(array_search($znach, $ar_2))]):
                    return 'года';
                    break;
                default:
                    return 'лет';
            };
    };
};

function output_txt($redirect = false){
    $out_1 =[];
    $out_2 =[];
    $word ='';
    if(empty($_POST['pay'])){
        $_POST['pay'] = 'off';}
        if(!empty($_POST)){
            foreach($_POST as $key=>$value){
                if(!empty($_POST[$key])){
                    switch($key){
                        case 'FIO':
                            $out_1 []= 'Здравствуйте '.$_POST['FIO'].'.';
                            $out_2 []= $_POST['FIO'].'.';
                            break;
                        case 'age':
                            $word_1 = year_word($_POST['age']);
                            $word_2 = year_word2($_POST['age']);
                            $out_1 []= 'Вам '.$_POST['age'].' '.$word_1.' (по функции №2- '.$_POST['age'].' '.$word_2.').';
                            $out_2 []= '('.$_POST['age'].' '.$word_2.').';
                            break;
                        case 'pay':
                            if($_POST['pay'] == 'on'){
                                $pay = 'за';
                                $pay_2 = 1;
                            }else{
                                $pay = 'не ';
                                $pay_2 = 0;
                            };
                            $out_1 []='Ваше решение '.$pay.'платить учтено.';
                            $out_2 []=$pay_2;
                            break;

                    };
                };
            };
        };
    $out_1 = implode(' ',$out_1);
    $out_2 = implode(' ',$out_2);
    $answer = file_get_contents('answer.txt');
    file_put_contents('answer.txt', $answer.$out_2."\n");
    if($redirect == true){
        header('location: ?');
    }else{
        echo $out_1;
    };
};
if (empty($_POST)){?>
<form action="" method="post">
    <div class="form form_group">
        <label for="" class="form_label">Имя</label>
        <input type="text" name="FIO" class="form_input" value="<?php echo echo_var('FIO'); ?>">
    </div>
    <div class="form form_group">
        <label for="" class="form_label">Возраст</label>
        <input type="number" name="age" class="form_input" value="<?php echo echo_var('age'); ?>">
    </div>
    <div class="form form_group">
        <label for="" class="form_label">
            <?php if(!empty($_POST['pay'])&& $_POST['pay']=='on'){
                $checked = 'checked';
            }else{
                $checked = '';
            }; ?>
            <input type="checkbox" name="pay" class="form_input" <?php echo $checked; ?>>
            Согласен внести плату за ремонт
        </label>
    </div>
    <button class="form_button">OK</button>
</form>
<?php }else{
    output_txt(false);};