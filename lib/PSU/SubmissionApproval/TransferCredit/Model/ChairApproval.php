<?php
namespace PSU\SubmissionApproval\TransferCredit\Model;

class ChairApproval extends \PSU\Model{
	public function __construct($f = array(), $protected=false){
		$this->acceptable = new \PSU\Model\FormSelect( array( 'label' => 'Is the transfer course acceptable for transfer to PSU', 'options' => \PSU\Model\FormSelect::yesno(),'required'=>1, 'maxlength'=>3,'name'=> 'meta[25]'));
		$transfercredit = new \PSU\SubmissionApproval\TransferCredit;
		$this->level = new \PSU\Model\FormSelect(array( 'label' => 'Is the transfer course equivilent to PSU coursework?:', 'options' => \PSU\SubmissionApproval\TransferCredit::get_level(), 'required' => 1, 'maxlength' => 60, 'name' =>'meta[28]'));
		$this->equivalent = new \PSU\Model\FormText('label=If the transfer course id equivalent to a PSU course, what is the PSU course discipline/number?:&maxlength=75&required=1&name=meta[29');
		$this->satisfies_major_req = new \PSU\Model\FormText('label=Number transfer credits:&maxlength=75&required=1&name=meta[33]');
		$this->satisfies_major_elect = new \PSU\Model\FormText('label=Number transfer credits:&maxlength=75&required=1&name=meta[34]');
		$this->satisfies_minor_req = new \PSU\Model\FormText('label=Number transfer credits:&maxlength=75&required=1&name=meta[35]');
		$this->satisfies_minor_elect = new \PSU\Model\FormText('label=Number transfer credits:&maxlength=75&required=1&name=meta[36]');
	}
}//end class \PSU\SubmissionApproval\TransferCredit\Model\Submission