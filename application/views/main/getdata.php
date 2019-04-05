<?
$a = $a+1;
?>
    <tr class="asd" fsrar="<?=$producer->ClientRegId;?>">
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
                if (isset($actWrite[$item3->ClientRegId])) {
                    $actWrite = $AactWrite[$item3->ClientRegId];


                    $a = 0;
                    $b = 0;
                    foreach ($actWrite as $item3) {

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
                                if($item2->type=="ActWriteOff_v3" || $item2->type=="ActWriteOffShop_v2") {
                                    echo "Расход";
                                } else {
                                    echo "Приход";
                                }
                                ?></td>
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
                if (isset($actCharge[$item->ClientRegId]) && ($item2->ProductVCode=="500,510,520,261,262,263")) {
                    $result2 = $Aresult2[$item->ClientRegId];
                    $a = 0;
                    $b = 0;
                    foreach ($actCharge as $item3) {

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
                                if ($item3->type == "ActWriteOff_v3" || $item3->type == "ActWriteOffShop_v2") {
                                    echo "Расход";
                                } else {
                                    echo "Приход";
                                }
                                ?></td>
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
