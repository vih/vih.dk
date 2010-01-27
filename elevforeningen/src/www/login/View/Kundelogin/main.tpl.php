<html>
	<head>
		<title><?php e($title); ?></title>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859" />
		<style type="text/css">
			html {
				font-size: 80%;
			}
			body {
				text-align: center;
				font-family: "trebuchet ms", verdana, sans-serif;
				font-size: 1em;
			}
			#container {
				padding: 1em 2em;
				margin: auto;
				border: 8px solid #ddd;
				width: 800px;
				text-align: left;
			}
			#registration-col1 {
				width: 65%;
				margin-bottom: -30em;
				padding-bottom: 30em;
				float: left; 
			}
			
			#registration-col2 {
				width: 30%;
				margin-bottom: -30em;
				padding-bottom: 30em;
				float: right; 
			}
			
			#content {
				clear: both;
			}
					
			p#logout {
				float: right;
			}
			p#status {
				background: #ddd;
				font-size: 1.5em;
				padding: 0.3em;
				text-align: center;
			}
			p#status span {
				font-size: 0.6em;
				display: block;
				text-align: left;
				padding: 0.3em;
			}
			p.notice, p#notice {
				background: #ccee66;
				padding: 0.5em;
			}

			table {
				width: 100%;
				font-size: 1em;
				margin-bottom: 1em;
			}
			caption {
				background: #ddd;
				padding: 0.5em;
				font-weight: bold;
			}
			th, td {
				text-align: left;
				vertical-align: top;
			}
			
			tfoot td {
				border-top: 1px solid #ccc;
				background: #eee;
				font-size: 0.9em;
				text-align: center;
				margin-top: 1em;
			}
			#betalingsoversigt td, #prisoversigt td {
				text-align: right;
			}
			a {
				text-decoration: none;
			}
			a:hover {
				text-decoration: underline;
			}
			
			#call {
				background: darkblue;
				color: white;
				padding: 0.3em;
			}
			
			#call span {
				font-size: 1.8em;
				text-align: center;
				display: block;

			}
			
			span.dankort {
				background: url(/gfx/icons/dankort.jpg) no-repeat right;
				padding-right: 30px;
			}
			
				dt {
					font-weight: bold;
				}			
			@media print {
				#container {
					margin: 0;
					padding: 1em;
					width: 100%;
				}
				.notice {
					border: 1px solid black;
					padding: 0.5em;
				}
				#status {
					border: 1px solid black;
				}
				a {
					display: none;
				}
				caption {
					border: 1px solid black;
				}
				#content-main {
					margin: 0;
					padding: 0;
				}
				#content-sub {
					margin: 0;
					padding: 0;
				}
				#logout {
					display: none;
				}
				#call {
					border: 1px solid black;
				}

			}
		</style>

	</head>
	
	<body>
		<div id="container">
            <?php if (!empty($this->document->navigation)): ?>
			<p id="logout">
                <?php foreach ($this->document->navigation as $url => $name): ?>
                    <a href="<?php e($url); ?>"><?php e($name); ?></a>
                <?php endforeach; ?>
            </p>
            <?php endif; ?>
			
			<div id="content">
				<?php echo $content; ?>
			</div>

			<p style="clear: both;" />&nbsp;</p>

		</div>
		
	</body>

</html>
