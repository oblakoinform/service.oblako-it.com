<br>        <form action="/" method="post">
            <p><input type="text" name="fsrar"></p>
            <p><select size="1" name="month">
            <option disabled>Выберите месяц</option>
            <option value="1">Январь</option>
            <option value="2">Февраль</option>
            <option value="3">Март</option>
            <option value="4">Апрель</option>
            <option value="5">Май</option>
            <option value="6">Июнь</option>
            <option value="7">Июль</option>
            <option value="8">Август</option>
            <option value="9">Сентябрь</option>
            <option value="10">Октябрь</option>
            <option value="11">Ноябрь</option>
            <option value="12">Декабрь</option>
        </select></p>
            <p><input type="submit" value="Показать"</p>
        </form>
<table class="report" border="1" width="100%">
        <tr>
            <td align="center">Наименование</td>
            <td align="center">Алкокод</td>
            <td align="center">Количество</td>
            <td align="center">Справка Б</td>
            <td align="center">Объём</td>
            <td align="center">Крепость</td>
            <td align="center">Код продукции</td>
            <td align="center">Тип документа</td>
            <td align="center">Причина</td>
            <td align="center">Дата</td>
    </tr>
    <?
    foreach($result as $item){
        ?>
        <tr >
            <td><?echo $item->FullName;?></td>
            <td  align="center"><?echo $item->AlcCode;?></td>
            <td  align="center"><?echo $item->Quantity;?></td>
            <td  align="center"><?echo $item->Inform2RegId;?></td>
            <td  align="center"><?echo $item->Capacity;?></td>
            <td  align="center"><?echo $item->AlcVolume;?></td>
            <td  align="center"><?echo $item->ProductVCode;?></td>
            <td  align="center"><?echo $item->type;?></td>
            <td  align="center"><?echo $item->TypeWriteOff;?></td>
            <td  align="center"><?echo $item->dt;?></td>
        </tr>
        <?
    }
    ?>
</table>
