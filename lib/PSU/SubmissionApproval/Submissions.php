<?php

namespace PSU\SubmissionApproval;

class Submissions extends \PSU\Collection {
	public static $child = '\PSU\SubmissionApproval\Submission';

	public function get() {
		$sql = "
			SELECT *
				FROM sa_submissions
			 WHERE pidm=:pidm";
		return \PSU::db('banner')->Execute( $sql);
	}//end get
}//end class \PSU\SubmissionApproval\Submissions
