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
			'bio_prof:bio_prof' => array(
				'uid'                    => array( 'bio_prof' ),
				'cwlLoginName'           => array( 'bio_prof' ),
				'cwlLoginKey'            => array( '23456789' ),
				'ubcEduCwlPuid'          => array( '23456789' ),
				'eduPersonAffiliation'   => array( 'faculty' ),
				'mail'                   => array( 'bio_prof@ubc.ca' ),
				'eduPersonPrincipalName' => array( 'bio_prof@ubc.ca' ),
				'eduPersonEntitlement'   => array( 'urn:mace:ubc.ca:library' ),
				'employeeNumber'         => array( '4520001' ),
				'givenName'              => array( 'Bianca' ),
				'sn'                     => array( 'Professor' ),
				'eduPersonTargetedId'    => array( 'http://localhost:8080!https://your-app!ID234567890' ),
				'isMemberOf'             => array( 'Services:Email:User' ),
			),

			'bio_prof2:bio_prof2' => array(
				'uid'                    => array( 'bio_prof2' ),
				'cwlLoginName'           => array( 'bio_prof2' ),
				'cwlLoginKey'            => array( '45678901' ),
				'ubcEduCwlPuid'          => array( '45678901' ),
				'eduPersonAffiliation'   => array( 'faculty' ),
				'mail'                   => array( 'bio_prof2@ubc.ca' ),
				'eduPersonPrincipalName' => array( 'bio_prof2@ubc.ca' ),
				'eduPersonEntitlement'   => array( 'urn:mace:ubc.ca:library' ),
				'employeeNumber'         => array( '4520002' ),
				'givenName'              => array( 'Bernard' ),
				'sn'                     => array( 'Professor' ),
				'eduPersonTargetedId'    => array( 'http://localhost:8080!https://your-app!ID456789012' ),
				'isMemberOf'             => array( 'Services:Email:User' ),
			),

			'bio_student:bio_student' => array(
				'uid'                    => array( 'bio_student' ),
				'cwlLoginName'           => array( 'bio_student' ),
				'cwlLoginKey'            => array( '34567890' ),
				'ubcEduCwlPuid'          => array( '34567890' ),
				'eduPersonAffiliation'   => array( 'student' ),
				'mail'                   => array( 'bio_student@student.ubc.ca' ),
				'eduPersonPrincipalName' => array( 'bio_student@student.ubc.ca' ),
				'eduPersonEntitlement'   => array( 'urn:mace:ubc.ca:library' ),
				'studentNumber'          => array( '53210001' ),
				'givenName'              => array( 'Bruno' ),
				'sn'                     => array( 'Student' ),
				'eduPersonTargetedId'    => array( 'http://localhost:8080!https://your-app!ID345678901' ),
				'isMemberOf'             => array( 'Services:Email:User' ),
			),

			'bio_student2:bio_student2' => array(
				'uid'                    => array( 'bio_student2' ),
				'cwlLoginName'           => array( 'bio_student2' ),
				'cwlLoginKey'            => array( '56789012' ),
				'ubcEduCwlPuid'          => array( '56789012' ),
				'eduPersonAffiliation'   => array( 'student' ),
				'mail'                   => array( 'bio_student2@student.ubc.ca' ),
				'eduPersonPrincipalName' => array( 'bio_student2@student.ubc.ca' ),
				'eduPersonEntitlement'   => array( 'urn:mace:ubc.ca:library' ),
				'studentNumber'          => array( '53210002' ),
				'givenName'              => array( 'Beatrice' ),
				'sn'                     => array( 'Student' ),
				'eduPersonTargetedId'    => array( 'http://localhost:8080!https://your-app!ID567890123' ),
				'isMemberOf'             => array( 'Services:Email:User' ),
			),

			'bio_student3:bio_student3' => array(
				'uid'                    => array( 'bio_student3' ),
				'cwlLoginName'           => array( 'bio_student3' ),
				'cwlLoginKey'            => array( '67890123' ),
				'ubcEduCwlPuid'          => array( '67890123' ),
				'eduPersonAffiliation'   => array( 'student' ),
				'mail'                   => array( 'bio_student3@student.ubc.ca' ),
				'eduPersonPrincipalName' => array( 'bio_student3@student.ubc.ca' ),
				'eduPersonEntitlement'   => array( 'urn:mace:ubc.ca:library' ),
				'studentNumber'          => array( '53210003' ),
				'givenName'              => array( 'Bennett' ),
				'sn'                     => array( 'Student' ),
				'eduPersonTargetedId'    => array( 'http://localhost:8080!https://your-app!ID678901234' ),
				'isMemberOf'             => array( 'Services:Email:User' ),
			),

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
