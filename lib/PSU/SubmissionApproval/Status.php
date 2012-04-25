<?php

namespace PSU\SubmissionApproval;

class Status extends \PSU_Banner_DataObject implements \PSU\ActiveRecord {

        public static function get($id) {
					$sql = "SELECT * FROM sa_submission_status WHERE submission_id = :id";
					$current_status=\PSU::db('banner')->Execute($sql, array('id'=>$id));
					return $current_status;
        }

				public static function get_status_record($args) {
					$sql = "SELECT * 
										FROM sa_submission_status 
									 WHERE assigned_to_pidm=:assigned_to_pidm
									   AND submission_id=:submission_id
										 AND signed_date IS NULL";
					$row = \PSU::db('banner')->GetRow($sql,$args);
					return $row;
				}

        public static function get_statuses() {
					$data=array();
					$sql = "SELECT	id,
													name
										FROM	sa_meta_options 
								ORDER BY	id, 
													name";
					$results=\PSU::db('banner')->Execute($sql);
					$data[]=(array($row['id'], $row['name']));
					return $data;
        }

				public static function get_meta_option($meta_id) {
						$sql = "SELECT meta_option
											FROM	sa_meta_options
										 WHERE	id=:meta_id";
						return \PSU::db('banner')->GetOne($sql, array('meta_id'=>$meta_id));
				}

        public function delete() {
					// TODO: add business logic.. not sure if we're going to use this yet
					echo "I'm deleting myself!";
        }//end delete

        /**
         * Helper 
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
							FROM psu.sa_submission_status
							WHERE $where
					";
					$row = \PSU::db('banner')->GetRow( $sql, $args );
					return $row;
        }//end row

        /**
         * save Status data
         *
         * @param $method \b method of saving. insert or merge
         */
        public function save( $method = 'merge' ) {
					//echo "in function save... should be in method: ".$method."<br />";
					$this->validate('sa_submission_status');

					$args = $this->_prep_args();

					$fields = $this->_prep_fields( 'sa_submission_status', $args, true, false );

					$sql_method = '_' . $method . '_sql';
					$sql = $this->$sql_method( 'sa_submission_status', $fields );

					return \PSU::db('banner')->Execute( $sql, $args );
        }//end save

        /**
         * merge record SQL
         */
        protected function _merge_sql( $table, $fields ) {
					$on = array(
						'the_id',
						'submission_id',
						'status_code',
						'assigned_to_pidm',
						'assigned_to_group',
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
							'status_code' => $this->status_code,
							'assigned_to_pidm' =>$this->assigned_to_pidm,
							'assigned_to_group' =>$this->assigned_to_group,
							'notes' =>$this->notes,
							'signed_date' => $this->signed_date ? \PSU::db('banner')->BindDate( $this->signed_date) : null,
					);
					$args['signed_date'] = $args['signed_date'] !== 'null' ? $args['signed_date'] : \PSU::db('banner')->BindDate( time() );

					return $args;
        }//end _prep_args


}//end class \PSU\SubmissionApproval\Status
