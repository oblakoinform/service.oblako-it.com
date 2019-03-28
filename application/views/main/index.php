<form action="/" method="post">
            <p><input type="month" id="month" name="month"></p>
            <p><input type="text" name="fsrar"></p>
            <p><input type="submit" value="Показать"</p>
        </form>
<table class="report">
        <tr>
        <th align="center">Наименование</th>
        <th align="center">Алкокод</th>
        <th align="center">Количество</th>
        <th align="center">Справка Б</th>
    </tr>
    <?
    $result=array();
    foreach ($result as $item){
        ?>
        <tr>
            <td><?
                echo $item->Name;
                echo $item->AlcCode;
                echo $item->Quantity;
                echo $item->Inform2RegId;
                ?>
            </td>
        </tr>
        <?
    }
    ?>
</table>
