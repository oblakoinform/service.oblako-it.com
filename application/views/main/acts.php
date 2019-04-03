<?
$Amonth=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
?>
<style>
    .asd{
        display: none;
    }

</style>
<form action = "/main/acts" method = "post">
    <select size="1" name="month">
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
    <p><input type = "submit" value = "Показать" </p>
</form>
    <table class="table">
    <tr>
        <td align="center"><b>ФСРАР</b></td>
        <td align="center"><b>ИНН</b></td>
        <td align="center"><b>КПП</b></td>
        <td align="center"><b>Наименование</b></td>
        <td align="center"><b>Адрес</b></td>
    </tr>
    <?
    foreach($result as $item){
        ?>
        <tr class="btnasd" fsrar="<?=$item->ClientRegId;?>">
            <td  align="center"><?echo $item->ClientRegId;?></td>
            <td  align="center"><?echo $item->INN;?></td>
            <td  align="center"><?echo $item->KPP;?></td>
            <td  align="left"><?echo $item->FullName;?></td>
            <td  align="left"><?echo $item->address;?></td>
        </tr>
        <tr class="asd" fsrar="<?=$item->ClientRegId;?>">
            <td colspan="5">
                <table class="table">
                    <tr>
                        <td align="center"><b>Алкокод</b></td>
                        <td align="center"><b>Наименование</b></td>
                        <td align="center"><b>Объём</b></td>
                        <td align="center"><b>Количество</b></td>
                        <td align="center"><b>Крепость</b></td>
                        <td align="center"><b>Код продукции</b></td>
                        <td align="center"><b>Тип документа</b></td>
                    </tr>

                    <?
                    if (isset($Aresult2[$item->ClientRegId])) {
                        $result2 = $Aresult2[$item->ClientRegId];


                        $a = 0;
                        $b = 0;
                        foreach ($result2 as $item2) {

                            ?>
                            <tr>
                                <td align="center"><?
                                    echo $item2->AlcCode; ?></td>
                                <td><?
                                    echo $item2->FullName; ?></td>
                                <td align="center"><?
                                    echo $item2->Capacity; ?></td>
                                <td align="center"><?
                                    echo $item2->Quantity; ?></td>
                                <td align="center"><?
                                    echo $item2->AlcVolume; ?></td>
                                <td align="center"><?
                                    echo $item2->ProductVCode; ?></td>
                                <td align="center"><?
                                    echo $item2->type; ?></td>
                            </tr>

                            <?
                            $a = $a + $item2->Quantity;
                            $b = $b + $item2->Capacity;
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td align="center"><b>Итого:<?
                                    echo $b; ?></b></td>
                            <td align="center"><b>Итого:<?
                                    echo $a; ?></b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <?
                    }
                    if (isset($Aresult3[$item->ClientRegId])) {
                        $result3 = $Aresult3[$item->ClientRegId];
                        $a = 0;
                        $b = 0;
                        foreach ($result3 as $item3) {

                            ?>
                            <tr>
                                <td align="center"><?
                                    echo $item3->AlcCode; ?></td>
                                <td><?
                                    echo $item3->FullName; ?></td>
                                <td align="center"><?
                                    echo $item3->Capacity; ?></td>
                                <td align="center"><?
                                    echo $item3->Quantity; ?></td>
                                <td align="center"><?
                                    echo $item3->AlcVolume; ?></td>
                                <td align="center"><?
                                    echo $item3->ProductVCode; ?></td>
                                <td align="center"><?
                                    echo $item3->type; ?></td>
                            </tr>

                            <?
                            $a = $a + $item3->Quantity;
                            $b = $b + $item3->Capacity;
                        }

                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td align="center"><b>Итого:<?
                                    echo $b; ?></b></td>
                            <td align="center"><b>Итого:<?
                                    echo $a; ?></b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?
                    }
?>
                </table>
            </td>
        </tr>
        <?
    }
    ?>
    </table>
<script>
    $(document).ready(function () {
        $('.btnasd').click(function (e) {
            fsrar=$(this).attr('fsrar');
            console.log($('.asd[fsrar="'+fsrar+'"]').is(':visible'));
            if ($('.asd[fsrar="'+fsrar+'"]').is(':visible')){
                $('.asd[fsrar="'+fsrar+'"]').hide();
            } else {
                $('.asd[fsrar="'+fsrar+'"]').show();
            }

        });


    });
</script>