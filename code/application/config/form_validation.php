<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config = array(	
							//***** Customer forms validation *****//
							
							//pagename:     Developer name: 

					'register' => array(
				 				   		
										// array(
										// 		'field' => 'fname',
										// 		'label' => 'First Name',
										// 		'rules' => 'trim|required'
										// 	 ),

										// array(
										// 		'field' => 'lname',
										// 		'label' => 'Last Name',
										// 		'rules' => 'trim|required'
										// 	 ),
										 
										 array(
												 'field' => 'email',
												 'label' => 'Email',
												 'rules' => 'trim|required|regex_match[/^[a-zA-Z]{1}[a-zA-Z0-9-]{1,23}/]|valid_email'
											 ),									 
											  
										array(
												'field' => 'mobile',
												'label' => 'Mobile',
												'rules' => 'trim|required'
											 ),

										// array(
										// 		'field' => 'country',
										// 		'label' => 'Country',
										// 		'rules' => 'trim|required'
										// 	 ),
											 
									  //   array(
										// 		'field' => 'state',
										// 		'label' => 'State',
										// 		'rules' => 'trim|required'
										// 	 ),

                    //                     array(
										// 		'field' => 'city',
										// 		'label' => 'City',
										// 		'rules' => 'trim|required'
										// 	 ),
											 
									  //   array(
										// 		'field' => 'location',
										// 		'label' => 'Location',
										// 		'rules' => 'trim|required'
										// 	 ),	 											 


										array(
												'field' => 'password',
												'label' => 'Password',
												'rules' => 'trim|required'
											 ),


										// array(
										// 		'field' => 'zipcode',
										// 		'label' => 'Zipcode',
										// 		'rules' => 'trim|required'
										// 	 ),	  							 
									    ),


									
				'login' => array(
						array(
								 'field' => 'email',
								 'label' => 'Email',
								 'rules' => 'trim|required|regex_match[/^[a-zA-Z]{1}[a-zA-Z0-9-]{1,23}/]|valid_email'
							 ),
						array(
								'field' => 'password',
								'label' => 'Password',
								'rules' => 'trim|required'
							 )
						),

				'agent_login' => array(
						array(
								 'field' => 'email',
								 'label' => 'Email',
								 'rules' => 'trim|required|regex_match[/^[a-zA-Z]{1}[a-zA-Z0-9-]{1,23}/]|valid_email'
							 ),
						array(
								'field' => 'password',
								'label' => 'Password',
								'rules' => 'trim|required'
							 )
						),		
							
						'edit_register' => array(
				 				   		
										array(
												'field' => 'fname',
												'label' => 'FName',
												'rules' => 'trim|required|min_length[3]'
											 ),
										array(
												'field' => 'lname',
												'label' => 'LName',
												'rules' => 'trim|required|min_length[3]'
											 ),
										 
										 array(
												 'field' => 'email',
												 'label' => 'Email',
												 'rules' => 'trim|required|regex_match[/^[a-zA-Z]{1}[a-zA-Z0-9-]{1,23}/]|valid_email'
											 ),									 
											  
										array(
												'field' => 'mobile',
												'label' => 'Mobile',
												'rules' => 'trim|required|numeric|min_length[10]|max_length[10]|regex_match[/^[7-9][0-9]{9}$/]'
											 ),											 

										array(
												'field' => 'password',
												'label' => 'Password',
												'rules' => 'trim|required'
											 ),
										array(
												'field' => 'address',
												'label' => 'Address',
												'rules' => 'trim|required'
											 ), 

										array(
												'field' => 'zip',
												'label' => 'Zip',
												'rules' => 'trim|required|numeric|min_length[6]|max_length[6]|regex_match[^(0|[1-9][0-9]*)$]'
											 ),
											 
																		 
									    ),	


								'contactus' => array(
								
								array(
								 'field' => 'name',
								 'label' => 'Name',
								 'rules' => 'trim|required|min_length[3]'
							 ),
								
								array(
										 'field' => 'email',
										 'label' => 'Email',
										 'rules' => 'trim|required|regex_match[/^[a-zA-Z]{1}[a-zA-Z0-9-]{1,23}/]|valid_email'
									 ),
									 
								array(
												'field' => 'mobile',
												'label' => 'Mobile',
												'rules' => 'trim|required|numeric|min_length[10]|max_length[10]|regex_match[/^[7-9][0-9]{9}$/]'
											 ),	
											 
								/*array(
										'field' => 'message',
										'label' => 'Message',
										'rules' => 'trim|required'
									 )*/
						),			
						
				 
				'billing_form' => array(
				 				   		
							//***** Billing Form *****//		

										array(
												'field' => 'dfname',
												'label' => 'First Name',
												'rules' => 'trim|required|min_length[3]'
											 ),
										 
										 array(
												'field' => 'dlname',
												'label' => 'Last Name',
												'rules' => 'trim|required|min_length[3]'
											 ),
										 

										 array(
												 'field' => 'demail',
												 'label' => 'Email',
												 'rules' => 'trim|required|regex_match[/^[a-zA-Z]{1}[a-zA-Z0-9-]{1,23}/]|valid_email'
											 ),									 
											  
										array(
												'field' => 'dmobile',
												'label' => 'Mobile',
												'rules' => 'trim|required|numeric|min_length[10]|max_length[10]|regex_match[/^[7-9][0-9]{9}$/]'
											 ),											 

										array(
												'field' => 'dcountry',
												'label' => 'Country',
												'rules' => 'trim|required'
											 ), 
											 
									    array(
												'field' => 'dstate',
												'label' => 'State',
												'rules' => 'trim|required'
											 ), 
											 
										array(
												'field' => 'dcity',
												'label' => 'City',
												'rules' => 'trim|required'
											 ), 
										array(
												'field' => 'dlocation',
												'label' => 'Location',
												'rules' => 'trim|required'
											 ), 	 

										array(
												'field' => 'dzipcode',
												'label' => 'zipcode',
												'rules' => 'trim|required'
											 ), 
										array(
												'field' => 'payment_method',
												'label' => 'payment method',
												'rules' => 'trim|required'
											 ), 
							//***** Shipping Form *****//
										// array(
										// 		'field' => 'sfname',
										// 		'label' => 'First Name',
										// 		'rules' => 'trim|required|min_length[3]'
										// 	 ),
										 
										//  array(
										// 		'field' => 'slname',
										// 		'label' => 'Last Name',
										// 		'rules' => 'trim|required|min_length[3]'
										// 	 ),
										 

										//  array(
										// 		 'field' => 'semail',
										// 		 'label' => 'Email',
										// 		 'rules' => 'trim|required|regex_match[/^[a-zA-Z]{1}[a-zA-Z0-9-]{1,23}/]|valid_email'
										// 	 ),									 
											  
										// array(
										// 		'field' => 'smobile',
										// 		'label' => 'Mobile',
										// 		'rules' => 'trim|required|numeric|min_length[10]|max_length[10]|regex_match[/^[7-9][0-9]{9}$/]'
										// 	 ),											 

										// array(
										// 		'field' => 'scountry',
										// 		'label' => 'Country',
										// 		'rules' => 'trim|required'
										// 	 ), 
											 
									  //   array(
										// 		'field' => 'sstate',
										// 		'label' => 'State',
										// 		'rules' => 'trim|required'
										// 	 ), 
											 
										// array(
										// 		'field' => 'scity',
										// 		'label' => 'City',
										// 		'rules' => 'trim|required'
										// 	 ), 
										// array(
										// 		'field' => 'slocation',
										// 		'label' => 'Location',
										// 		'rules' => 'trim|required'
										// 	 ),  

									  //   array(
										// 		'field' => 'szipcode',
										// 		'label' => 'zipcode',
										// 		'rules' => 'trim|required'
										// 	 ),								 
									    ),	
				);    
/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */
