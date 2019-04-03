<form action = "/main/acts" method = "post">
    <select size="1" name="month">
        <option value = "1" > Январь</option>
        <option value = "2" > Февраль</option>
        <option selected value = "3" > Март</option>
        <option value = "4" > Апрель</option>
        <option value = "5" > Май</option>
        <option value = "6" > Июнь</option>
        <option value = "7" > Июль</option>
        <option value = "8" > Август</option>
        <option value = "9" > Сентябрь</option>
        <option value = "10" > Октябрь</option>
        <option value = "11" > Ноябрь</option>
        <option value = "12" > Декабрь</option>
    </select>
    <p><input type = "submit" value = "Показать" </p>
</form>
    <p><table class="table">
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
        <tr>
            <td  align="center"><details><summary><?echo $item->ClientRegId;?></td>
            <td  align="center"><?echo $item->INN;?></td>
            <td  align="center"><?echo $item->KPP;?></td>
            <td  align="left"><?echo $item->FullName;?></td>
            <td  align="left"><?echo $item->address;?></summary></details></td>
        </tr>
        <?
    }
    ?>
    </table></p>
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
                $a=0;
                $b=0;
                foreach($result2 as $item2){

                    ?>
                    <tr>
                        <td  align="center"><?echo $item2->AlcCode;?></td>
                        <td><?echo $item2->FullName;?></td>
                        <td  align="center"><?echo $item2->Capacity;?></td>
                        <td  align="center"><?echo $item2->Quantity;?></td>
                        <td  align="center"><?echo $item2->AlcVolume;?></td>
                        <td  align="center"><?echo $item2->ProductVCode;?></td>
                        <td  align="center"><?echo $item2->type;?></td>
                    </tr>

                    <?
                    $a=$a+$item2->Quantity;
                    $b=$b+$item2->Capacity;
                }
                ?>
    <tr>
        <td></td>
        <td></td>
        <td  align="center"><b>Итого:<?echo $b;?></b></td>
        <td  align="center"><b>Итого:<?echo $a;?></b></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>

    <?
    $a=0;
    $b=0;
    foreach($result3 as $item3){

        ?>
        <tr>
            <td  align="center"><?echo $item3->AlcCode;?></td>
            <td><?echo $item3->FullName;?></td>
            <td  align="center"><?echo $item3->Capacity;?></td>
            <td  align="center"><?echo $item3->Quantity;?></td>
            <td  align="center"><?echo $item3->AlcVolume;?></td>
            <td  align="center"><?echo $item3->ProductVCode;?></td>
            <td  align="center"><?echo $item3->type;?></td>
        </tr>

        <?
        $a=$a+$item3->Quantity;
        $b=$b+$item3->Capacity;
    }
    ?>
    <tr>
        <td></td>
        <td></td>
        <td  align="center"><b>Итого:<?echo $b;?></b></td>
        <td  align="center"><b>Итого:<?echo $a;?></b></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>

</table>