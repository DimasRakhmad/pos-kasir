@extends('app')

@section('htmlheader_title')
Buat Jurnal
@endsection

@section('contentheader_title')
Buat Jurnal
@endsection

@section('additional_styles')
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
	<link rel="stylesheet" type="text/css" href="{{ asset('css/angular-ui-notification.min.css') }}">
	<link rel="stylesheet" href="{{asset('/plugins/datepicker/datepicker3.css')}}" />
@endsection

@section('additional_scripts')
	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.js"></script>
	<script src="{{asset('/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
	<script src="{{ asset('js/ui-bootstrap-tpls-0.14.1.min.js') }}"></script>
	<script src="{{ asset('js/angular-ui-notification.min.js') }}"></script>
	<script src="{{ asset('js/angular-locale_id-id.js') }}"></script>

	<script type="text/javascript">
		var accountingApp = angular.module('accountingApp', [
				'ui.bootstrap',
				'ui-notification'
			],
			function($interpolateProvider) {
				$interpolateProvider.startSymbol('<%');
				$interpolateProvider.endSymbol('%>');
			}
		);

		(function() {
			angular
				.module('accountingApp')
				.controller('journalController', journalController);

				function journalController($filter, $http, $log, $scope, Notification) {
					initialJournal();

					function initialJournal() {
						$scope.dt = new Date();
						$scope.transactionCode = '';
						$scope.transactionName = '';
						$scope.transactionNotes = '';
						$scope.totalDebit = 0;
						$scope.totalKredit = 0;
						$scope.transactionDetails = [{debit:'', kredit:''}];
					}

					$scope.addTransactionDetail = function() {
						$scope.transactionDetails.push({debit:'', kredit:''});
					}

					$scope.calculateTotalDebit = function() {
						var length = $scope.transactionDetails.length;
						var temp = 0;
						for (var i = 0; i < length; i++) {
							temp += Number($scope.transactionDetails[i].debit);
						};
						$scope.totalDebit = temp;
					}
					$scope.calculateTotalKredit = function() {
						var length = $scope.transactionDetails.length;
						var temp = 0;
						for (var i = 0; i < length; i++) {
							temp += Number($scope.transactionDetails[i].kredit);
						};
						$scope.totalKredit = temp;
					}

					$scope.getAccounts = function(keyword) {
						return $http.get('../search_accounts/'+keyword).then(function(response){
							console.log(response);
							return response.data;
					    });
					}

					$scope.removeTransactionDetail = function() {
						$scope.transactionDetails.pop();
					}

					$scope.saveJournal = function() {
						var date = $filter('date')($scope.dt, 'yyyy-MM-dd');
						var notes = {
							notes : $scope.transactionNotes
						};
						data = {
							detail : $scope.transactionDetails,
							transaction_code : $scope.transactionCode,
							name : $scope.transactionName,
							notes : JSON.stringify(notes),
							date : date
						};
						$http.post('../transactions', data).then(function(success) {
							console.log(success);
							initialJournal();
							Notification.success({
								message:"Jurnal berhasil disimpan.",
								positionX:"center"
							});
						}, function(error) {
							console.log(error);
							Notification.error({
								message:"Jurnal gagal disimpan, cobalah beberapa saat lagi atau periksa jaringan.",
								positionX:"center"
							});
						});
					}
				}
		})();
	</script>

	<script type="text/javascript">
	$(function() {
	    $("#datepicker").datepicker();
	});
		$(function() {
		    $('input[name="date"]').daterangepicker({
		    	"locale" : {
		    		"format" : 'D MMMM YYYY',
		    		"daysOfWeek": [
						            "Mg",
						            "Sn",
						            "Sl",
						            "Rb",
						            "Km",
						            "Jm",
						            "Sb"
						        ],
					"monthNames": [
						            "Januari",
						            "Februari",
						            "Maret",
						            "April",
						            "Mei",
						            "Juni",
						            "Juli",
						            "Agustus",
						            "September",
						            "Oktober",
						            "November",
						            "Desember"
						        ],
					"firstDay": 1
		    	},
		    	"singleDatePicker" : true
		    },
		    function (start, end, label) {
		    	$('#dt').prop("value", start.format('YYYY-MM-DD'));
		    });
		});
	</script>
@endsection


@section('main-content')
<div class="box box-primary" ng-app="accountingApp" ng-controller="journalController">
	<div class="box-body">
		<center>
			<font size="6" class="text-light-blue"><b>Jurnal</b></font> <br>
		</center>
		<form name="form" class="form-horizontal" novalidate>
			<div class="form-group">
				<label class="col-md-2 control-label">Tanggal</label>
				<div class="col-md-3">
					<div class="input-group">
						<input class="form-control" type="text" name="date" id="datepicker" value="" style="text-align:center" required/>
						<input hidden id="dt" value="" ng-model="dt">
						<div class="input-group-addon"><i class="fa fa-calendar"></i>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">Kode Transaksi</label>
				<div class="col-md-3">
					<input class="form-control" type="text" ng-model="transactionCode" required></input>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">Nama Transaksi</label>
				<div class="col-md-3">
					<input class="form-control" type="text" ng-model="transactionName" required></input>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">Keterangan</label>
				<div class="col-md-3">
					<textarea class="form-control" rows="3" ng-model="transactionNotes"></textarea>
				</div>
			</div>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th rowspan="2" width="10%"></th>
						<th rowspan="2" width="20%">Akun</th>
						<th rowspan="2" width="30%">Deskripsi</th>
						<th colspan="2"><center>Jumlah</center></th>
					</tr>
					<tr>
						<th width="20%"><center>Debit</center></th>
						<th width="20%"><center>Kredit</center></th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="detail in transactionDetails">
						<td>
							<a href="" role="button" class="btn btn-xs btn-primary" ng-click="addTransactionDetail()" ng-show="$last"><i class="fa fa-plus"></i></a>
							<a href="" role="button" class="btn btn-xs btn-danger" ng-click="removeTransactionDetail()" ng-show="$last"><i class="fa fa-minus"></i></a>
						</td>
						<td><input name="account_code" type="text" class="form-control" ng-model="detail.selectedAccount" uib-typeahead="account as account.name for account in getAccounts($viewValue)" required></td>
						<td><input type="text" class="form-control" ng-model="detail.notes" required></td>
						<td><input type="text" class="form-control" ng-model="detail.debit" ng-change="calculateTotalDebit()" ng-disabled="detail.kredit!=''"></td>
						<td><input type="text" class="form-control" ng-model="detail.kredit" ng-change="calculateTotalKredit()" ng-disabled="detail.debit!=''"></td>
					</tr>
					<tr>
						<td colspan="3" align="right"><b>Total</b></td>
						<td align="right"><b>Rp <%totalDebit | number:2%></b></td>
						<td align="right"><b>Rp <%totalKredit | number:2%></b></td>
					</tr>
				</tbody>
			</table>
			<a href="#" class="btn btn-primary pull-right" role="button" ng-disabled="form.$invalid || (totalDebit != totalKredit)" ng-click="saveJournal()">Simpan Jurnal</a>
		</form>
	</div>
</div>

@endsection
