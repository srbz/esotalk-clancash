<?php

if(!defined("IN_ESOTALK")) exit;
//TODO replace all " by ' -- grr
?>
<div class='actions'>
    <ul class='menu'>
        <li><a class='button' href='transaction/add'>New Transaction</a></li>
        <li><a class='button' href='transaction/addReocc'>New Reoccuring Payment</a></li>
    </ul>
</div>
<div class='transactions'>
    <div class='netSum' style="font-weight: bold;text-align: center;padding: 5px;border-bottom: 0px none;border-top: 0px none;margin: 0px;">
        <big>Saldo: <?php echo $data['netSum']['netSum'] ?></big>
    </div>
    <div class='netSum' style="font-weight: bold;text-align: center;padding: 5px;border-bottom: 0px none;border-top: 0px none;margin: 0px;">
        <big>Reoccuring payments per month: <?php echo $data['reoccSum']['reoccSum'] ?></big>
    </div>
    <table border='1' style="border-spacing: 0px;margin: 5px;padding: 0px;width: 100%;text-align: center;">
        <tr>
            <th>ID</th>
            <th>USERNAME</th>
            <th>NEXT DATE OF TRANSACTION</th>
            <th>DESCRIPTION</th>
            <th>VALUE</th>
            <th>ACTIONS</th>
        </tr>
        <?php
        foreach($data['reocc'] as $transaction)
        {
        ?>
        <tr>
            <td><?php echo $transaction['id'] ?></td>
            <td><?php echo $transaction['username'] ?></td>
            <td><?php echo $transaction['nextTransactionDate'] ?></td>
            <td><?php echo $transaction['description'] ?></td>
            <td><?php echo $transaction['value'] ?></td>
            <td><a class="button" href='transaction/execReocc/<?php echo $transaction['id'] ?>'>Execute</a> <a class="button" href="transaction/editReocc/<?php echo $transaction['id'] ?>">Edit</a> <a class="button" href="transaction/delReocc/<?php echo $transaction['id'] ?>">Delete</a></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <table border="1" style="border-spacing: 0px;margin: 5px;padding: 0px;width: 100%;text-align: center;">
        <tr>
            <th>ID</th>
            <th>USERNAME</th>
            <th>DATE OF TRANSACTION</th>
            <th>DESCRIPTION</th>
            <th>VALUE</th>
            <th>ACTIONS</th>
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
            <td><a class ="button" href="transaction/edit/<?php echo $transaction['id'] ?>">Edit</a> <a class ="button" href="transaction/delete/<?php echo $transaction['id'] ?>">Delete</a></td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>
