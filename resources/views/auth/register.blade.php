@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Register</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="/auth/register">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

											<div class="form-group">
							<label class="col-md-4 control-label">Username</label>
							<div class="col-md-6">
								<input type="username" class="form-control" name="username" value="{{ old('username') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>


						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										{{--<input type="checkbox" name="terms"> Agree with <a href="/terms" target="_blank">Terms & Conditions</a>--}}
										<input type="checkbox" name="terms"> Agree with <a href="#" data-toggle="modal" data-target="#linkModal">Terms & Conditions</a>
									</label>
									{{--LinkModal--}}
									<div class="modal fade" id="linkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
												</div>
												<div class="modal-body">
													<div align="justify">
														<h4>PRIVACY POLICY</h4>

														We are committed to protecting and respecting your privacy.
														We have developed this Privacy Policy to demonstrate the basis on which any personal data we
														collect from you, or that you provide to us, will be used, shared or otherwise processed. Please take
														a few moments to read the sections below carefully to understand our views and practices regarding
														your personal data and how we will treat it.
														This Privacy Policy applies when you: (i) download, install or otherwise use our products; and (ii)
														subscribe to, access, or otherwise use our services.</div>
													<div align="justify"> <h4>INFORMATION WE MAY COLLECT FROM YOU</h4>
														We may collect and process the following data about you:
														Information. You may give us information about you, when you register to use any of our products
														or services, when you request products, services or information. The information you give us may
														include your name, e-mail address demographic information, i.e. name, surname, gender, age,
														education, occupation, country, and preference via scores to specific thematic units.</br>
														When you use our service we may automatically collect the following information:
														<ul><li>technical information, including the Internet protocol (IP) address used to connect your
																device to the Internet, your login information, browser type and version, time zone setting,
																browser plug-in types and versions, operating system and platform;</li>
															<li>where applicable, your device’s unique device identifiers, e-mail/PIM/LDAP domain names
																and passwords associated with e-mail and PIM accounts, or personal usage statistics on
																behalf of our products’ and/or services’ customers. From our side we do not correlate this
																information with personally identifiable data about individual end users of our service.</li></ul><br/>

														We will use this information:
														<ul><li>to administer our Service and for internal operations, including troubleshooting, data
																analysis, testing, research, statistical and survey purposes;</li>
															<li>to improve our Service to ensure that content is presented in the most effective manner for
																you and for your computer;</li>
															<li>to allow you to participate in interactive features of our service, when you choose to do so;</li>
															<li>as part of our efforts to keep our Service safe and secure;</li>
															<li>to measure or understand the effectiveness of advertising we serve to you and others, and
																to deliver relevant advertising to you;</li>
															<li>to make suggestions and recommendations to you and other users of our Service about
																products and services that may interest you or them.</li></ul></div>

													<div align="justify"><h4>CHILDREN & PRIVACY</h4>

														Our Properties are intended for adults. We do not knowingly collect personal information from
														children. If we learn we have collected or received personal information from a child without
														verification of parental consent, we will delete that information. If you believe we might have any
														information from or about a child, please contact us: info@mecanex.eu

														MECANEX ICT-18-2014<br/>
														Mecanex HORIZON 2020 ICT-18-645206 CONFIDENTIAL<br/>

														CONFIDENTIAL AND INTERNAL USE ONLY OF MECANEX CONSORTIUM</div>

													<div align="justify"><h4>YOUR RIGHTS</h4>

														You have the right to ask us not to process your personal data for marketing purposes. We will
														usually inform you (before collecting your data) if we intend to use your data for such purposes or if
														we intend to disclose your information to any third party for such purposes.</div>
													<div align="justify"><h4>CHANGES TO OUR PRIVACY POLICY</h4>

														We may modify or update this Privacy Policy from time to time, so please review it periodically.</div>

													<div align="justify"><h4>TERMS</h4>

														The Content is for your personal/internal non-commercial use. The Service and the Content may not
														be copied, reproduced, republished, modified, adapted, uploaded, transmitted, distributed or
														otherwise used.<br/>
														In accessing and using any part of the Service/or any Content, you agree:

														<ul><li>not to violate any applicable laws or regulations, or to solicit the performance of any illegal

																activity or other activity that infringes the rights of the Service or others;</li>

															<li>not to cause damage to the Service and/or the Content or impairment of the availability or
																accessibility of the Service and/or Content;</li>
															<li>not to violate, or attempt to violate, the security of the Services and/or Content;</li>
															<li>not to harm other persons or infringe upon their legal rights;</li>
															<li>not to misrepresent your identity or affiliation in any way;</li>
															<li>not to violate any intellectual property right or any other proprietary right;</li>
															<li>not to upload or attempt to upload files that contain viruses, worms, Trojan horses, time
																bombs or any other contaminating or destructive features;</li>
															<li>not to harvest or otherwise collect information about others, including email addresses
																Password protected areas</li></ul>
														Certain areas of the service may be password protected. You are solely responsible for maintaining
														your access credentials secure and confidential and you are solely liable for any and all activity that
														occurs under your access credentials. You agree to notify The Company immediately of any
														unauthorized use of your access credentials.</div>

													<div align="justify"><h4> Intellectual Property</h4>

														All legal rights, titles and interests in and to the service, including, without limitation, trademarks,
														service marks, design marks, patents, copyrights, database rights, and all other intellectual property
														appearing on or contained within the Service, whether registered or unregistered, are owned by us
														and our licensors. Except for the rights of use and other rights expressly granted herein, no other
														rights are granted to you, nor shall any obligation be implied requiring the grant of further rights.</div>

													<div align="justify"><h4> Third-party websites</h4>

														The Service may contain hyperlinks to web pages of third parties. These web pages are not under
														the control of us and we have no liability for their content.</div>

													<div align="justify"><h4>DISCLAIMER OF WARRANTIES</h4>

														THE SERVICE IS PROVIDED TO YOU “AS IS” AND THE ENTIRE RISK AS TO THE QUALITY AND
														PERFORMANCE OF THEM IS WITH YOU. TO THE FULLEST EXTENT PERMITTED BY APPLICABLE LAW,
														THE COMPANY EXPRESSLY DISCLAIMS ALL WARRANTIES AND REPRESENTATIONS OF ANY KIND,
														WHETHER EXPRESS, IMPLIED, STATUTORY, OR OTHER, WITH RESPECT TO THE SERVICE AND THE
														MECANEX ICT-18-2014

														Mecanex HORIZON 2020 ICT-18-645206 CONFIDENTIAL

														CONFIDENTIAL AND INTERNAL USE ONLY OF MECANEX CONSORTIUM
														CONTENT (INCLUDING, BUT NOT LIMITED TO, ANY IMPLIED OR STATUTORY WARRANTIES OF
														MERCHANTABILITY, FITNESS FOR A PARTICULAR USE OR PURPOSE, TITLE, AND NON-INFRINGEMENT
														OF INTELLECTUAL PROPERTY RIGHTS). WITHOUT LIMITING THE GENERALITY OF THE FOREGOING,
														WE MAKE NO WARRANTY THAT THE SERVICE WILL MEET YOUR EXPECTATIONS AND REQUIREMENTS
														OR THAT THEIR OPERATION WILL BE UNINTERRUPTED, TIMELY, SECURE, OR ERROR FREE OR THAT
														ANY DEFECTS WILL BE CORRECTED. THE COMPANY DOES NOT PROMISE THAT THE USE OF THE
														SERVICE WILL PROVIDE SPECIFC RESULTS. THE COMPANY DOES NOT MAKE ANY WARRANTY AS TO
														THE ACCURACY OR RELIABILITY OF ANY INFORMATION OBTAINED THROUGH THE SERVICE. YOU
														ASSUME ALL RISK AND RESPONSIBILITY FOR ANY LOSS OR DAMAGE WHATSOEVER TO YOUR SYSTEM,
														DATA AND BUSINESS ARISING OUT OF YOUR USE OF THE SERVICE. YOUR SOLE REMEDY AGAINST THE
														COMPANY FOR DISSATISFACTION WITH THE SERVICE AND/OR ANY CONTENT IS TO STOP USING THE
														SERVICE OR ANY SUCH CONTENT.

														Applicable law may not allow the exclusion of implied warranties, so the above exclusion may not

														apply to you.
														<h4>Limitation of liability</h4>

														To the fullest extent permitted by applicable law, under no circumstances shall THE COMPANY be

														liable for any direct, indirect, incidental, special, exemplary or consequential damages of any type

														whatsoever related to or arising from your access to, or use of, the Service.

														<h4>Severability</h4>

														If any provision of these shall be unlawful, void, or for any reason unenforceable, that provision
														shall be construed in a manner consistent with applicable law to reflect, as nearly as possible, the
														original intentions of the parties, and shall not affect the validity and enforceability of any remaining
														provisions.</div>

													<div align="justify"> <h4>Law and Jurisdiction</h4>

														These Terms of Use shall be governed and construed in accordance with the laws of the appropriate
														member state without giving effect to any choice or conflict of law provision or rule that would
														cause the application of laws of any jurisdiction other than those of the appropriate member state.
														You agree to submit to the personal jurisdiction of the state courts and federal courts located within
														the appropriate member state for the purpose of litigating all such claims or disputes.
														Notwithstanding the foregoing, we may seek injunctive or other equitable relief to protect our
														intellectual property rights in any court of competent jurisdiction. </div>


												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>



						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Register
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
