<?php include("../_include/header.php"); ?>
    
    <div class="container">
		<div class="container-page">				
			<div class="col-md-12">
                <form action="/Database_Website/php/register.php" method="post">
                    <h3 class="title">Registration</h3>
                    <div class="form-group col-lg-6">
                        <label>Email Address</label>
                        <input type="text" name="email" class="form-control" id="email" value="" autofocus="">
                    </div>

                    <div class="form-group col-lg-6">
                        <label>Repeat Email Address</label>
                        <input type="text" name="em_confirm" class="form-control" id="em-confirm" value="">
                    </div>	

                    <div class="form-group col-lg-6">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" id="password" value="">
                    </div>

                    <div class="form-group col-lg-6">
                        <label>Repeat Password</label>
                        <input type="password" name="pw_confirm" class="form-control" id="pw_confirm" value="">
                    </div>

                    <button type="Submit" class="btn btn-primary btn-block">Sign me up!</button>
                </form>
			</div>
		</div>
    </div>
    
<?php include($_INCLUDES."footer.php"); ?>
