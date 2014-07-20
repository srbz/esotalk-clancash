<?php

if(!defined("IN_ESOTALK")) exit;

?>
<div class='transactions'>

    <div class='netSum' style="font-weight: bold;text-align: center;padding: 5px;border-bottom: 0px none;border-top: 0px none;margin: 0px;">
        <big>Saldo: <?php echo $data['netSum']['netSum'] ?></big>
    </div>

    <table border="1" style="border-spacing: 0px;margin: 0px;padding: 0px;width: 100%;text-align: center;">
        <tr>
            <th>ID</th>
            <th>USERNAME</th>
            <th>DATE OF TRANSACTION</th>
            <th>DESCRIPTION</th>
            <th>VALUE</th>
        </tr>
        <?php
        foreach($data['trans'] as $transaction)
        {
        ?>
        <tr>
            <td><?php echo $transaction['id'] ?></td>
            <td><?php echo $transaction['username'] ?></td>
            <td><?php echo $transaction['transactionDate'] ?></td>
            <td><?php echo $transaction['description'] ?></td>
            <td><?php echo $transaction['value'] ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>
