<?php
namespace PSU\SubmissionApproval\TransferCredit\Model;

class Submission extends \PSU\Model{
	public function __construct($f = array(), $protected=false){
		$this->enrolled = new \PSU\Model\FormSelect( array( 'label' => 'Are you currently enrolled at PSU?', 'options' => \PSU\Model\FormSelect::yesno(),'required'=>1, 'maxlength'=>3,'name'=> 'meta[6]'));
		$this->failed = new \PSU\Model\FormSelect( array( 'label' => 'Was the course you wish to transfer failed at PSU?', 'options' => \PSU\Model\FormSelect::yesno(),'required'=>1, 'maxlength'=>3, 'name'=>'meta[5]'));
		$transfercredit = new \PSU\SubmissionApproval\TransferCredit;
		$this->ceeb = new \PSU\Model\FormSelect(array( 'label' => 'Transfer institution name:', 'options' => \PSU\SubmissionApproval\TransferCredit::get_institutions(), 'required' => 1, 'maxlength' => 60, 'name' =>'meta[2]'));
		$this->transfer_course_id = new \PSU\Model\FormText('label=Transfer course ID:&maxlength=75&required=1&name=meta[3]');
		$this->transfer_course_title = new \PSU\Model\FormText('label=Transfer course title:&maxlength=75&required=1&name=meta[7]');
		$this->termyear_last_taken = new \PSU\Model\FormText('label=Term/Year last taken:&maxlength=75&required=1&name=meta[8]');
		$this->numb_transfer_credits = new \PSU\Model\FormText('label=Number transfer credits:&maxlength=75&required=1&name=meta[4]');
		$this->semester_quarter_credits = new \PSU\Model\FormText('label=Semester/Quarter credits:&maxlength=75&required=1&name=meta[9]');
		parent::__construct($f, $priviledged);
	}
}//end class \PSU\SubmissionApproval\TransferCredit\Model\Submission