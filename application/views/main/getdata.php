<?

if (count($actWrite) || count($actCharge)) {
    ?>
    <table class="table">
        <tr>
            <td align="center"><b>Алкокод</b></td>
            <td align="center"><b>Наименование</b></td>
            <td align="center"><b>Объём</b></td>
            <td align="center"><b>Количество</b></td>
            <td align="center"><b>Крепость</b></td>
            <td align="center"><b>Код продукции</b></td>
            <?
            if (isset($showpivo)) {
                ?>
                <td align="center"><b>ИНН</b></td>
                <td align="center"><b>КПП</b></td>
                <td align="center"><b>Наименование производителя</b></td>
                <?
            }
            ?>
            <td align="center"><b>Тип документа</b></td>

        </tr>

        <?
        $Apivo = array(263, 520, 500, 510, 262, 261);
        $a = 0;
        $b = 0;
        if (count($actWrite)) {
            foreach ($actWrite as $item2) {
                if ( isset($Aproduct[$item2->AlcCode])) {
                    if (!isset($showpivo)) {
                        $showmode = !in_array($Aproduct[$item2->AlcCode]->ProductVCode, $Apivo);
                    } else {
                        $showmode = in_array($Aproduct[$item2->AlcCode]->ProductVCode, $Apivo);
                    }

                    if ($showmode) {
                        ?>
                        <tr>
                            <td align="center"><?echo $item2->AlcCode;?></td>
                            <td><?echo $Aproduct[$item2->AlcCode]->FullName; ?></td>
                            <td align="center"><?echo $Aproduct[$item2->AlcCode]->Capacity;?></td>
                            <td align="center"><?echo $item2->Quantity;?></td>
                            <td align="center"><?echo $Aproduct[$item2->AlcCode]->AlcVolume;?></td>
                            <td align="center"><?echo $Aproduct[$item2->AlcCode]->ProductVCode;?></td>
                        <?
                        if (isset($showpivo)) {
                            ?>
                            <td align="center"><?
                                echo $Aproduct[$item2->AlcCode]->INN; ?></td>
                            <td align="center"><?
                                echo $Aproduct[$item2->AlcCode]->KPP; ?></td>
                            <td align="center"><?
                                echo $Aproduct[$item2->AlcCode]->producerFullName; ?></td>
                            <?
                        }
                            ?>
                            <td align="center">Расход</td>
                        </tr>

                        <?
                        $a = $a + $item2->Quantity;
                        $b = $b + $Aproduct[$item2->AlcCode]->Capacity;
                    }
                }
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


        $a = 0;
        $b = 0;
        if (count($actCharge)) {
            foreach ($actCharge as $item3) {
                if( isset($Aproduct[$item3->AlcCode])){
                    if (!isset($showpivo)) {
                        $showmode = !in_array($Aproduct[$item3->AlcCode]->ProductVCode, $Apivo);
                    } else {
                        $showmode = in_array($Aproduct[$item3->AlcCode]->ProductVCode, $Apivo);
                    }

                    if ($showmode) {

                        ?>
                        <tr>
                            <td align="center"><?
                                echo $item3->AlcCode; ?></td>
                            <td><?
                                echo $Aproduct[$item3->AlcCode]->FullName; ?></td>
                            <td align="center"><?
                                echo $Aproduct[$item3->AlcCode]->Capacity; ?></td>
                            <td align="center"><?
                                echo $item3->Quantity; ?></td>
                            <td align="center"><?
                                echo $Aproduct[$item3->AlcCode]->AlcVolume; ?></td>
                            <td align="center"><?
                                echo $Aproduct[$item3->AlcCode]->ProductVCode; ?></td>
                            <td align="center">Приход</td>
                        </tr>

                        <?
                        $a = $a + $item3->Quantity;
                        $b = $b + $Aproduct[$item3->AlcCode]->Capacity;
                    }
                }

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
    <?
}
    ?>