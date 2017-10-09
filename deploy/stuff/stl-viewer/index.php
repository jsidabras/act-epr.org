
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>STL Viewer</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<style>
			canvas {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  z-index: -9999;
}

			body {
				font-family: Monospace;
				background-color: #000000;
				margin: 0px;
				overflow: hidden;
				position: relative;
			}

			#info {
				color: #fff;
				position: absolute;
				top: 10px;
				width: 100%;
				text-align: center;
				z-index: 100;
				display:block;

			}

			a {
				color: skyblue;
			}
			.button {
				background: #999;
				color: #eee;
				padding: 0.2em 0.5em;
				cursor: pointer;
			}
			.highlight {
				background:orange;
				color:#fff;
			}

			span {
				display: inline-block;
				width: 60px;
				float: left;
				text-align: center;
			}

			#uploader {
    			border: 3px white solid;
    			margin-top: 10px;
    			margin-left: -85px;
    			left: 100%;
    			color: white;
    			background: black;
    			padding: 5px;
    			font-family: Monospace;
    			position: absolute;
			}

			#uploader input {
				background: none;
				font-family: monospace;
				color: white;
    			border: none;
			}
			.pp-slider {
				display: inline-block;
				width: 150px;
				-webkit-user-select: none;
				-khtml-user-select: none;
				-moz-user-select: none;
				-o-user-select: none;
				user-select: none;
				height: 30px;
			}
		    .pp-slider .pp-slider-scale {
		    	background-color: #aaa;
		    	height: 1px;
		    	border-bottom: 1px solid #efefef;
		    	width: 120px;
		    	margin-top: 6px;
		    	float: left;
		    }
		    .pp-slider .pp-slider-scale .pp-slider-button {
		    	width: 12px;
		    	border-radius: 2px;
		    	border: 1px solid #adadad;
		    	height: 16px;
		    	position: relative;
		    	top: -7px;
		    	left: 0px;
		    	background-color: #efefef;
		    	cursor: pointer;
		    }
		    .pp-slider .pp-slider-scale .pp-slider-button .pp-slider-divies {
		    	border-left: 1px solid #adadad;
		    	border-right: 1px solid #adadad;
		    	position: relative;
		    	left: 3px;
		    	top: 3px;
		    	width: 4px;
		    	height: 10px;
		    }
		    .pp-slider .pp-slider-scale .pp-slider-button:hover {
		    	border-color: #777;
		    	background-color: #eee;
		    }
		    .pp-slider .pp-slider-scale .pp-slider-tooltip {
		    	width: 24px;
		    	height: 20px;
		    	position: relative;
		    	top: -5px;
		    	left: 0px;
		    	text-align: center;
		    	font-size: 10px;
		    	color: #aaa;
		    }
		    .pp-slider .pp-slider-min {
		    	float: left;
		    	width: 15px;
		    	color: #aaa;
		    	font-size: 10px;
		    }
		    .pp-slider .pp-slider-max {
		    	float: left;
		    	width: 15px;
		    	color: #aaa;
		    	font-size: 10px;
		    	text-align: right;
		    }

		    #controls {
		    	top: 100%;
		    	left: 100%;
    			margin-top: -35px;
    			margin-left: -315px;
    			position: fixed;
    			font-family: monospace;
		    }

		    #selector {
		    	top: 100%;
    			margin-top: -145px;
    			margin-left: 15px;
    			position: fixed;
		    }
		    #selector select {
		    	height: 130px;
		    	padding: 5px;
		    	font-family: monospace;
		    	background: none;
		    	border: none !important;
		    	 outline:0px;
		    }
		    
			::-webkit-scrollbar {
			  width: 5px;
			  height: 5px;
			}
			::-webkit-scrollbar-button {
			  width: 0px;
			  height: 0px;
			}
			::-webkit-scrollbar-thumb {
			  background: #e1e1e1;
			  border: 0px none #ffffff;
			  border-radius: 0px;
			}
			::-webkit-scrollbar-thumb:hover {
			  background: #ffffff;
			}
			::-webkit-scrollbar-thumb:active {
			  background: #000000;
			}
			::-webkit-scrollbar-track {
			  background: #666666;
			  border: 0px none #ffffff;
			  border-radius: 0px;
			}
			::-webkit-scrollbar-track:hover {
			  background: #666666;
			}
			::-webkit-scrollbar-track:active {
			  background: #333333;
			}
			::-webkit-scrollbar-corner {
			  background: transparent;
			}
</style>
		</style>
	</head>
	<body>
		<div id="info">
			<!-- Based on work by <a href="https://github.com/aleeper">aleeper</a> -->
			<form action="upload.php" method="post" enctype="multipart/form-data">
    			Select STL to upload:
    			<input type="file" name="stl" />
         		<input type="submit" value="Upload"/>
			</form>
			<br>
		</div>

		<div id="selector">
			<select id="selectBox" name="interests" size="5" onchange="changeFunc();">
	 			<?php 
	 			$models = array_slice(scandir("models"), 2); 
				
				foreach ($models as $stl) {
				echo "<option value='$stl'>$stl</option><br>";
				}
?>
			</select>
		</div>

		<div id="controls">
			<input type="hidden" value="40" id="slider1"/>
		</div>

		<!-- <div id="uploader">
			<form action="upload.php" method="post" enctype="multipart/form-data">
				<input type="submit" value="Upload" name="submit"></input>
			</form>
		</div> -->

		<script src="js/three.min.js"></script>
		<script src="js/STLLoader.js"></script>
		<script src="js/OrbitControls.js"></script>
		<script src="js/Detector.js"></script>
		<script src="js/stats.min.js"></script>
		<script src="js/STLViewer.js"></script>
		<script src="js/jquery.min.js"></script>
		<script src="js/slider.js"></script>

	</body>
</html>
