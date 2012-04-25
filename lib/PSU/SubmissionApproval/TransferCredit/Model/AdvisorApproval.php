<?php
namespace PSU\SubmissionApproval\TransferCredit\Model;

class AdvisorApproval extends \PSU\Model{
	public function __construct($f = array(), $protected=false){
		$this->status_key = new \PSU\Model\FormSelect(array( 'label' => 'Please enter your selection using the drop down box:', 'options' => \PSU\SubmissionApproval\Status::get_statuses(), 'required' => 1, 'maxlength' => 60, 'name'=>meta[1]));
		$this->notes = new \PSU\Model\FormTextarea('rows=10&cols=85&label=Additional Comments (optional)&name=meta[24]');
		parent::__construct($f, $priviledged);
	}
}//end class \PSU\SubmissionApproval\TransferCredit\Model\AdvisorApproval
