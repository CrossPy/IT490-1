<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	ini_set('display_errors' , 1);
	
function getPrepareGameScedule($array, $displayNum) {
	$modal = null;
	$result = null;
	
	if (empty($array[0])) {
				$result = '<tr><td colspan="2">There are no scheduled games in the next week.</td></tr>';
			}
	else {                                
		for ($i = 0; $i < count($array) && $i < $displayNum; $i++){
			$result .= '<tr><td>' . $array[$i]['team1'] . ' vs ' .  $array[$i]['team2'] . '</td><td>' . 
			date("Y-m-d h:i:sa", strtotime($array[$i]['start'])) . '</td><td><button type="button" 
			class="btn btn-primary btn-block" data-toggle="modal" data-target="#' . $array[$i]['id'] . 
			'" >Place Bet</button></td></tr>';
			
			$modal .= '<div id="' .$array[$i]['id'] . '" class="modal fade" role="dialog">
						<div class="modal-dialog">
						<div class="modal-content" style="color: black; text-align: center;">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h1 class="modal-title">Football</h1>
								<h2 class="modal-title">' . $array[$i]['team1'] . ' vs ' .  $array[$i]['team2'] . '</h2>
								<h3 class="modal-title">' . date("Y-m-d h:i:sa", strtotime($array[$i]['start'])) . '</h3>
							</div>
							<div class="modal-body">
								<form>
									<input type="hidden" name="id" value="' . $array[$i]['id'] . '">
									<div class="col-sm-6" style="text-align: center;">
										<label for="team1">' . $array[$i]['team1'] . '</label><br/>
										<input type="radio" name="team" value="' . $array[$i]['team1'] . '">
									</div>
									<div class="col-sm-6" style="text-align: center;">
										<label for="team2">' .  $array[$i]['team2'] . '</label><br/>
										<input type="radio" name="team" value="' .  $array[$i]['team2'] . '">
									</div>
									<div class="form-group">
										<label for="amount">Amount</label>
										<input type="number" id="amount" class="form-control" name="amount" step="0.01" min="0.01" placeholder="0.00" autocomplete="off"/>
									</div>
									<div>
										<button type=submit class="btn btn-primary btn-block">Place Bet</button>
									</div>											
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
						</div>
						</div>';
		}
	}
	return array($result, $modal);
}

?>