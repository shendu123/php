<html>
<form method="post" action="login_process.php">
    <p>用户名：<input type="text" name="username"></p>
    <p>密码：<input type="text" name="password"></p>
    <input type="hidden" name="return_url" value="<?php echo $_GET['return_url']?>">
    <p>：<input type="submit"></p>
</form>
</html>