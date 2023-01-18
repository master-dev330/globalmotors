<!DOCTYPE html>
<html>
<head>
	<title>Email</title>
</head>
<style>
	
.logo
{
	float: left;
	width: 50%;
}
h4
{
	font-weight: bold;
	font-size: 30px;
	color: orange
}
p
{
	font-size: 20px;
	
}
.verify
{
	margin-bottom: 40px;
}
.button
{
	background-color: #0077FF;
	color: #fff;
    border-radius: 10px;
    padding: 20px;
}
a
{
	text-decoration: none;
	font-weight: bold;
}
.card
{
	box-shadow: 0px 0px 1px 1px #eee;
	padding: 20px;
}
.no_account
{
	padding-top: 20px;
}
</style>
<body>

	<div class="card">
	<div class="logo">
		<img src="https://globalmotorshub.com/public/frontend/images/src/globalmotorslogo.png" width="150" height="50">
		<h4>Welcome</h4>
		<p class="verify">Please click the button below to verify your email address.</p>
		
		<a href="{{url(app()->getLocale().'/socialemail_verify?token=')}}{{$data['email']}}" class="button">Verify Email</a>
		<p class="no_account">If you did not create account, no further action is required</p>
		<p>Regards</p>
		<p>GlobalMotors</p>
	</div>
	<div class="image">
		<img src="https://cs.copart.com/v1/AUTH_svc.pdoc00001/LPP231/545150dc53b94da39b7b463e7617eefc_hrs.jpg" width="600" height="400">
	</div>
</div>
</body>
</html>