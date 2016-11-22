
<html>
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
	<script src="script.js"></script>
</head>
<body>

<div ng-app="">
	<div >
		<select  ng-model="Bah">
			<option value="{id : 1, t : '0' }" data-tes="0">1</option>
			<option value="{id : 2, t : '1' }" data-tes="2">2</option>
			<option value="{id : 3, t : '0' }" data-tes="31">3</option>
			<option value="{id : 4, t : '0' }" data-tes="4">4</option>
		</select>
		<input type="text" ng-if="Bah.t =='1'">
		
	</div>


</div>


</body>
</html>