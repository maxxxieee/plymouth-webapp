<?php
namespace PSU\SubmissionApproval;

class TransferCredit{

		public static function get_status_listings($pidm) {
			$person= \PSUPerson::get($pidm);
			$fullname = "$person->first_name $person->last_name $person->middle_name";

			$args=array(
								'pidm'=>$pidm,
								'fullname'=>$fullname,
				);
			$sql = "SELECT	:fullname fullname,
											b.name form_name,
											a.signed_date initial_signed_date,
											e.name meta_id,
											c.meta_value meta_value
								FROM	sa_submission a,
											sa_type b,
											sa_submission_meta c,
                      sa_submission_status d,
											sa_meta_keys e
							 WHERE	pidm=:pidm
							   AND	a.id=c.submission_id
								 AND	a.type_id=b.id
                 AND  d.submission_id=a.id
								 AND	c.meta_key_id=e.id
						ORDER BY	d.submission_id";
			$student_recs = \PSU::db('banner')->Execute( $sql, $args );
			return $student_recs;
		}// end get_status_listings

		public static function get_level() {
			$level=array(
				'upper'=>'upper level 3000-4000',
				'lower'=>'lower level 1000-2000',
			);
			return $level;
		}// end get_level

		public static function get_responses($pidm) {
			$person= \PSUPerson::get($pidm);
			if($person->advisors[0]){
				$person->advisors[0]->formatName('f m l');
			}
			$args=array(
								'pidm'=>$pidm,
								'advisor'=>$advisor,
				);

			$sql = "SELECT	DISTINCT d.status_code status,
											:advisor advisor,
                      d.assigned_to_group assigned_to_group,
                      d.notes notes,
                      d.signed_date approval_signed_date
								FROM	sa_submission a,
											sa_type b,
											sa_submission_meta c,
                      sa_submission_status d,
											sa_meta_keys e
							 WHERE	pidm=:pidm
							   AND	a.id=c.submission_id
								 AND	a.type_id=b.id
                 AND  d.submission_id=a.id
								 AND	c.meta_key_id=e.id";
			$responses = \PSU::db('banner')->Execute( $sql, $args );
			return $responses;
		}//end get_responses

		public static function get_all_responses(){
					$sql = "SELECT	DISTINCT a.id,
													d.status_code status,
													d.assigned_to_group assigned_to_group,
													d.notes notes,
													d.signed_date approval_signed_date
										FROM	sa_submission a,
													sa_type b,
													sa_submission_meta c,
													sa_submission_status d,
													sa_meta_keys e
									 WHERE	a.id=c.submission_id
										 AND	a.type_id=b.id
										 AND  d.submission_id=a.id
										 AND	c.meta_key_id=e.id
								ORDER BY	a.id";
			$responses = \PSU::db('banner')->Execute( $sql, $args );
			return $responses;
	
		}//end get_all_responses

		public static function is_advisor($pidm) {
			$sql="SELECT	1
							FROM	sa_submission_status
						 WHERE	assigned_to_pidm = :pidm
						   AND	signed_date IS NULL
							 AND	rownum=1";
			$advisee_exists = \PSU::db('banner')->GetOne( $sql, array('pidm'=>$pidm));
			return $advisee_exists;
		}// end is_advisor

		public static function is_chair($major) {
			
		}// end is_chair

		public static function get_advisee_listings($pidm) {
			// need to get this person's advisees.... 
			$sql = "SELECT	a.id id,
											a.pidm advisee_pidm,
											d.spriden_first_name||' '||d.spriden_last_name||' '||substr(d.spriden_mi,1,1) fullname,
											c.name form_type,
											a.signed_date date_submitted
								FROM	sa_submission a,
											sa_submission_status b,
											sa_type c,
											spriden d
							 WHERE	b.assigned_to_pidm=:pidm
							   AND	d.spriden_pidm=a.pidm
								 AND	d.spriden_change_ind IS NULL
								 AND	a.id=b.submission_id
								 AND	c.id=a.type_id
								 AND	b.signed_date IS NULL";
			$student_recs = \PSU::db('banner')->Execute( $sql, array('pidm'=>$pidm));
			return $student_recs;
		}//end get_advisee_listings

		public static function get_chair_listings($pidm) {
			$sql = "SELECT	a.id id,
											a.pidm chair_pidm,
											d.spriden_first_name||' '||d.spriden_last_name||' '||substr(d.spriden_mi,1,1) fullname,
											c.name form_type,
											a.signed_date date_submitted
								FROM	sa_submission a,
											sa_submission_status b,
											sa_type c,
											spriden d
							 WHERE	b.assigned_to_pidm=:pidm
							   AND	d.spriden_pidm=a.pidm
								 AND	d.spriden_change_ind IS NULL
								 AND	a.id=b.submission_id
								 AND	c.id=a.type_id
								 AND	b.signed_date IS NULL";
			$student_recs = \PSU::db('banner')->Execute( $sql, array('pidm'=>$pidm));
			return $student_recs;
		}//end get_advisee_listings

		public static function get_open_submissions() {
			$sql = "SELECT	DISTINCT a.id id,
											a.pidm student_pidm,
											d.spriden_first_name||' '||d.spriden_last_name||' '||substr(d.spriden_mi,1,1) fullname,
											c.name form_type,
											a.signed_date date_submitted
								FROM	sa_submission a,
											sa_submission_status b,
											sa_type c,
											spriden d
							 WHERE	d.spriden_pidm=a.pidm
								 AND	d.spriden_change_ind IS NULL
								 AND	a.id=b.submission_id
								 AND	c.id=a.type_id
						ORDER BY	a.id";
			$student_recs = \PSU::db('banner')->Execute( $sql);
			return $student_recs;
		}//end get_open_submissions


		public static function get_institutions() {
			$data=array();
			$sql="	SELECT	DISTINCT sxrtrns_ceeb,
											sxrtrns_college_name
								FROM	sxrtrns
						ORDER BY	sxrtrns_college_name";
			$results=\PSU::db('banner')->Execute($sql);
			while($row=$results->FetchRow()){
			$data[]=(array($row['sxrtrns_ceeb'], $row['sxrtrns_college_name']));
			}
			return $data;
		}

		public static function notify_advisor($submission_id){
			$sql=" Insert into sa_notifications (
				id,
				submission_id,
				code,
				date_sent
			)values(
				9999,
				:submission_id,
				'advisor',
				SYSDATE
				)";
			$results = \PSU::db('banner')->Execute( $sql, array('submission_id'=>$submission_id));
			return $results;
		}

}//end \PSU\SubmissionApproval\TransferCredit