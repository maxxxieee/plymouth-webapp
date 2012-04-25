<?php

namespace PSU\SubmissionApproval;

class MetaValue extends \PSU_Banner_DataObject implements \PSU\ActiveRecord {

		public static function get_institution($submission_id) {
		$query="SELECT stvsbgi_desc
							FROM stvsbgi,
									 sa_submission_meta
						 WHERE submission_id=:submission_id
						   AND meta_key_id=2
               AND stvsbgi_code = rtrim(meta_value)";
		$institution=\PSU::db('banner')->GetOne($query, array('submission_id'=>$submission_id));
		return $institution;
		}//end get_institution

		public static function get($submission_id) {
		$args = array(
			'submission_id'=>$submission_id,
			);
		$sql = "SELECT k.name meta_name,
									 a.meta_value meta_value
							FROM 
									 sa_submission_meta a,
									 sa_meta_keys k
						 WHERE a.submission_id = :submission_id
               AND a.meta_key_id=k.id
					ORDER BY meta_key_id";
		$items = \PSU::db('banner')->GetAll( $sql, $args );
		return $items;
	}

	public function delete() {
		// TODO: add business logic.. not sure if we're going to use this yet
		echo "I'm deleting myself!";
	}//end delete

	/**
	 * Helper to determine whether we are querying based on a numeric
	 * row ID or a slug.
	 */
	public static function _get_field( $ident ) {
		if( is_numeric($ident) ) {
						$field = 'id';
						$value = (int)$ident;
		}
					return (object)array( 'field' => $field, 'value' => $value );
	}//end _get_field

	/**
	 * return row by key 
	 */
	public static function row( $key ) {
		$field = self::_get_field( $key );
		$where = "{$field->field} = :key";
		$args  = array( 'key' => $field->value );
		$sql = "
						SELECT *
						FROM psu.sa_submission_meta
						WHERE $where
		";
		$row = \PSU::db('banner')->GetRow( $sql, $args );
		return $row;
	}//end row

	/**
	 * save MetaValue data
	 *
	 * @param $method \b method of saving. insert or merge
	 */
	public function save( $method = 'merge' ) {
		$this->validate('sa_submission_meta');

		$args = $this->_prep_args();

		$fields = $this->_prep_fields( 'sa_submission_meta', $args, true, false );

		$sql_method = '_' . $method . '_sql';
		$sql = $this->$sql_method( 'sa_submission_meta', $fields );

		return \PSU::db('banner')->Execute( $sql, $args );
	}//end save

	/**
	 * merge record SQL
	 */
	protected function _merge_sql( $table, $fields ) {
		$on = array(
						'the_id',
						'submission_id',
						'source_pidm',
						'meta_key_id',
						'meta_value'
		);

		return parent::_merge_sql( $table, $fields, $on, false );
	}//end _merge_sql

	/**
	 * prepares arguments for DML
	 */
	protected function _prep_args() {
		// this is the data prepared for binding
		$args = array(
						'the_id' => $this->id,
						'submission_id' => $this->submission_id,
						'source_pidm' =>$this->source_pidm,
						'meta_key_id' =>$this->meta_key_id,
						'meta_value' =>$this->meta_value
		);

		return $args;
	}//end _prep_args



}//end class \PSU\SubmissionApproval\MetaValue
