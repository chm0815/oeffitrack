<?php

echo validation_errors();
echo form_open('main/loginAction/');
echo "\n <fieldset id='loginfield'>";
echo '<legend>Login</legend>';
echo '<table>';

$data = array(
              'name'        => 'name',
              'id'          => 'name',
              'value'       => '',
              'maxlength'   => '10',
              'size'        => '10'
            );

echo '<tr><td>name:</td>';
echo '<td>'.form_input($data).'</td></tr>';

$data = array(
              'name'        => 'password',
              'id'            => 'password',
              'value'         => '',
              'maxlength'   => '10',
              'size'        => '10'
            );

echo '<tr><td>password:</td>';
echo '<td>'.form_password($data).'</td></tr>';
echo '<tr><td></td><td><input type="submit" value="login" name="login" id="login"/></td>' ;
echo '</table>';

echo "</fieldset>";

?>

</form>