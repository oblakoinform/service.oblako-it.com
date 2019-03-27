        <form action="Main.php" method="post">
            <p>Укажите месяц:<input type="month" id="month" name="month"></p>
            <p><input type="text" name="word"></p>
             <p><input type="submit" value="Показать"></p>
        </form>
<table class="report">
    <tr>
        <th align="center">Наименование</th>
        <th align="center">Алкокод</th>
        <th align="center">Количество</th>
        <th align="center">Справка Б</th>
    </tr>
    <?
    foreach ($result as $item){
        ?>
        <tr>
            <td><?
                echo $item->AlcCode;
                ?></td>
            <td>$AlcCode</td>
            <td>$Quantity</td>
            <td>$Inform2RegId</td>
        </tr>
        <?
    }
    ?>
</table>
