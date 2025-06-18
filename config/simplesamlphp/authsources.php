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
			'faculty:faculty123password' => array(
				'uid'                        => array( 'faculty-user' ),
				'cwlLoginName'               => array( 'faculty-user' ),
				'cwlLoginKey'                => array( '12345678' ),
				'eduPersonAffiliation'       => array( 'faculty' ),
				'eduPersonScopedAffiliation' => array( 'faculty@ubc.ca' ),
				'eduPersonPrincipalName'     => array( 'faculty-user@ubc.ca' ),
				'eduPersonEntitlement'       => array( 'urn:mace:ubc.ca:library' ),
				'employeeNumber'             => array( '4520000' ),
				'givenName'                  => array( 'John' ),
				'sn'                         => array( 'Faculty' ),
				'eduPersonTargetedId'        => array( 'http://localhost:8080!https://your-app!ID123456789' ),
				'isMemberOf'                 => array( 'Services:Email:User' ),
			),

			'student:student123'         => array(
				'uid'                        => array( 'student-user' ),
				'cwlLoginName'               => array( 'student-user' ),
				'cwlLoginKey'                => array( '87654321' ),
				'eduPersonAffiliation'       => array( 'student' ),
				'eduPersonScopedAffiliation' => array( 'student@ubc.ca' ),
				'eduPersonPrincipalName'     => array( 'student-user@ubc.ca' ),
				'eduPersonEntitlement'       => array( 'urn:mace:ubc.ca:library' ),
				'studentNumber'              => array( '12345678' ),
				'givenName'                  => array( 'Jane' ),
				'sn'                         => array( 'Student' ),
				'eduPersonTargetedId'        => array( 'http://localhost:8080!https://your-app!ID987654321' ),
				'isMemberOf'                 => array( 'Services:Email:User' ),
			),
		),
	),
);
