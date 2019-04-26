<?
if ($excel==0) {
    $Amonth = array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
    ?>
    <form action="" method="post" class="form-horizontal">
        <select class="form-control" id="month" name="month">
            <?
            for ($i = 0; $i < 12; $i++) {

                ?>
                <option value="<?= str_pad($i + 1, 2, "0", STR_PAD_LEFT); ?>" <?
                if ($month == $i + 1) {
                    echo "selected";
                }
                ?>><?= $Amonth[$i]; ?></option>
                <?
            }
            ?>
        </select>
        <select class="form-control" id="year" name="year">
            <?
            for ($y = date("Y"); $y >= date("Y") - 1; $y--) {
                ?>
                <option value="<?= $y; ?>" <?
                if ($year == $y) {
                    echo "selected";
                }
                ?>><?= $y; ?></option>
                <?
            }
            ?>
        </select>
        <button type="submit" class="btn btn-primary">Показать</button>
        <button type="button" class="btn btn-success" onclick="location='?excel=1&month=<?=$month;?>&year=<?=$year;?>'">Excel</button>
    </form>
    <?
} else {

}
    ?>
<table class="table" <?
if ($excel==1){
    ?>border="1" <?
}
?>>
    <tr>
        <td align="center"><b>#</b></td>
        <td align="center"><b>Наименование</b></td>
        <td align="center"><b>ФСРАР</b></td>
        <td align="center"><b>Адрес</b></td>
        <td align="center"><b>Объём по продажам (л.)</b></td>
        <td align="center"><b>Объём по списаниям (л.)</b></td>
        <td align="center"><b>Объём по постановке на баланс (л.)</b></td>
    </tr>
<?
$sum1=0;
$a=1;
$firstname="";
$sum1 = 0;
$sum2 = 0;
$sum3 = 0;
foreach ($Aproducer as $fsrar) {
    if (isset($checks[$fsrar->ClientRegId])) {
        $checkvol = $checks[$fsrar->ClientRegId]->TotalCapacity;
    } else {
        $checkvol = 0;
    }
    if (isset($Aacts1[$fsrar->ClientRegId])) {
        $acts1vol = $Aacts1[$fsrar->ClientRegId]->TotalCapacity;
    } else {
        $acts1vol = 0;
    }
    if (isset($Aacts2[$fsrar->ClientRegId])) {
        $acts2vol = $Aacts2[$fsrar->ClientRegId]->TotalCapacity;
    } else {
        $acts2vol = 0;
    }



    if ($firstname != $fsrar->FullName && $firstname != '') {

        itog($sum1,$sum2,$sum3);
        $sum1 = 0;
        $sum2 = 0;
        $sum3 = 0;
    }
    $sum1 = $sum1 + $checkvol;
    $sum2 = $sum2 + $acts1vol;
    $sum3 = $sum3 + $acts2vol;
    $firstname = $fsrar->FullName;
    ?>
    <tr>
        <td align="center"><?echo $a;?></td>
        <td align="center"><?= $fsrar->FullName ?></td>
        <td align="center">&nbsp;<?= $fsrar->ClientRegId ?></td>
        <td align="left"><?= $fsrar->address ?></td>
        <td align="center"><?= $checkvol; ?></td>
        <td align="center"><?= $acts1vol; ?></td>
        <td align="center"><?= $acts2vol; ?></td>
    </tr>
    <?
    $a++;
}
itog($sum1,$sum2,$sum3);
?>
</table>
<?
function itog($sum1,$sum2,$sum3){
    ?>
    <tr>
        <td align="center"></td>
        <td align="center"></td>
        <td align="left"></td>
        <td align="right"><b>Итого по организации:</b></td>


        <td align="center"><b><?= $sum1; ?></b></td>
        <td align="center"><b><?= $sum2; ?></b></td>
        <td align="center"><b><?= $sum3; ?></b></td>
    </tr>

    <?
}
?>