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
				'eduPersonTargetedId'    => array( 'http://localhost:6122!https://your-app!ID123456789' ),
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
				'eduPersonTargetedId'    => array( 'http://localhost:6122!https://your-app!ID987654321' ),
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
				'eduPersonTargetedId'    => array( 'http://localhost:6122!https://your-app!ID11223344' ),
				'isMemberOf'             => array( 'Services:Email:User' ),
			),

				'alice:alice'     => array(
					'uid'                    => array( 'alice' ),
					'cwlLoginName'           => array( 'alice' ),
					'cwlLoginKey'            => array( '20000001' ),
					'ubcEduCwlPuid'          => array( '20000001' ),
					'eduPersonAffiliation'   => array( 'faculty' ),
					'mail'                   => array( 'alice@ubc.ca' ),
					'eduPersonPrincipalName' => array( 'alice@ubc.ca' ),
					'employeeNumber'         => array( '20000001' ),
					'givenName'              => array( 'Alice' ),
					'sn'                     => array( 'Researcher' ),
					'eduPersonTargetedId'    => array( 'http://localhost:6122!https://your-app!ID20000001' ),
					'isMemberOf'             => array( 'Services:Email:User' ),
				),

				'bob:bob'         => array(
					'uid'                    => array( 'bob' ),
					'cwlLoginName'           => array( 'bob' ),
					'cwlLoginKey'            => array( '20000002' ),
					'ubcEduCwlPuid'          => array( '20000002' ),
					'eduPersonAffiliation'   => array( 'faculty' ),
					'mail'                   => array( 'bob@ubc.ca' ),
					'eduPersonPrincipalName' => array( 'bob@ubc.ca' ),
					'employeeNumber'         => array( '20000002' ),
					'givenName'              => array( 'Bob' ),
					'sn'                     => array( 'Instructor' ),
					'eduPersonTargetedId'    => array( 'http://localhost:6122!https://your-app!ID20000002' ),
					'isMemberOf'             => array( 'Services:Email:User' ),
				),

				'quinn:quinn'     => array(
					'uid'                    => array( 'quinn' ),
					'cwlLoginName'           => array( 'quinn' ),
					'cwlLoginKey'            => array( '20000003' ),
					'ubcEduCwlPuid'          => array( '20000003' ),
					'eduPersonAffiliation'   => array( 'faculty' ),
					'mail'                   => array( 'quinn@ubc.ca' ),
					'eduPersonPrincipalName' => array( 'quinn@ubc.ca' ),
					'employeeNumber'         => array( '20000003' ),
					'givenName'              => array( 'Quinn' ),
					'sn'                     => array( 'Professor' ),
					'eduPersonTargetedId'    => array( 'http://localhost:6122!https://your-app!ID20000003' ),
					'isMemberOf'             => array( 'Services:Email:User' ),
				),
		),
	),
);
