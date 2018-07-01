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
                            switch($_POST['age']){
                                case substr($_POST['age'],-2)==(11||12||13||14) :
                                    $word ='лет';
                                    break;
                                case substr($_POST['age'],-1)==1:
                                    $word ='год';
                                    break;
                                case substr($_POST['age'],-1)==(2||3||4):
                                    $word ='года';
                                    break;
                                default:
                                    $word ='лет';
                            };
                            $out_1 []= 'Вам '.$_POST['age'].' '.$word.'.';
                            $out_2 []= '('.$_POST['age'].' '.$word.').';
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
        header('lication: ?');
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