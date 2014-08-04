<?php
// this really needs a better formatting, I hate css so much...
if(!defined("IN_ESOTALK")) exit;
$form = $data['form'];
?>
<div class='transactions'>
<!--  need some more form stuff todo -->
    <?php
        echo $form->open();
            //maybe a list with all users? -- maybe this gets to overloaded
            //maybe ajax list
            //TODO change this, really!
            //really really needs formatting -- because i hate css
        echo "<label>Username</label> ".$form->input("username", "text")."</br></br>";
        //date format at mouseover? or date-picker from jquery?
        echo "<label>Next Transaction Date</label> ".$form->input("nextTransactionDate", "text")."</br></br>";
        echo "<label>Description</label> ".$form->input("description", "text")."</br></br>";
        //js number value check?
        echo "<label>Value</label> ".$form->input("value", "text")."</br></br>";
        echo $form->button("save", "Add new reoccuring transaction")." ",
            $form->button("cancel", "Cancel operation"),
            $form->close();
    ?>
</div>
