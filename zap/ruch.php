<!DOCTYPE HTML>
<html lang="pl">
<head>
	<title>Edycja</title>
	<?php include ("meta5.html"); ?>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
	<script type="text/javascript">
        $(document).ready(function () {
            //alert('redy');
            $('ul').sortable({
                axis: 'y',
                stop: function (event, ui) {
                    var data = $(this).sortable('serialize');
                    $('#1').text(data);
                    /*$.ajax({
                            data: oData,
                        type: 'POST',
                        url: '/your/url/here'
                    });*/
            }
            });
        });
    </script>
</head>
<body>
	<section id="place-holder">
<ul id="sortable">
    <li id="item-1">Item 1</li>
    <li id="item-2">Item 2</li>
</ul>
Query string: <span id='1'></span>
	</section>
	<footer>
	<!--<div id="count"></tr><div id="count2"></tr>-->
	</footer>
	<div id="debugger">
		<?php
		//echo "post";
		//var_dump (@$_POST);
		//echo "session";
		//var_dump ($_SESSION);
		//echo "files";
		//var_dump (@$_FILES);
		// echo "var2";
		// var_dump ($var2);	
		//echo "cookies";
		//var_dump ($_COOKIE);
		?>
	</div>
</body>
</html>
