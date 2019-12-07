<?php

require "../ipv4.php";

function buscarVlan($connect, $pdo, $id)
{
    $q = mysqli_query($connect, "SELECT vlanID 'ID', vlanIP 'IP', vlanDescricao 'Descricao', vlanMascara 'Mascara',vlanDHCP 'DHCP', vlanVPN 'VPN', vlanCor 'Cor', camId 'camId' from tb_vlan where vlanVPN = 1 or camId = ".$id);
    
    if (mysqli_num_rows($q) > 0) {
        while ($row = mysqli_fetch_array($q)) {

            $ip = new calc_ipv4($row['IP'] . "/" . $row['Mascara']);

            if($row['DHCP'] == 1)
                $dhcp = "SIM";
            else
                $dhcp = "NÃO";
            if($row['VPN'] == 1)
                $vpn = "SIM";
            else
                $vpn = "NÃO";

            $primeiro = new calc_ipv4($ip->primeiro_ip() . "/" .$row['Mascara']);
            $ultimo = new calc_ipv4($ip->ultimo_ip() . "/" .$row['Mascara']);

            $primeiro = $primeiro->endereco();
            $ultimo = $ultimo->endereco();

            $var_primeiro = explode(".", $primeiro);
            $var_ultimo = explode(".", $ultimo);

            $total = (int)$ip->total_ips()-2;

            $comeco = (int)$var_primeiro[3]+1;
            $final = (int)$var_ultimo[3]-1;

            $comeco = $var_primeiro[0].".".$var_primeiro[1].".".$var_primeiro[2].".".$comeco;

            $final = $var_ultimo[0].".".$var_ultimo[1].".".$var_ultimo[2].".".$final;

            echo "<tr><td>" . $row['ID'] . "</td>
                <td>" . $row['IP'] . "</td>
                <td>" . $row['Descricao'] . "</td>
                <td>" . $ip->mascara() . "</td>
                <td>" . $ip->primeiro_ip() . "</td>
                <td>" . $dhcp . "</td>
                <td>" . $total . "</td>
                <td>" . $comeco. "</td>
                <td>" . $ultimo . "</td>
                <td>" . $vpn . "</td>
                <td style='background-color: ".$row['Cor'] ."'>
                <td align='center'>";
                if(($_SESSION['tipo'] == 1 && $row['VPN'] == 1) || $_SESSION['tipo'] == 1 || ($row['camId'] == $_SESSION['campus'] && $row['VPN'] != 1) )
                    echo"<a href='../src/vlan.php?funcao=editar&campus=" . $row['camId'] . "&id=" . $row['ID'] . "'><i class='fas fa-edit'></i></a>";
                echo "</td><td align='center'>";
                if(($_SESSION['tipo'] == 1 && $row['VPN'] == 1) || $_SESSION['tipo'] == 1 || ($row['camId'] == $_SESSION['campus'] && $row['VPN'] != 1) )
                    echo"<a href='../back/vlan_back.php?tipo=deletar&campus=" . $row['camId'] . "&id=".$row['ID'] ."'><i class='fas fa-trash-alt'></i></a>";                
                echo "</td></tr>";                
        }
    }
}

function voltarVlan($pdo, $id)
{
    $select = "select vlanIP 'ip', vlanDescricao 'descricao', vlanMascara 'mascara',vlanDHCP 'dhcp', vlanVPN 'vpn', vlanCor 'cor'  from tb_vlan where vlanId=:id";

    $stmt = $pdo->prepare($select);

    $stmt->bindValue(":id", $id);

    $stmt->execute();
    
    if ($stmt->rowcount() == 1) {
        return $row =$stmt->fetch();
    }
}

?>