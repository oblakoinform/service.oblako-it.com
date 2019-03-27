<?
<head>
    <meta charset="utf-8">
    <title>Отчёт по актам</title>
</head>
?>
    <body>
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
<tr>
<td>$Name</td>
<td>$AlcCode</td>
<td>$Quantity</td>
<td>$Inform2RegId</td>
</tr>
</table>
    </body>
