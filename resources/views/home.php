<!DOCTYPE html>
<html lang="en" ng-app="softjob">
<head>
	<meta charset="UTF-8">
	<base href="/">
	<title>Softjob : {{ pageTitle }}</title>
	<link rel="stylesheet" href="dist/lib.css"/>	


	<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"/>
	<link rel="stylesheet" href="dist/style.css">
	<script type="text/javascript">
		WebFontConfig = {
			google: { families: [ 'Open+Sans::latin', 'Roboto:400,700:latin' ] }
		};
		(function() {
			var wf = document.createElement('script');
			wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
			'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
			wf.type = 'text/javascript';
			wf.async = 'true';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(wf, s);
		})();
	</script>
</head>
<body md-theme="indigo">

	<main id="main" ui-view></main>
<!--	<md-progress-circular id="globalProgress" md-mode="indeterminate"></md-progress-circular>-->
	<script src="dist/lib.js"></script>
	
	<script src="js/misc.js"></script>
	<script src="dist/app.js"></script>

</body>
</html>