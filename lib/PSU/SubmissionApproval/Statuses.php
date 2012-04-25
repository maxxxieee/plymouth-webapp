<?php

namespace PSU\SubmissionApproval;

class Statuses extends \PSU\Collection {
        public static $child = '\PSU\SubmissionApproval\Statuses';

        public function get() {
                $sql = "SELECT * FROM sa_submission_status";
                $results = \PSU::db('banner')->Execute($sql);
                return $results;
        }//end get


        public function delete(){
                // TODO: add business logic.. not sure if we're going to use this yet
                echo "I'm in delete...";
        }

}//end class \PSU\SubmissionApproval\Submissions
