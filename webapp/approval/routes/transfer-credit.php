<?php

respond(function($request, $response, $app){
	$app->person = PSUPerson::get( $pidm );
	PSU::get()->banner=PSU::db('test');
	IDMObject::authN();
	$app->user = PSUPerson::get($pidm);
	$app->id = $_REQUEST['id'];
	$app->authz = IDMObject::loadAuthZ($pidm);
	//$isadvisor = $app->user->advisees; 
});

respond('GET', '/?', function($request, $response, $app){
	$app->tpl->assign( 'person', $app->person );
	$form=new \PSU\SubmissionApproval\TransferCredit\Model\Submission;
	$app->tpl->assign('form',$form);
	$submission_id=$_REQUEST['id'];
	$app->tpl->assign('submission_id',$submission_id);
	$transfercredit = new \PSU\SubmissionApproval\TransferCredit;
	$advisor_pidm=$app->person->advisors[0]->pidm;
	if($app->person->advisors[0]->pidm){
		$advisor_name=$app->person->advisors[0]->formatName('f m l');
	}
	$responses=$transfercredit->get_responses($app->user->pidm);
	$app->tpl->assign('responses',$responses);
	$app->tpl->assign('advisor_pidm',$advisor_pidm);
	$app->tpl->assign('advisor_name',$advisor_name);
	$app->tpl->assign('submission_id',$submission_id);
	$app->tpl->assign('transfercredit',$transfercredit->get_status_listings($app->user->pidm));
	//if the requested id exists then a submission was made... so off to next notification
	if($_REQUEST_id){
		$app->tpl->display('transfer-credit/form.advisor-list.tpl');
	}else{
		$app->tpl->display('transfer-credit/form.submission-list.tpl');
	}
});


respond('GET', '/view/?[:form_id]?', function ($request, $response, $app) {
	$app->tpl->assign( 'person', $app->person );
	$form=new \PSU\SubmissionApproval\TransferCredit\Model\Submission;
	$app->tpl->assign('form',$form);
	$submission_id=$_REQUEST['submission_id'];
	$app->tpl->assign('submission_id',$submission_id);
	$app->person = PSUPerson::get( $app->user->pidm );
	$app->tpl->assign( 'person', $app->person );

	$fullname=$person->first_name." ".$person->last_name;
	$advisor_pidm=$app->person->advisors[0]->pidm;
	if($advisor_pidm){
		$advisor_name=$app->person->advisors[0]->formatName('f m l');
	}
	$app->tpl->assign('advisor_pidm',$advisor_pidm);
	$app->tpl->assign('advisor_name',$advisor_name);
	$submission = new \PSU\SubmissionApproval\Submission;
	$app->tpl->assign('submission',$submission);
	//if the requested id exists then a submission was made... so off to next notification
	if($_REQUEST_id){
		$app->tpl->display('transfer-credit/form.advisor.tpl');
	}else{
		$app->tpl->display('transfer-credit/form.submission.tpl');
	}
});

respond('POST', '/submit/?[:form_id]?', function ($request, $response, $app) {
	if (!$_REQUEST['signed_date']){
		$signed_date=date("d-M-Y"); 
	}else{          
		$signed_date=$_REQUEST['signed_date'];
	}
	$app->tpl->assign('signed_date',$signed_date);
	$app->person = PSUPerson::get( $app->user->pidm );
	$app->tpl->assign( 'person', $app->person );
	$transfercredit= new \PSU\SubmissionApproval\TransferCredit;

	$_POST['pidm']=$app->user->pidm;
	$sub = new \PSU\SubmissionApproval\Submission($_POST);
	\PSU::db('banner')->debug=true;
	$sub->save();
	foreach($_POST['meta'] as $key=>$val){
		$args=array(
			'id' => '1',
			'submission_id' => $sub->id,
			'source_pidm' => $sub->pidm,
			'meta_key_id' => $key,
			'meta_value'=>$val,
			);
		$metavalue = new \PSU\SubmissionApproval\MetaValue($args);
		$metavalue->save();
	}

	$args=array(
		'id' => '1',
		'submission_id'=>$sub->id,
		'status_code'=>$_REQUEST['status_key'],
		'assigned_to_pidm'=> $app->person->advisors[0]->pidm,
		'assigned_to_group'=>'transfer_credit_admin',
		'notes'=>$_REQUEST['notes'],
		'signed_date'=>$signed_date,
		);
	$status = new \PSU\SubmissionApproval\Status($args);
	$status->save();


	if($_REQUEST['status_key']==="awaiting approval"){
		$args=array('id'=>'1',
					'submission_id'=>$sub->id,
					'code'=>'request to advisor',
					'date_sent'=>date("d-M-Y"),
					);
		$notification = new \PSU\SubmissionApproval\Notification($args);
		$notification->save();

		//Notification to advisor.....(all this stuff needs to be moved to appropriate classes)
		$to = "max@mail.plymouth.edu";
		$subject = "Advisee needs a signoff for Transfer Credit";
		$message = "Apparently you are this student's advisor who needs a signoff to approve this information shown here:   https://max.psudev.com/webapp/approval/transfer-credit/view/".$sub->id."  Thank You!";
		$from = $_REQUEST['email'];
		$headers = "FROM: {$from}";
		$result = mail($to, $subject, $message, $headers);
	}
	 $response->redirect( '../../' );
});




