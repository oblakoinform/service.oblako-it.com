<?
$Amonth=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
?>
<style>
    .asd{
        display: none;
    }

</style>
<form action = "/main/acts_pivo" method = "post">
    <select class="form-control" id="month" name="month">
        <?
        for($i=0;$i<12;$i++) {
            ?>
            <option value="<?=$i+1;?>" <?
            if ($month==$i+1){
                echo "selected";
            }
            ?>><?=$Amonth[$i];?></option>
            <?
        }
        ?>
    </select>
    <button  type="submit" class="btn btn-default">Показать</button>
</form>
<table class="table">
    <tr>
        <td align="center"><b>#</b></td>
        <td align="center"><b>ФСРАР</b></td>
        <td align="center"><b>ИНН</b></td>
        <td align="center"><b>КПП</b></td>
        <td align="center"><b>Наименование</b></td>
        <td align="center"><b>Адрес</b></td>
    </tr>
    <?
    $a = 1;
    foreach($Aproducer as $producer){
        ?>
        <tr class="btnasd" fsrar="<?=$producer->ClientRegId;?>">
            <td  align="center"><?echo $a;?></td>
            <td  align="center"><?echo $producer->ClientRegId;?></td>
            <td  align="center"><?echo $producer->INN;?></td>
            <td  align="center"><?echo $producer->KPP;?></td>
            <td  align="left"><?echo $producer->FullName;?></td>
            <td  align="left"><?echo $producer->address;?></td>
        </tr>
        <tr class="asd" fsrar="<?=$producer->ClientRegId;?>">
            <td colspan="6" class="htmlasd" fsrar="<?=$producer->ClientRegId;?>"> </td>

        </tr>

        <?
        $a++;
    }
    ?>
</table>

<script>
    $(document).ready(function () {
        $('.btnasd').click(function (e) {
            fsrar=$(this).attr('fsrar');
            if ($('.asd[fsrar="'+fsrar+'"]').is(':visible')){
                $('.asd[fsrar="'+fsrar+'"]').hide();
            } else {
                $('.asd[fsrar="'+fsrar+'"]').show();
                $.ajax({
                    type: "GET",

                    data: {'month': $("#month").val(),'ClientRegId': fsrar,'showpivo':"1"},
                    url: "/main/getdata",
                    success: function (data) {

                        $('.htmlasd[fsrar="'+fsrar+'"]').html(data);
                    },
                });
            }

        });


    });
</script>