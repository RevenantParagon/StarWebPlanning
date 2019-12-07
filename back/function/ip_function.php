<?php

require "../ipv4.php";

function buscarIP($connect, $pdo, $id_provedor, $mascara)
{
    $q = mysqli_query($connect, "SELECT i.ipIP 'IP', i.ipUso 'Uso' FROM tb_ip i where i.proId = " . $id_provedor. " order by i.ipID asc");

    if (mysqli_num_rows($q) > 0) {
        while ($row = mysqli_fetch_array($q)) {

            $ip = new calc_ipv4($row['IP'] . "/" . $mascara);

            $primeiro = $ip->primeiro_ip();
            $ultimo = $ip->ultimo_ip();

            if($row['IP'] != $primeiro && $row['IP'] != $ultimo)
            {
                echo "<tr><td>" . $row['IP'] . "/" . $mascara . "</td>";
                echo "<td>" . $ip->mascara() . "</td>";
                echo "<td>" . $primeiro . "</td>";
                echo "<td> " . $row['Uso'] . " </td></tr>";
            }  
        }
    }
}


