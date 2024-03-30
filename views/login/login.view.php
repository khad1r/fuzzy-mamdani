<style>
    body {
        background: #75caf3 !important;
    }
    h2 {
        text-align: center;
        text-transform: uppercase;
        font-weight: 500;
        margin: 30px;
        font-size:40px;
    }
</style>
<div class="login-form" name="login">
    <form method="post">
        <div class="form-group">
        <h2><strong>Login</strong></h2>
            <input type="text" class="form-control" placeholder="Username" name="username" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password" required="required">
        </div>
        <hr>
        <input type="submit" class="btn w-100" value="Login" name="login">
    </form>
</div>