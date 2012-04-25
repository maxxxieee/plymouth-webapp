<?php

namespace PSU\SubmissionApproval;

class Notification extends \PSU_Banner_DataObject implements \PSU\ActiveRecord {

	public static function get($id) {
		$sql = "SELECT * FROM sa_notifications WHERE id = :the_id";
		$row = \PSU::db('banner')->GetRow( $sql, array('the_id' => $id) );
		return new static( $row );
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
		} else {
						$field = 'slug';
						$value = $ident;
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
						FROM psu.sa_notifications
						WHERE $where
		";
		$row = \PSU::db('banner')->GetRow( $sql, $args );
		return $row;
	}//end row

	/**
	 * save submission data
	 *
	 * @param $method \b method of saving. insert or merge
	 */
	public function save( $method = 'merge' ) {
		$this->validate('sa_notifications');

		$args = $this->_prep_args();
		$fields = $this->_prep_fields( 'sa_notifications', $args, true, false );

		$sql_method = '_' . $method . '_sql';
		$sql = $this->$sql_method( 'sa_notifications', $fields );
		
		return \PSU::db('banner')->Execute( $sql, $args );
	}//end save

	/**
	 * merge record SQL
	 */
	protected function _merge_sql( $table, $fields ) {
		$on = array(
						'the_id',
						'submission_id',
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
						'code' => $this->code,
						'date_sent' => $this->date_sent ? \PSU::db('banner')->BindDate( $this->date_sent) : null,
		);
		$args['date_sent'] = $args['date_sent'] !== 'null' ? $args['date_sent'] : PSU::db('banner')->BindDate( time() );

		return $args;
	}//end _prep_args



}//end class \PSU\SubmissionApproval\Submission
