<?php
include './config/db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $get_user = mysql_query("SELECT username, IsComplete, IsApproved, token FROM user_table WHERE token ='$token' ");
}

$user = mysql_fetch_array($get_user);
if ($user > 0) {
    if ($user['IsApproved'] && $user['IsComplete']) {
        echo '<h2>Account already activated! <a href="http://localhost/debate-local/index.php">Click to go Home</a></h2>';
    } else {
        $approve_query = "UPDATE `user_table` 
             SET 
               `IsApproved`=1
              WHERE `token` = '$token'";

        $result = mysql_query($approve_query);
        mysql_close();
        ?>
        <!DOCTYPE html>
        <!--[if lt IE 8 ]><html class="no-js ie ie7" lang="en"> <![endif]-->
        <!--[if IE 8 ]><html class="no-js ie ie8" lang="en"> <![endif]-->
        <!--[if (gte IE 8)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
            <head>

                <!--- Basic Page Needs
                ================================================== -->
                <meta charset="utf-8">
                <title>Profile Information | Sparrow</title>
                <meta name="description" content="">
                <meta name="author" content="">

                <!-- Mobile Specific Metas
                ================================================== -->
                <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

                <!-- CSS
            ================================================== -->
                <link rel="stylesheet" href="css/default.css">
                <link rel="stylesheet" href="css/layout.css">
                <link rel="stylesheet" href="css/media-queries.css">
                
                <!-- Script
                ================================================== -->
                <script src="js/modernizr.js"></script>

                <!-- Favicons
                     ================================================== -->
                <link rel="shortcut icon" href="favicon.ico" >

            </head>

            <body>

                <!-- Header
                ================================================== -->
                <header>

                    <div class="row">

                        <div class="twelve columns">

                            <div class="logo">
                                <a href="index.html"><img alt="" src="images/logo.png"></a>
                            </div>

                            <nav id="nav-wrap">

                               

                                <ul id="nav" class="nav">

                                    

                                    <li><a href="about.html">About</a></li>
                                   

                                </ul> <!-- end #nav -->

                            </nav> <!-- end #nav-wrap -->

                        </div>

                    </div>

                </header> <!-- Header End -->


                <!-- Content
                ================================================== -->
                <div class="content-outer">

                    <div id="page-content" class="row page">

                        <div id="primary" class="eight columns">

                            <section>
                                <div id="upload-wrapper">
                                    <div align="center">
                                        <h3>Upload your profile picture</h3>
                                        <span class="">Image Type allowed: Jpeg, Jpg, Png and Gif. | Maximum Size 1 MB</span>
                                        <form action="processupload.php" onSubmit="return false" method="post" enctype="multipart/form-data" id="MyUploadForm">
                                            <input name="ImageFile" id="imageInput" type="file" />
                                            <input type="submit"  id="submit-btn" value="Upload" />
                                            <img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
                                        </form>
                                        <div id="progressbox" style="display:none;"><div id="progressbar"></div ><div id="statustxt">0%</div></div>

                                    </div>
                                </div>
                                <div id="contact-form">

                                    <!-- form -->
                                    <form id="information-form" method="post" action="forms/information-form.php">
                                        <fieldset>
                                            <div id="output"></div>
                                            <div class="half">
                                                <label for="contactName">First <span class="required">*</span></label>
                                                <input name="first" id="first" type="text"  size="35" value="" />
                                            </div>

                                            <div class="half pull-right">
                                                <label for="contactEmail">Last <span class="required">*</span></label>
                                                <input name="last" id="last" type="text" size="35" value="" />
                                            </div>

                                            <div>
                                                <label for="contactSubject">Age<span class="required">*</span></label>
                                                <input type="text" name="age" id="age" size="15"
                                                       onkeyup="if (/\D/g.test(this.value))
                                                           this.value = this.value.replace(/\D/g, '')"/>
                                            </div>

                                            <div>
                                                <label  for="contactMessage">Gender <span class="required">*</span></label>
                                                <select name="gender" value="" id="gender">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label  for="contactMessage">Country <span class="required">*</span></label>
                                                <select id="country" name="country"> 
                                                    <option value="United States">United States</option> 
                                                    <option value="United Kingdom">United Kingdom</option> 
                                                    <option value="Afghanistan">Afghanistan</option> 
                                                    <option value="Albania">Albania</option> 
                                                    <option value="Algeria">Algeria</option> 
                                                    <option value="American Samoa">American Samoa</option> 
                                                    <option value="Andorra">Andorra</option> 
                                                    <option value="Angola">Angola</option> 
                                                    <option value="Anguilla">Anguilla</option> 
                                                    <option value="Antarctica">Antarctica</option> 
                                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option> 
                                                    <option value="Argentina">Argentina</option> 
                                                    <option value="Armenia">Armenia</option> 
                                                    <option value="Aruba">Aruba</option> 
                                                    <option value="Australia">Australia</option> 
                                                    <option value="Austria">Austria</option> 
                                                    <option value="Azerbaijan">Azerbaijan</option> 
                                                    <option value="Bahamas">Bahamas</option> 
                                                    <option value="Bahrain">Bahrain</option> 
                                                    <option value="Bangladesh">Bangladesh</option> 
                                                    <option value="Barbados">Barbados</option> 
                                                    <option value="Belarus">Belarus</option> 
                                                    <option value="Belgium">Belgium</option> 
                                                    <option value="Belize">Belize</option> 
                                                    <option value="Benin">Benin</option> 
                                                    <option value="Bermuda">Bermuda</option> 
                                                    <option value="Bhutan">Bhutan</option> 
                                                    <option value="Bolivia">Bolivia</option> 
                                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> 
                                                    <option value="Botswana">Botswana</option> 
                                                    <option value="Bouvet Island">Bouvet Island</option> 
                                                    <option value="Brazil">Brazil</option> 
                                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option> 
                                                    <option value="Brunei Darussalam">Brunei Darussalam</option> 
                                                    <option value="Bulgaria">Bulgaria</option> 
                                                    <option value="Burkina Faso">Burkina Faso</option> 
                                                    <option value="Burundi">Burundi</option> 
                                                    <option value="Cambodia">Cambodia</option> 
                                                    <option value="Cameroon">Cameroon</option> 
                                                    <option value="Canada">Canada</option> 
                                                    <option value="Cape Verde">Cape Verde</option> 
                                                    <option value="Cayman Islands">Cayman Islands</option> 
                                                    <option value="Central African Republic">Central African Republic</option> 
                                                    <option value="Chad">Chad</option> 
                                                    <option value="Chile">Chile</option> 
                                                    <option value="China">China</option> 
                                                    <option value="Christmas Island">Christmas Island</option> 
                                                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> 
                                                    <option value="Colombia">Colombia</option> 
                                                    <option value="Comoros">Comoros</option> 
                                                    <option value="Congo">Congo</option> 
                                                    <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> 
                                                    <option value="Cook Islands">Cook Islands</option> 
                                                    <option value="Costa Rica">Costa Rica</option> 
                                                    <option value="Cote D'ivoire">Cote D'ivoire</option> 
                                                    <option value="Croatia">Croatia</option> 
                                                    <option value="Cuba">Cuba</option> 
                                                    <option value="Cyprus">Cyprus</option> 
                                                    <option value="Czech Republic">Czech Republic</option> 
                                                    <option value="Denmark">Denmark</option> 
                                                    <option value="Djibouti">Djibouti</option> 
                                                    <option value="Dominica">Dominica</option> 
                                                    <option value="Dominican Republic">Dominican Republic</option> 
                                                    <option value="Ecuador">Ecuador</option> 
                                                    <option value="Egypt">Egypt</option> 
                                                    <option value="El Salvador">El Salvador</option> 
                                                    <option value="Equatorial Guinea">Equatorial Guinea</option> 
                                                    <option value="Eritrea">Eritrea</option> 
                                                    <option value="Estonia">Estonia</option> 
                                                    <option value="Ethiopia">Ethiopia</option> 
                                                    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> 
                                                    <option value="Faroe Islands">Faroe Islands</option> 
                                                    <option value="Fiji">Fiji</option> 
                                                    <option value="Finland">Finland</option> 
                                                    <option value="France">France</option> 
                                                    <option value="French Guiana">French Guiana</option> 
                                                    <option value="French Polynesia">French Polynesia</option> 
                                                    <option value="French Southern Territories">French Southern Territories</option> 
                                                    <option value="Gabon">Gabon</option> 
                                                    <option value="Gambia">Gambia</option> 
                                                    <option value="Georgia">Georgia</option> 
                                                    <option value="Germany">Germany</option> 
                                                    <option value="Ghana">Ghana</option> 
                                                    <option value="Gibraltar">Gibraltar</option> 
                                                    <option value="Greece">Greece</option> 
                                                    <option value="Greenland">Greenland</option> 
                                                    <option value="Grenada">Grenada</option> 
                                                    <option value="Guadeloupe">Guadeloupe</option> 
                                                    <option value="Guam">Guam</option> 
                                                    <option value="Guatemala">Guatemala</option> 
                                                    <option value="Guinea">Guinea</option> 
                                                    <option value="Guinea-bissau">Guinea-bissau</option> 
                                                    <option value="Guyana">Guyana</option> 
                                                    <option value="Haiti">Haiti</option> 
                                                    <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> 
                                                    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> 
                                                    <option value="Honduras">Honduras</option> 
                                                    <option value="Hong Kong">Hong Kong</option> 
                                                    <option value="Hungary">Hungary</option> 
                                                    <option value="Iceland">Iceland</option> 
                                                    <option value="India">India</option> 
                                                    <option value="Indonesia">Indonesia</option> 
                                                    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option> 
                                                    <option value="Iraq">Iraq</option> 
                                                    <option value="Ireland">Ireland</option> 
                                                    <option value="Israel">Israel</option> 
                                                    <option value="Italy">Italy</option> 
                                                    <option value="Jamaica">Jamaica</option> 
                                                    <option value="Japan">Japan</option> 
                                                    <option value="Jordan">Jordan</option> 
                                                    <option value="Kazakhstan">Kazakhstan</option> 
                                                    <option value="Kenya">Kenya</option> 
                                                    <option value="Kiribati">Kiribati</option> 
                                                    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option> 
                                                    <option value="Korea, Republic of">Korea, Republic of</option> 
                                                    <option value="Kuwait">Kuwait</option> 
                                                    <option value="Kyrgyzstan">Kyrgyzstan</option> 
                                                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option> 
                                                    <option value="Latvia">Latvia</option> 
                                                    <option value="Lebanon">Lebanon</option> 
                                                    <option value="Lesotho">Lesotho</option> 
                                                    <option value="Liberia">Liberia</option> 
                                                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> 
                                                    <option value="Liechtenstein">Liechtenstein</option> 
                                                    <option value="Lithuania">Lithuania</option> 
                                                    <option value="Luxembourg">Luxembourg</option> 
                                                    <option value="Macao">Macao</option> 
                                                    <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option> 
                                                    <option value="Madagascar">Madagascar</option> 
                                                    <option value="Malawi">Malawi</option> 
                                                    <option value="Malaysia">Malaysia</option> 
                                                    <option value="Maldives">Maldives</option> 
                                                    <option value="Mali">Mali</option> 
                                                    <option value="Malta">Malta</option> 
                                                    <option value="Marshall Islands">Marshall Islands</option> 
                                                    <option value="Martinique">Martinique</option> 
                                                    <option value="Mauritania">Mauritania</option> 
                                                    <option value="Mauritius">Mauritius</option> 
                                                    <option value="Mayotte">Mayotte</option> 
                                                    <option value="Mexico">Mexico</option> 
                                                    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option> 
                                                    <option value="Moldova, Republic of">Moldova, Republic of</option> 
                                                    <option value="Monaco">Monaco</option> 
                                                    <option value="Mongolia">Mongolia</option> 
                                                    <option value="Montserrat">Montserrat</option> 
                                                    <option value="Morocco">Morocco</option> 
                                                    <option value="Mozambique">Mozambique</option> 
                                                    <option value="Myanmar">Myanmar</option> 
                                                    <option value="Namibia">Namibia</option> 
                                                    <option value="Nauru">Nauru</option> 
                                                    <option value="Nepal">Nepal</option> 
                                                    <option value="Netherlands">Netherlands</option> 
                                                    <option value="Netherlands Antilles">Netherlands Antilles</option> 
                                                    <option value="New Caledonia">New Caledonia</option> 
                                                    <option value="New Zealand">New Zealand</option> 
                                                    <option value="Nicaragua">Nicaragua</option> 
                                                    <option value="Niger">Niger</option> 
                                                    <option value="Nigeria">Nigeria</option> 
                                                    <option value="Niue">Niue</option> 
                                                    <option value="Norfolk Island">Norfolk Island</option> 
                                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option> 
                                                    <option value="Norway">Norway</option> 
                                                    <option value="Oman">Oman</option> 
                                                    <option value="Pakistan">Pakistan</option> 
                                                    <option value="Palau">Palau</option> 
                                                    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> 
                                                    <option value="Panama">Panama</option> 
                                                    <option value="Papua New Guinea">Papua New Guinea</option> 
                                                    <option value="Paraguay">Paraguay</option> 
                                                    <option value="Peru">Peru</option> 
                                                    <option value="Philippines">Philippines</option> 
                                                    <option value="Pitcairn">Pitcairn</option> 
                                                    <option value="Poland">Poland</option> 
                                                    <option value="Portugal">Portugal</option> 
                                                    <option value="Puerto Rico">Puerto Rico</option> 
                                                    <option value="Qatar">Qatar</option> 
                                                    <option value="Reunion">Reunion</option> 
                                                    <option value="Romania">Romania</option> 
                                                    <option value="Russian Federation">Russian Federation</option> 
                                                    <option value="Rwanda">Rwanda</option> 
                                                    <option value="Saint Helena">Saint Helena</option> 
                                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
                                                    <option value="Saint Lucia">Saint Lucia</option> 
                                                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> 
                                                    <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> 
                                                    <option value="Samoa">Samoa</option> 
                                                    <option value="San Marino">San Marino</option> 
                                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option> 
                                                    <option value="Saudi Arabia">Saudi Arabia</option> 
                                                    <option value="Senegal">Senegal</option> 
                                                    <option value="Serbia and Montenegro">Serbia and Montenegro</option> 
                                                    <option value="Seychelles">Seychelles</option> 
                                                    <option value="Sierra Leone">Sierra Leone</option> 
                                                    <option value="Singapore">Singapore</option> 
                                                    <option value="Slovakia">Slovakia</option> 
                                                    <option value="Slovenia">Slovenia</option> 
                                                    <option value="Solomon Islands">Solomon Islands</option> 
                                                    <option value="Somalia">Somalia</option> 
                                                    <option value="South Africa">South Africa</option> 
                                                    <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option> 
                                                    <option value="Spain">Spain</option> 
                                                    <option value="Sri Lanka">Sri Lanka</option> 
                                                    <option value="Sudan">Sudan</option> 
                                                    <option value="Suriname">Suriname</option> 
                                                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> 
                                                    <option value="Swaziland">Swaziland</option> 
                                                    <option value="Sweden">Sweden</option> 
                                                    <option value="Switzerland">Switzerland</option> 
                                                    <option value="Syrian Arab Republic">Syrian Arab Republic</option> 
                                                    <option value="Taiwan, Province of China">Taiwan, Province of China</option> 
                                                    <option value="Tajikistan">Tajikistan</option> 
                                                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option> 
                                                    <option value="Thailand">Thailand</option> 
                                                    <option value="Timor-leste">Timor-leste</option> 
                                                    <option value="Togo">Togo</option> 
                                                    <option value="Tokelau">Tokelau</option> 
                                                    <option value="Tonga">Tonga</option> 
                                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option> 
                                                    <option value="Tunisia">Tunisia</option> 
                                                    <option value="Turkey">Turkey</option> 
                                                    <option value="Turkmenistan">Turkmenistan</option> 
                                                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option> 
                                                    <option value="Tuvalu">Tuvalu</option> 
                                                    <option value="Uganda">Uganda</option> 
                                                    <option value="Ukraine">Ukraine</option> 
                                                    <option value="United Arab Emirates">United Arab Emirates</option> 
                                                    <option value="United Kingdom">United Kingdom</option> 
                                                    <option value="United States">United States</option> 
                                                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> 
                                                    <option value="Uruguay">Uruguay</option> 
                                                    <option value="Uzbekistan">Uzbekistan</option> 
                                                    <option value="Vanuatu">Vanuatu</option> 
                                                    <option value="Venezuela">Venezuela</option> 
                                                    <option value="Viet Nam">Viet Nam</option> 
                                                    <option value="Virgin Islands, British">Virgin Islands, British</option> 
                                                    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> 
                                                    <option value="Wallis and Futuna">Wallis and Futuna</option> 
                                                    <option value="Western Sahara">Western Sahara</option> 
                                                    <option value="Yemen">Yemen</option> 
                                                    <option value="Zambia">Zambia</option> 
                                                    <option value="Zimbabwe">Zimbabwe</option>
                                                </select>

                                            </div>
                                            <div>
                                                <label  for="contactMessage">Work</label>
                                                <input type="text" name="work"  id="work" size="15" value="" />
                                            </div>
                                            <div>
                                                <label  for="contactMessage">Education</label>
                                                <input type="text" name="education"  id="education" size="15" value="" />
                                            </div>

                                            <div>
                                                <label  for="contactMessage">Biography</label>
                                                <textarea name="biography"  value="" id="biography" rows="5" cols="50" ></textarea>
                                            </div>
                                            <input type="hidden" name="token"  id="token" size="15" value="<?php echo $token ?>" />
                                            <div>
                                                <button type="button" id="info-button">Submit</button>
                                                <span id="image-loader">
                                                    <img src="images/loader.gif" alt="" />
                                                </span>
                                            </div>

                                        </fieldset>
                                    </form> <!-- Form End -->

                                    <!-- contact-warning -->
                                    <div id="message-warning"></div>
                                    <!-- contact-success -->
                                    <div id="message-success">
                                        <i class="icon-ok"></i>Your message was sent, thank you!<br />
                                    </div>

                                </div>

                            </section> <!-- section end -->

                        </div>

                        <div id="secondary" class="four columns end">

                        </div>

                    </div>

                </div> <!-- Content End-->


                <!-- footer
                ================================================== -->
                 <footer id="footer">

            <div class="row">

                <div class="twelve columns">

                   
                    <ul class="footer-social">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-skype"></i></a></li>
                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                    </ul>

                    <ul class="copyright">
                        <!--<li>&copy; 2014 Sparrow</li> -->
                        <li>Copyrights @2014 <a href="#">Debate.</a></li>
                        <li><a rel="nofollow" href="#">Joseph El Khoury </a> And <a rel="nofollow" href="#">Mohamed Atie </a> </li>
                    </ul>

                </div>

                <div id="go-top" style="display: block;"><a title="Back to Top" href="#">Go To Top</a></div>

            </div>

        </footer> <!-- Footer End-->

                <!-- Java Script
                ================================================== -->
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
                <script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
                <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
                <script type="text/javascript" src="js/jquery.form.min.js"></script>
                <script src="js/jquery.flexslider.js"></script>
                <script src="js/doubletaptogo.js"></script>
                <script src="js/init.js"></script>

            </body>
            <script>
                $(document).ready(function() {
                    $('#info-button').click(function() {
                        var first = $.trim($('#first').val());
                        var last = $.trim($('#last').val());
                        var age = $.trim($('#age').val());
                        var country = $.trim($('#country').val());
                        if (first.length < 1 || first === "" || last.length < 1 || last === ""
                            || age.length < 1 || age === "") {
                            $('#warn').css('color', 'red');
                            window.scrollTo(0, 0);
                            //WARN USER
                        } else {
                            $('#information-form').submit();
                        }
                    });
                                          
                    var progressbox = $('#progressbox');
                    var progressbar = $('#progressbar');
                    var statustxt = $('#statustxt');
                    var completed = '0%';

                    var options = {
                        target: '#output', // target element(s) to be updated with server response 
                        beforeSubmit: beforeSubmit, // pre-submit callback 
                        uploadProgress: OnProgress,
                        success: afterSuccess, // post-submit callback 
                        resetForm: true        // reset the form after successful submit 
                    };

                    $('#MyUploadForm').submit(function() {
                        $(this).ajaxSubmit(options);
                        // return false to prevent standard browser submit and page navigation 
                        return false;
                    });

                    //when upload progresses	
                    function OnProgress(event, position, total, percentComplete)
                    {
                        //Progress bar
                        progressbar.width(percentComplete + '%') //update progressbar percent complete
                        statustxt.html(percentComplete + '%'); //update status text
                        if (percentComplete > 50)
                        {
                            statustxt.css('color', '#fff'); //change status text to white after 50%
                        }
                    }

                    //after succesful upload
                    function afterSuccess()
                    {
                                                                               
                        $('#submit-btn').show(); //hide submit button
                        $('#loading-img').hide(); //hide submit button

                    }

                    //function to check file size before uploading.
                    function beforeSubmit() {
                        //check whether browser fully supports all File API
                        if (window.File && window.FileReader && window.FileList && window.Blob)
                        {

                            if (!$('#imageInput').val()) //check empty input filed
                            {
                                $("#output").html("Are you kidding me?");
                                return false;
                            }

                            var fsize = $('#imageInput')[0].files[0].size; //get file size
                            var ftype = $('#imageInput')[0].files[0].type; // get file type

                            //allow only valid image file types 
                            switch (ftype)
                            {
                                case 'image/png':
                                case 'image/gif':
                                case 'image/jpeg':
                                case 'image/pjpeg':
                                    break;
                                default:
                                    $("#output").html("<b>" + ftype + "</b> Unsupported file type!");
                                    return false;
                            }

                            //Allowed file size is less than 1 MB (1048576)
                            if (fsize > 1048576)
                            {
                                $("#output").html("<b>" + bytesToSize(fsize) + "</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                                return false;
                            }

                            //Progress bar
                            progressbox.show(); //show progressbar
                            progressbar.width(completed); //initial value 0% of progressbar
                            statustxt.html(completed); //set status text
                            statustxt.css('color', '#000'); //initial color of status text


                            $('#submit-btn').hide(); //hide submit button
                            $('#loading-img').show(); //hide submit button
                            $("#output").html("");
                        }
                        else
                        {
                            //Output error to older unsupported browsers that doesn't support HTML5 File API
                            $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
                            return false;
                        }
                    }

                    //function to format bites bit.ly/19yoIPO
                    function bytesToSize(bytes) {
                        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                        if (bytes == 0)
                            return '0 Bytes';
                        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
                    }

                });

            </script>
        </html>
        <?php
    }
} else {
    echo '<h2>Invalid URL <a href="http://localhost/debate-local/index.php">Click to go Home</a></h2>';
}
?>