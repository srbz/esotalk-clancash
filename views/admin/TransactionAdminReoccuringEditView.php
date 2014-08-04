<?php
// this really needs a better formatting, I hate css so much...
if(!defined("IN_ESOTALK")) exit;
$form = $data['form'];
?>
<div class='transactions'>
    <!--  did i mention that I really hate css? -->
    <table border="1" style="border-spacing: 0px;margin: 0px;padding: 0px;width: 100%;text-align: center;">
        <tr>
            <th>ID</th>
            <th>USERNAME</th>
            <th>NEXT DATE OF TRANSACTION</th>
            <th>DESCRIPTION</th>
            <th>VALUE</th>
        </tr>
        <tr>
            <!--  not editable -->
            <td><?php echo $data['entry']['id'] ?></td>
            <!--  not editable -->
            <td><?php echo $data['entry']['username'] ?></td>
            <!--  not editable, for the moment -->
            <td><?php echo $data['entry']['nextTransactionDate'] ?></td>
            <!--  editable for now -->
            <td><?php echo $data['entry']['description'] ?></td>
            <!--  editable for some reason -->
            <td><?php echo $data['entry']['value'] ?></td>
        </tr>
    </table>
    <!--  needs fancy formatting, for now it works... -->
    <?php
        echo $form->open(),
            $form->input("id", "text", array("disabled"=>"disabled")),
            $form->input("username", "text", array("disabled"=>"disabled")),
            $form->input("nextTransactionDate", "text"),
            $form->input("description", "text"),
            $form->input("value", "text"),
            $form->button("save", "Save changes"),
            $form->button("cancel", "Cancel operation"),
            $form->close();
    ?>
</div>
