<?php
/**
 * This is the main configuration file for SimpleSAMLphp.
 *
 * @package SimpleSAMLphp
 */

$config = array(
	'admin'            => array(
		'core:AdminPassword',
	),

	'example-userpass' => array(
		'exampleauth:UserPass',

		'users' => array(
			'faculty:faculty' => array(
				'uid'                    => array( 'faculty-user' ),
				'cwlLoginName'           => array( 'faculty-user' ),
				'cwlLoginKey'            => array( '12345678' ),
				'ubcEduCwlPuid'          => array( '12345678' ),
				'eduPersonAffiliation'   => array( 'faculty' ),
				'mail'                   => array( 'faculty@ubc.ca' ),
				'eduPersonPrincipalName' => array( 'faculty-user@ubc.ca' ),
				'eduPersonEntitlement'   => array( 'urn:mace:ubc.ca:library' ),
				'employeeNumber'         => array( '4520000' ),
				'givenName'              => array( 'John' ),
				'sn'                     => array( 'Faculty' ),
				'eduPersonTargetedId'    => array( 'http://localhost:8080!https://your-app!ID123456789' ),
				'isMemberOf'             => array( 'Services:Email:User' ),
			),

			'student:student' => array(
				'uid'                    => array( 'student-user' ),
				'cwlLoginName'           => array( 'student-user' ),
				'cwlLoginKey'            => array( '87654321' ),
				'ubcEduCwlPuid'          => array( '87654321' ),
				'eduPersonAffiliation'   => array( 'student' ),
				'mail'                   => array( 'student@ubc.ca' ),
				'eduPersonPrincipalName' => array( 'student-user@ubc.ca' ),
				'eduPersonEntitlement'   => array( 'urn:mace:ubc.ca:library' ),
				'studentNumber'          => array( '12345678' ),
				'givenName'              => array( 'Jane' ),
				'sn'                     => array( 'Student' ),
				'eduPersonTargetedId'    => array( 'http://localhost:8080!https://your-app!ID987654321' ),
				'isMemberOf'             => array( 'Services:Email:User' ),
			),

			'staff:staff'     => array(
				'uid'                    => array( 'staff-user' ),
				'cwlLoginName'           => array( 'staff-user' ),
				'cwlLoginKey'            => array( '11223344' ),
				'ubcEduCwlPuid'          => array( '11223344' ),
				'eduPersonAffiliation'   => array( 'staff' ),
				'mail'                   => array( 'staff@ubc.ca' ),
				'eduPersonPrincipalName' => array( 'staff-user@ubc.ca' ),
				'employeeNumber'         => array( '99887766' ),
				'givenName'              => array( 'Staff' ),
				'sn'                     => array( 'Member' ),
				'eduPersonTargetedId'    => array( 'http://localhost:8080!https://your-app!ID11223344' ),
				'isMemberOf'             => array( 'Services:Email:User' ),
			),
		),
	),
);
