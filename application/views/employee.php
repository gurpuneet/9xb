<?php
$employee_record_count = $employee_count;
$employee_record_list = $employee_list;
?>
<html>
<head>
<link href="<?php echo base_url();?>assets/css/styles.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/js/jquery_new.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.btndelete').change(function() {
        if ($(this).prop('checked')) {
            var response = confirm("Are you sure you want to delete this record.");
            if (response == true) {
                 var rowID = ($(this).attr('value'));    
                 window.location.href = 'http://localhost/9xb_test/employee/deleteRecord/'+rowID;
            }
            else
            {
                $(this).attr('checked', false); // Unchecks it
            }
        }
    });
});    
</script>
</head>
<body>
<div class="container">
<p class="message_show"><?php echo $this->session->flashdata('display_user_message');?></p>
<form action="<?php echo base_url();?>employee/newRecord" method="post" name="frmemployee" id="frmemployee">
    <table width="700" cellpadding="1" cellspacing="0" border="0">
        <tr>
            <th>First name</th>
            <th>Last name</th>
            <th>Email Address</th>
            <th>Job Role</th>
            <th>Delete</th>
        </tr>
        <?php
        if($employee_record_count!='0') // parent if
        {
            $i=1;
            foreach($employee_record_list as $key=>$value){?>
            <tr>
                <td><input type="text" name="people[<?=$i?>][firstname]" value="<?=$value['emp_first_name']?>" maxlength="50" /></td>
                <td><input type="text" name="people[<?=$i?>][lastname]" value="<?=$value['emp_last_name']?>" maxlength="30" /></td>
                <td><input type="email" name="people[<?=$i?>][email]" value="<?=$value['emp_email']?>" maxlength="80" /></td>
                <td><input type="text" name="people[<?=$i?>][job_role]" value="<?=$value['emp_job_role']?>" maxlength="100" /></td>
                <td><input type="checkbox" name="people[<?=$i?>][delete]" id="test" value="<?=$value['empID']?>" class="btndelete" /><input type="hidden" name="people[<?=$i?>][referenceid]" value="<?=$value['empID']?>"></td>
            </tr>
            <?php $i++; } // endforeach 
            if($i!='11')  // child if starts ( New row for adding new record will be displayed only if current record count is less than 10 )
            {?>
                <tr>
                <td><input type="text" name="people[<?=$i?>][firstname]" value="" placeholder="Add new..." maxlength="50" /></td>
                <td><input type="text" name="people[<?=$i?>][lastname]" value="" placeholder="Add new..." maxlength="30" /></td>
                <td><input type="email" name="people[<?=$i?>][email]" value="" placeholder="Add new..." maxlength="80"></td>
                <td><input type="text" name="people[<?=$i?>][job_role]" value="" placeholder="Add new..." maxlength="100"></td>
                <td></td>
                </tr>
            <?php } // endif child
        } // endif parent
        else
        {
            for($i=1; $i<=3; $i++){?>
            <tr>
            <td><input type="text" name="people[<?=$i?>][firstname]" value="" placeholder="Add new..." maxlength="50" /></td>
            <td><input type="text" name="people[<?=$i?>][lastname]" value="" placeholder="Add new..." maxlength="30" /></td>
            <td><input type="email" name="people[<?=$i?>][email]" value="" placeholder="Add new..." maxlength="80"></td>
            <td><input type="text" name="people[<?=$i?>][job_role]" value="" placeholder="Add new..." maxlength="100"></td>
            <td></td>
            </tr>
            <?php } // endfor
        }
        ?>
        <tr>
            <td colspan="5" style="height: 10px;"><td>
        </tr>
    </table>
    <input type="submit" value="Submit/Update" />
</form>
</div>
</body>
</html>