<?php


	
	function dateFr($date) {

		$dateFr = date('d-m-Y', strtotime($date));
		return $dateFr;
	}