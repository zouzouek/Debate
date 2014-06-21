<?php
session_start();
include './config/db.php';

$id = $_SESSION['id'];
$get_user = mysql_query("SELECT * FROM info_table WHERE uid='$id'");
$user = mysql_fetch_array($get_user);

//  if ($user['IsApproved'] && $user['IsComplete']
?>
<head>

    <!--- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <title>Edit Information | Sparrow</title>
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
    <link rel="stylesheet" href="css/homepage.css">
    
    <!-- Script
    ================================================== -->
    <script src="js/modernizr.js"></script>

    <!-- Favicons
         ================================================== -->
    <link rel="shortcut icon" href="favicon.ico" >

</head>

<body >


    <header>

        <div class="row">

            <div class="twelve columns">

                <div class="logo">
                    <a href="home.php"><img src="images/logo.png"/></a>
                    <a id="readlater"  title="Show marked tags" href="#"><img id="readimg" src="images/book.png"/></a>
                    <a id="notify" href="#"><img id="notifyimg" src="images/whitealert.png"/></a>
                    <a id="search" href="#" title="Search"><img id="searchimg" src="images/search-2.png"/></a>
                </div>
                <div id="searchdiv" style="display: none">
                    <h6>Search Users and Tags</h6>
                    <input type="text" id="searchbar"/>
                    <span>Press enter or click search</span>
                    <h6 id="entersearch"><a href="#">Search</a></h6>
                </div>
                <nav id="nav-wrap">

                    <a class="mobile-btn" href="#nav-wrap" title="Show navigation">Show navigation</a>
                    <a class="mobile-btn" href="#" title="Hide navigation">Hide navigation</a>

                    <ul id="nav" class="nav">

                        <li><a href="home.php">Feed</a></li>
                        <li><a id="act" href="#">Activity</a></li>
                        <li><a id="profile" href="#">Profile</a></li>
                        <li><a href="logout.php">Log Out</a></li>

                    </ul> <!-- end #nav -->

                </nav> <!-- end #nav-wrap -->

            </div>

        </div>

    </header> <!-- Header End -->


    <!-- Content
                   ================================================== -->
    <div class="content-outer">

        <div id="page-content" class="row page">

            <div id="primary" class="twelve columns">

                <section>
                    <div id="upload-wrapper">
                        <div align="center">
                            <h3>Edit Your Profile</h3>
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
                        <form id="information-form" method="post" action="forms/edit-profile.php">
                            <fieldset>
                                <div id="output">
                                    <img src="<?php
                                    if ($user['profilepic'] != '') {
                                        echo $user['profilepic'];
                                    } else {
                                        echo 'images/user-03.png';
                                    }
                                    ?>" class="profile-pic">
                                </div>
                                <div class="half">
                                    <label for="contactName">First</label>
                                    <input placeholder="<?php echo $user['firstname']; ?>" name="first" id="first" type="text"  size="35" value="" />
                                </div>

                                <div class="half pull-right">
                                    <label for="contactEmail">Last</label>
                                    <input placeholder="<?php echo $user['lastname']; ?>" name="last" id="last" type="text" size="35" value="" />
                                </div>

                                <div>
                                    <label for="contactSubject">Age</label>
                                    <input placeholder="<?php echo $user['age']; ?>" type="text" name="age" id="age" size="15"
                                           onkeyup="if (/\D/g.test(this.value))
                                                       this.value = this.value.replace(/\D/g, '')"/>
                                </div>

                                <div>
                                    <label  for="contactMessage">Gender</label>
                                    <select name="gender" id="gender" >
                                        <option value="" <?php if ($user['gender'] == "") echo 'selected="selected"'; ?>></option>
                                        <option value="Male" <?php if ($user['gender'] == "Male") echo 'selected="selected"'; ?>>Male</option>
                                        <option value="Female" <?php if ($user['gender'] == "Female") echo 'selected="selected"'; ?>>Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label  for="contactMessage">Country</label>
                                    <select id="country" name="country" > 
                                        <option value="" <?php if ($user['location'] == "") echo 'selected="selected"'; ?>></option>
                                        <option value="United States" <?php if ($user['location'] == "United States") echo 'selected="selected"'; ?>>United States</option> 
                                        <option value="United Kingdom" <?php if ($user['location'] == "United Kingdom") echo 'selected="selected"'; ?>>United Kingdom</option> 
                                        <option value="Afghanistan" <?php if ($user['location'] == "Afghanistan") echo 'selected="selected"'; ?>>Afghanistan</option> 
                                        <option value="Albania" <?php if ($user['location'] == "Albania") echo 'selected="selected"'; ?>>Albania</option> 
                                        <option value="Algeria" <?php if ($user['location'] == "Algeria") echo 'selected="selected"'; ?>>Algeria</option> 
                                        <option value="American Samoa" <?php if ($user['location'] == "American Samoa") echo 'selected="selected"'; ?>>American Samoa</option> 
                                        <option value="Andorra" <?php if ($user['location'] == "Andorra") echo 'selected="selected"'; ?>>Andorra</option> 
                                        <option value="Angola" <?php if ($user['location'] == "Angola") echo 'selected="selected"'; ?>>Angola</option> 
                                        <option value="Anguilla" <?php if ($user['location'] == "Anguilla") echo 'selected="selected"'; ?>>Anguilla</option> 
                                        <option value="Antarctica" <?php if ($user['location'] == "Antarctica") echo 'selected="selected"'; ?>>Antarctica</option> 
                                        <option value="Antigua and Barbuda" <?php if ($user['location'] == "Antigua and Barbuda") echo 'selected="selected"'; ?>>Antigua and Barbuda</option> 
                                        <option value="Argentina" <?php if ($user['location'] == "Argentina") echo 'selected="selected"'; ?>>Argentina</option> 
                                        <option value="Armenia" <?php if ($user['location'] == "Armenia") echo 'selected="selected"'; ?>>Armenia</option> 
                                        <option value="Aruba" <?php if ($user['location'] == "Aruba") echo 'selected="selected"'; ?>>Aruba</option> 
                                        <option value="Australia" <?php if ($user['location'] == "Australia") echo 'selected="selected"'; ?>>Australia</option> 
                                        <option value="Austria" <?php if ($user['location'] == "Austria") echo 'selected="selected"'; ?>>Austria</option> 
                                        <option value="Azerbaijan" <?php if ($user['location'] == "Azerbaijan") echo 'selected="selected"'; ?>>Azerbaijan</option> 
                                        <option value="Bahamas" <?php if ($user['location'] == "Bahamas") echo 'selected="selected"'; ?>>Bahamas</option> 
                                        <option value="Bahrain" <?php if ($user['location'] == "Bahrain") echo 'selected="selected"'; ?>>Bahrain</option> 
                                        <option value="Bangladesh" <?php if ($user['location'] == "Bangladesh") echo 'selected="selected"'; ?>>Bangladesh</option> 
                                        <option value="Barbados" <?php if ($user['location'] == "Barbados") echo 'selected="selected"'; ?>>Barbados</option> 
                                        <option value="Belarus" <?php if ($user['location'] == "Belarus") echo 'selected="selected"'; ?>>Belarus</option> 
                                        <option value="Belgium" <?php if ($user['location'] == "Belgium") echo 'selected="selected"'; ?>>Belgium</option> 
                                        <option value="Belize" <?php if ($user['location'] == "Belize") echo 'selected="selected"'; ?>>Belize</option> 
                                        <option value="Benin" <?php if ($user['location'] == "Benin") echo 'selected="selected"'; ?>>Benin</option> 
                                        <option value="Bermuda" <?php if ($user['location'] == "Bermuda") echo 'selected="selected"'; ?>>Bermuda</option> 
                                        <option value="Bhutan" <?php if ($user['location'] == "Bhutan") echo 'selected="selected"'; ?>>Bhutan</option> 
                                        <option value="Bolivia" <?php if ($user['location'] == "Bolivia") echo 'selected="selected"'; ?>>Bolivia</option> 
                                        <option value="Bosnia and Herzegovina" <?php if ($user['location'] == "Bosnia and Herzegovina") echo 'selected="selected"'; ?>>Bosnia and Herzegovina</option> 
                                        <option value="Botswana" <?php if ($user['location'] == "Botswana") echo 'selected="selected"'; ?>>Botswana</option> 
                                        <option value="Bouvet Island" <?php if ($user['location'] == "Bouvet Island") echo 'selected="selected"'; ?>>Bouvet Island</option> 
                                        <option value="Brazil" <?php if ($user['location'] == "Brazil") echo 'selected="selected"'; ?>>Brazil</option> 
                                        <option value="British Indian Ocean Territory" <?php if ($user['location'] == "British Indian Ocean Territory") echo 'selected="selected"'; ?>>British Indian Ocean Territory</option> 
                                        <option value="Brunei Darussalam" <?php if ($user['location'] == "Brunei Darussalam") echo 'selected="selected"'; ?>>Brunei Darussalam</option> 
                                        <option value="Bulgaria" <?php if ($user['location'] == "Bulgaria") echo 'selected="selected"'; ?>>Bulgaria</option> 
                                        <option value="Burkina Faso" <?php if ($user['location'] == "Burkina Faso") echo 'selected="selected"'; ?>>Burkina Faso</option> 
                                        <option value="Burundi" <?php if ($user['location'] == "Burundi") echo 'selected="selected"'; ?>>Burundi</option> 
                                        <option value="Cambodia" <?php if ($user['location'] == "Cambodia") echo 'selected="selected"'; ?>>Cambodia</option> 
                                        <option value="Cameroon" <?php if ($user['location'] == "Cameroon") echo 'selected="selected"'; ?>>Cameroon</option> 
                                        <option value="Canada" <?php if ($user['location'] == "Canada") echo 'selected="selected"'; ?>>Canada</option> 
                                        <option value="Cape Verde" <?php if ($user['location'] == "Cape Verde") echo 'selected="selected"'; ?>>Cape Verde</option> 
                                        <option value="Cayman Islands" <?php if ($user['location'] == "Cayman Islands") echo 'selected="selected"'; ?>>Cayman Islands</option> 
                                        <option value="Central African Republic" <?php if ($user['location'] == "Central African Republic") echo 'selected="selected"'; ?>>Central African Republic</option> 
                                        <option value="Chad" <?php if ($user['location'] == "Chad") echo 'selected="selected"'; ?>>Chad</option> 
                                        <option value="Chile" <?php if ($user['location'] == "Chile") echo 'selected="selected"'; ?>>Chile</option> 
                                        <option value="China" <?php if ($user['location'] == "China") echo 'selected="selected"'; ?>>China</option> 
                                        <option value="Christmas Island" <?php if ($user['location'] == "Christmas Island") echo 'selected="selected"'; ?>>Christmas Island</option> 
                                        <option value="Cocos (Keeling) Islands" <?php if ($user['location'] == "Cocos (Keeling) Islands") echo 'selected="selected"'; ?>>Cocos (Keeling) Islands</option> 
                                        <option value="Colombia" <?php if ($user['location'] == "Colombia") echo 'selected="selected"'; ?>>Colombia</option> 
                                        <option value="Comoros" <?php if ($user['location'] == "Comoros") echo 'selected="selected"'; ?>>Comoros</option> 
                                        <option value="Congo" <?php if ($user['location'] == "Congo") echo 'selected="selected"'; ?>>Congo</option> 
                                        <option value="Congo, The Democratic Republic of The" <?php if ($user['location'] == "Congo, The Democratic Republic of The") echo 'selected="selected"'; ?>>Congo, The Democratic Republic of The</option> 
                                        <option value="Cook Islands" <?php if ($user['location'] == "Cook Islands") echo 'selected="selected"'; ?>>Cook Islands</option> 
                                        <option value="Costa Rica" <?php if ($user['location'] == "Costa Rica") echo 'selected="selected"'; ?>>Costa Rica</option> 
                                        <option value="Cote D'ivoire" <?php if ($user['location'] == "Cote D'ivoire") echo 'selected="selected"'; ?>>Cote D'ivoire</option> 
                                        <option value="Croatia" <?php if ($user['location'] == "Croatia") echo 'selected="selected"'; ?>>Croatia</option> 
                                        <option value="Cuba" <?php if ($user['location'] == "Cuba") echo 'selected="selected"'; ?>>Cuba</option> 
                                        <option value="Cyprus" <?php if ($user['location'] == "Cyprus") echo 'selected="selected"'; ?>>Cyprus</option> 
                                        <option value="Czech Republic" <?php if ($user['location'] == "Czech Republic") echo 'selected="selected"'; ?>>Czech Republic</option> 
                                        <option value="Denmark" <?php if ($user['location'] == "Denmark") echo 'selected="selected"'; ?>>Denmark</option> 
                                        <option value="Djibouti" <?php if ($user['location'] == "Djibouti") echo 'selected="selected"'; ?>>Djibouti</option> 
                                        <option value="Dominica" <?php if ($user['location'] == "Dominica") echo 'selected="selected"'; ?>>Dominica</option> 
                                        <option value="Dominican Republic" <?php if ($user['location'] == "Dominican Republic") echo 'selected="selected"'; ?>>Dominican Republic</option> 
                                        <option value="Ecuador" <?php if ($user['location'] == "Ecuador") echo 'selected="selected"'; ?>>Ecuador</option> 
                                        <option value="Egypt" <?php if ($user['location'] == "Egypt") echo 'selected="selected"'; ?>>Egypt</option> 
                                        <option value="El Salvador" <?php if ($user['location'] == "El Salvador") echo 'selected="selected"'; ?>>El Salvador</option> 
                                        <option value="Equatorial Guinea" <?php if ($user['location'] == "Equatorial Guinea") echo 'selected="selected"'; ?>>Equatorial Guinea</option> 
                                        <option value="Eritrea" <?php if ($user['location'] == "Eritrea") echo 'selected="selected"'; ?>>Eritrea</option> 
                                        <option value="Estonia" <?php if ($user['location'] == "Estonia") echo 'selected="selected"'; ?>>Estonia</option> 
                                        <option value="Ethiopia" <?php if ($user['location'] == "Ethiopia") echo 'selected="selected"'; ?>>Ethiopia</option> 
                                        <option value="Falkland Islands (Malvinas)" <?php if ($user['location'] == "Falkland Islands (Malvinas)") echo 'selected="selected"'; ?>>Falkland Islands (Malvinas)</option> 
                                        <option value="Faroe Islands" <?php if ($user['location'] == "Faroe Islands") echo 'selected="selected"'; ?>>Faroe Islands</option> 
                                        <option value="Fiji" <?php if ($user['location'] == "Fiji") echo 'selected="selected"'; ?>>Fiji</option> 
                                        <option value="Finland" <?php if ($user['location'] == "Finland") echo 'selected="selected"'; ?>>Finland</option> 
                                        <option value="France" <?php if ($user['location'] == "France") echo 'selected="selected"'; ?>>France</option> 
                                        <option value="French Guiana" <?php if ($user['location'] == "French Guiana") echo 'selected="selected"'; ?>>French Guiana</option> 
                                        <option value="French Polynesia" <?php if ($user['location'] == "French Polynesia") echo 'selected="selected"'; ?>>French Polynesia</option> 
                                        <option value="French Southern Territories" <?php if ($user['location'] == "French Southern Territories") echo 'selected="selected"'; ?>>French Southern Territories</option> 
                                        <option value="Gabon" <?php if ($user['location'] == "Gabon") echo 'selected="selected"'; ?>>Gabon</option> 
                                        <option value="Gambia" <?php if ($user['location'] == "Gambia") echo 'selected="selected"'; ?>>Gambia</option> 
                                        <option value="Georgia" <?php if ($user['location'] == "Georgia") echo 'selected="selected"'; ?>>Georgia</option> 
                                        <option value="Germany" <?php if ($user['location'] == "Germany") echo 'selected="selected"'; ?>>Germany</option> 
                                        <option value="Ghana" <?php if ($user['location'] == "Ghana") echo 'selected="selected"'; ?>>Ghana</option> 
                                        <option value="Gibraltar" <?php if ($user['location'] == "Gibraltar") echo 'selected="selected"'; ?>>Gibraltar</option> 
                                        <option value="Greece" <?php if ($user['location'] == "Greece") echo 'selected="selected"'; ?>>Greece</option> 
                                        <option value="Greenland" <?php if ($user['location'] == "Greenland") echo 'selected="selected"'; ?>>Greenland</option> 
                                        <option value="Grenada" <?php if ($user['location'] == "Grenada") echo 'selected="selected"'; ?>>Grenada</option> 
                                        <option value="Guadeloupe" <?php if ($user['location'] == "Guadeloupe") echo 'selected="selected"'; ?>>Guadeloupe</option> 
                                        <option value="Guam" <?php if ($user['location'] == "Guam") echo 'selected="selected"'; ?>>Guam</option> 
                                        <option value="Guatemala" <?php if ($user['location'] == "Guatemala") echo 'selected="selected"'; ?>>Guatemala</option> 
                                        <option value="Guinea" <?php if ($user['location'] == "Guinea") echo 'selected="selected"'; ?>>Guinea</option> 
                                        <option value="Guinea-bissau" <?php if ($user['location'] == "Guinea-bissau") echo 'selected="selected"'; ?>>Guinea-bissau</option> 
                                        <option value="Guyana" <?php if ($user['location'] == "Guyana") echo 'selected="selected"'; ?>>Guyana</option> 
                                        <option value="Haiti" <?php if ($user['location'] == "Haiti") echo 'selected="selected"'; ?>>Haiti</option> 
                                        <option value="Heard Island and Mcdonald Islands" <?php if ($user['location'] == "Heard Island and Mcdonald Islands") echo 'selected="selected"'; ?>>Heard Island and Mcdonald Islands</option> 
                                        <option value="Holy See (Vatican City State)" <?php if ($user['location'] == "Holy See (Vatican City State)") echo 'selected="selected"'; ?>>Holy See (Vatican City State)</option> 
                                        <option value="Honduras" <?php if ($user['location'] == "Honduras") echo 'selected="selected"'; ?>>Honduras</option> 
                                        <option value="Hong Kong" <?php if ($user['location'] == "Hong Kong") echo 'selected="selected"'; ?>>Hong Kong</option> 
                                        <option value="Hungary" <?php if ($user['location'] == "Hungary") echo 'selected="selected"'; ?>>Hungary</option> 
                                        <option value="Iceland" <?php if ($user['location'] == "Iceland") echo 'selected="selected"'; ?>>Iceland</option> 
                                        <option value="India" <?php if ($user['location'] == "India") echo 'selected="selected"'; ?>>India</option> 
                                        <option value="Indonesia" <?php if ($user['location'] == "Indonesia") echo 'selected="selected"'; ?>>Indonesia</option> 
                                        <option value="Iran, Islamic Republic of" <?php if ($user['location'] == "Iran, Islamic Republic of") echo 'selected="selected"'; ?>>Iran, Islamic Republic of</option> 
                                        <option value="Iraq" <?php if ($user['location'] == "Iraq") echo 'selected="selected"'; ?>>Iraq</option> 
                                        <option value="Ireland" <?php if ($user['location'] == "Ireland") echo 'selected="selected"'; ?>>Ireland</option> 
                                        <option value="Israel" <?php if ($user['location'] == "Israel") echo 'selected="selected"'; ?>>Israel</option> 
                                        <option value="Italy" <?php if ($user['location'] == "Italy") echo 'selected="selected"'; ?>>Italy</option> 
                                        <option value="Jamaica" <?php if ($user['location'] == "Jamaica") echo 'selected="selected"'; ?>>Jamaica</option> 
                                        <option value="Japan" <?php if ($user['location'] == "Japan") echo 'selected="selected"'; ?>>Japan</option> 
                                        <option value="Jordan" <?php if ($user['location'] == "Jordan") echo 'selected="selected"'; ?>>Jordan</option> 
                                        <option value="Kazakhstan" <?php if ($user['location'] == "Kazakhstan") echo 'selected="selected"'; ?>>Kazakhstan</option> 
                                        <option value="Kenya" <?php if ($user['location'] == "Kenya") echo 'selected="selected"'; ?>>Kenya</option> 
                                        <option value="Kiribati" <?php if ($user['location'] == "Kiribati") echo 'selected="selected"'; ?>>Kiribati</option> 
                                        <option value="Korea, Democratic People's Republic of" <?php if ($user['location'] == "Korea, Democratic People's Republic of") echo 'selected="selected"'; ?>>Korea, Democratic People's Republic of</option> 
                                        <option value="Korea, Republic of" <?php if ($user['location'] == "Korea, Republic of") echo 'selected="selected"'; ?>>Korea, Republic of</option> 
                                        <option value="Kuwait" <?php if ($user['location'] == "Kuwait") echo 'selected="selected"'; ?>>Kuwait</option> 
                                        <option value="Kyrgyzstan" <?php if ($user['location'] == "Kyrgyzstan") echo 'selected="selected"'; ?>>Kyrgyzstan</option> 
                                        <option value="Lao People's Democratic Republic" <?php if ($user['location'] == "Lao People's Democratic Republic") echo 'selected="selected"'; ?>>Lao People's Democratic Republic</option> 
                                        <option value="Latvia" <?php if ($user['location'] == "Latvia") echo 'selected="selected"'; ?>>Latvia</option> 
                                        <option value="Lebanon" <?php if ($user['location'] == "Lebanon") echo 'selected="selected"'; ?>>Lebanon</option> 
                                        <option value="Lesotho" <?php if ($user['location'] == "Lesotho") echo 'selected="selected"'; ?>>Lesotho</option> 
                                        <option value="Liberia" <?php if ($user['location'] == "Liberia") echo 'selected="selected"'; ?>>Liberia</option> 
                                        <option value="Libyan Arab Jamahiriya" <?php if ($user['location'] == "Libyan Arab Jamahiriya") echo 'selected="selected"'; ?>>Libyan Arab Jamahiriya</option> 
                                        <option value="Liechtenstein" <?php if ($user['location'] == "Liechtenstein") echo 'selected="selected"'; ?>>Liechtenstein</option> 
                                        <option value="Lithuania" <?php if ($user['location'] == "Lithuania") echo 'selected="selected"'; ?>>Lithuania</option> 
                                        <option value="Luxembourg" <?php if ($user['location'] == "Luxembourg") echo 'selected="selected"'; ?>>Luxembourg</option> 
                                        <option value="Macao" <?php if ($user['location'] == "Macao") echo 'selected="selected"'; ?>>Macao</option> 
                                        <option value="Macedonia, The Former Yugoslav Republic of" <?php if ($user['location'] == "Macedonia, The Former Yugoslav Republic of") echo 'selected="selected"'; ?>>Macedonia, The Former Yugoslav Republic of</option> 
                                        <option value="Madagascar" <?php if ($user['location'] == "Madagascar") echo 'selected="selected"'; ?>>Madagascar</option> 
                                        <option value="Malawi" <?php if ($user['location'] == "Malawi") echo 'selected="selected"'; ?>>Malawi</option> 
                                        <option value="Malaysia" <?php if ($user['location'] == "Malaysia") echo 'selected="selected"'; ?>>Malaysia</option> 
                                        <option value="Maldives" <?php if ($user['location'] == "Maldives") echo 'selected="selected"'; ?>>Maldives</option> 
                                        <option value="Mali" <?php if ($user['location'] == "Mali") echo 'selected="selected"'; ?>>Mali</option> 
                                        <option value="Malta" <?php if ($user['location'] == "Malta") echo 'selected="selected"'; ?>>Malta</option> 
                                        <option value="Marshall Islands" <?php if ($user['location'] == "Marshall Islands") echo 'selected="selected"'; ?>>Marshall Islands</option> 
                                        <option value="Martinique" <?php if ($user['location'] == "Martinique") echo 'selected="selected"'; ?>>Martinique</option> 
                                        <option value="Mauritania" <?php if ($user['location'] == "Mauritania") echo 'selected="selected"'; ?>>Mauritania</option> 
                                        <option value="Mauritius" <?php if ($user['location'] == "Mauritius") echo 'selected="selected"'; ?>>Mauritius</option> 
                                        <option value="Mayotte" <?php if ($user['location'] == "Mayotte") echo 'selected="selected"'; ?>>Mayotte</option> 
                                        <option value="Mexico" <?php if ($user['location'] == "Mexico") echo 'selected="selected"'; ?>>Mexico</option> 
                                        <option value="Micronesia, Federated States of" <?php if ($user['location'] == "Micronesia, Federated States of") echo 'selected="selected"'; ?>>Micronesia, Federated States of</option> 
                                        <option value="Moldova, Republic of" <?php if ($user['location'] == "Moldova, Republic of") echo 'selected="selected"'; ?>>Moldova, Republic of</option> 
                                        <option value="Monaco" <?php if ($user['location'] == "Monaco") echo 'selected="selected"'; ?>>Monaco</option> 
                                        <option value="Mongolia" <?php if ($user['location'] == "Mongolia") echo 'selected="selected"'; ?>>Mongolia</option> 
                                        <option value="Montserrat" <?php if ($user['location'] == "Montserrat") echo 'selected="selected"'; ?>>Montserrat</option> 
                                        <option value="Morocco" <?php if ($user['location'] == "Morocco") echo 'selected="selected"'; ?>>Morocco</option> 
                                        <option value="Mozambique" <?php if ($user['location'] == "Mozambique") echo 'selected="selected"'; ?>>Mozambique</option> 
                                        <option value="Myanmar" <?php if ($user['location'] == "Myanmar") echo 'selected="selected"'; ?>>Myanmar</option> 
                                        <option value="Namibia" <?php if ($user['location'] == "Namibia") echo 'selected="selected"'; ?>>Namibia</option> 
                                        <option value="Nauru" <?php if ($user['location'] == "Nauru") echo 'selected="selected"'; ?>>Nauru</option> 
                                        <option value="Nepal" <?php if ($user['location'] == "Nepal") echo 'selected="selected"'; ?>>Nepal</option> 
                                        <option value="Netherlands" <?php if ($user['location'] == "Netherlands") echo 'selected="selected"'; ?>>Netherlands</option> 
                                        <option value="Netherlands Antilles" <?php if ($user['location'] == "Netherlands Antilles") echo 'selected="selected"'; ?>>Netherlands Antilles</option> 
                                        <option value="New Caledonia" <?php if ($user['location'] == "New Caledonia") echo 'selected="selected"'; ?>>New Caledonia</option> 
                                        <option value="New Zealand" <?php if ($user['location'] == "New Zealand") echo 'selected="selected"'; ?>>New Zealand</option> 
                                        <option value="Nicaragua" <?php if ($user['location'] == "Nicaragua") echo 'selected="selected"'; ?>>Nicaragua</option> 
                                        <option value="Niger" <?php if ($user['location'] == "Niger") echo 'selected="selected"'; ?>>Niger</option> 
                                        <option value="Nigeria" <?php if ($user['location'] == "Nigeria") echo 'selected="selected"'; ?>>Nigeria</option> 
                                        <option value="Niue" <?php if ($user['location'] == "Niue") echo 'selected="selected"'; ?>>Niue</option> 
                                        <option value="Norfolk Island" <?php if ($user['location'] == "Norfolk Island") echo 'selected="selected"'; ?>>Norfolk Island</option> 
                                        <option value="Northern Mariana Islands" <?php if ($user['location'] == "Northern Mariana Islands") echo 'selected="selected"'; ?>>Northern Mariana Islands</option> 
                                        <option value="Norway" <?php if ($user['location'] == "Norway") echo 'selected="selected"'; ?>>Norway</option> 
                                        <option value="Oman" <?php if ($user['location'] == "Oman") echo 'selected="selected"'; ?>>Oman</option> 
                                        <option value="Pakistan" <?php if ($user['location'] == "Pakistan") echo 'selected="selected"'; ?>>Pakistan</option> 
                                        <option value="Palau" <?php if ($user['location'] == "Palau") echo 'selected="selected"'; ?>>Palau</option> 
                                        <option value="Palestinian Territory, Occupied" <?php if ($user['location'] == "Palestinian Territory, Occupied") echo 'selected="selected"'; ?>>Palestinian Territory, Occupied</option> 
                                        <option value="Panama" <?php if ($user['location'] == "Panama") echo 'selected="selected"'; ?>>Panama</option> 
                                        <option value="Papua New Guinea" <?php if ($user['location'] == "Papua New Guinea") echo 'selected="selected"'; ?>>Papua New Guinea</option> 
                                        <option value="Paraguay" <?php if ($user['location'] == "Paraguay") echo 'selected="selected"'; ?>>Paraguay</option> 
                                        <option value="Peru" <?php if ($user['location'] == "Peru") echo 'selected="selected"'; ?>>Peru</option> 
                                        <option value="Philippines" <?php if ($user['location'] == "Philippines") echo 'selected="selected"'; ?>>Philippines</option> 
                                        <option value="Pitcairn" <?php if ($user['location'] == "Pitcairn") echo 'selected="selected"'; ?>>Pitcairn</option> 
                                        <option value="Poland" <?php if ($user['location'] == "Poland") echo 'selected="selected"'; ?>>Poland</option> 
                                        <option value="Portugal" <?php if ($user['location'] == "Portugal") echo 'selected="selected"'; ?>>Portugal</option> 
                                        <option value="Puerto Rico" <?php if ($user['location'] == "Puerto Rico") echo 'selected="selected"'; ?>>Puerto Rico</option> 
                                        <option value="Qatar" <?php if ($user['location'] == "Qatar") echo 'selected="selected"'; ?>>Qatar</option> 
                                        <option value="Reunion" <?php if ($user['location'] == "Reunion") echo 'selected="selected"'; ?>>Reunion</option> 
                                        <option value="Romania" <?php if ($user['location'] == "Romania") echo 'selected="selected"'; ?>>Romania</option> 
                                        <option value="Russian Federation" <?php if ($user['location'] == "Russian Federation") echo 'selected="selected"'; ?>>Russian Federation</option> 
                                        <option value="Rwanda" <?php if ($user['location'] == "Rwanda") echo 'selected="selected"'; ?>>Rwanda</option> 
                                        <option value="Saint Helena" <?php if ($user['location'] == "Saint Helena") echo 'selected="selected"'; ?>>Saint Helena</option> 
                                        <option value="Saint Kitts and Nevis" <?php if ($user['location'] == "Saint Kitts and Nevis") echo 'selected="selected"'; ?>>Saint Kitts and Nevis</option> 
                                        <option value="Saint Lucia" <?php if ($user['location'] == "Saint Lucia") echo 'selected="selected"'; ?>>Saint Lucia</option> 
                                        <option value="Saint Pierre and Miquelon" <?php if ($user['location'] == "Saint Pierre and Miquelon") echo 'selected="selected"'; ?>>Saint Pierre and Miquelon</option> 
                                        <option value="Saint Vincent and The Grenadines" <?php if ($user['location'] == "Saint Vincent and The Grenadines") echo 'selected="selected"'; ?>>Saint Vincent and The Grenadines</option> 
                                        <option value="Samoa" <?php if ($user['location'] == "Samoa") echo 'selected="selected"'; ?>>Samoa</option> 
                                        <option value="San Marino" <?php if ($user['location'] == "San Marino") echo 'selected="selected"'; ?>>San Marino</option> 
                                        <option value="Sao Tome and Principe" <?php if ($user['location'] == "Sao Tome and Principe") echo 'selected="selected"'; ?>>Sao Tome and Principe</option> 
                                        <option value="Saudi Arabia" <?php if ($user['location'] == "Saudi Arabia") echo 'selected="selected"'; ?>>Saudi Arabia</option> 
                                        <option value="Senegal" <?php if ($user['location'] == "Senegal") echo 'selected="selected"'; ?>>Senegal</option> 
                                        <option value="Serbia and Montenegro" <?php if ($user['location'] == "Serbia and Montenegro") echo 'selected="selected"'; ?>>Serbia and Montenegro</option> 
                                        <option value="Seychelles" <?php if ($user['location'] == "Seychelles") echo 'selected="selected"'; ?>>Seychelles</option> 
                                        <option value="Sierra Leone" <?php if ($user['location'] == "Sierra Leone") echo 'selected="selected"'; ?>>Sierra Leone</option> 
                                        <option value="Singapore" <?php if ($user['location'] == "Singapore") echo 'selected="selected"'; ?>>Singapore</option> 
                                        <option value="Slovakia" <?php if ($user['location'] == "Slovakia") echo 'selected="selected"'; ?>>Slovakia</option> 
                                        <option value="Slovenia" <?php if ($user['location'] == "Slovenia") echo 'selected="selected"'; ?>>Slovenia</option> 
                                        <option value="Solomon Islands" <?php if ($user['location'] == "Solomon Islands") echo 'selected="selected"'; ?>>Solomon Islands</option> 
                                        <option value="Somalia" <?php if ($user['location'] == "Somalia") echo 'selected="selected"'; ?>>Somalia</option> 
                                        <option value="South Africa" <?php if ($user['location'] == "South Africa") echo 'selected="selected"'; ?>>South Africa</option> 
                                        <option value="South Georgia and The South Sandwich Islands" <?php if ($user['location'] == "South Georgia and The South Sandwich Islands") echo 'selected="selected"'; ?>>South Georgia and The South Sandwich Islands</option> 
                                        <option value="Spain" <?php if ($user['location'] == "Spain") echo 'selected="selected"'; ?>>Spain</option> 
                                        <option value="Sri Lanka" <?php if ($user['location'] == "Sri Lanka") echo 'selected="selected"'; ?>>Sri Lanka</option> 
                                        <option value="Sudan" <?php if ($user['location'] == "Sudan") echo 'selected="selected"'; ?>>Sudan</option> 
                                        <option value="Suriname" <?php if ($user['location'] == "Suriname") echo 'selected="selected"'; ?>>Suriname</option> 
                                        <option value="Svalbard and Jan Mayen" <?php if ($user['location'] == "Svalbard and Jan Mayen") echo 'selected="selected"'; ?>>Svalbard and Jan Mayen</option> 
                                        <option value="Swaziland" <?php if ($user['location'] == "Swaziland") echo 'selected="selected"'; ?>>Swaziland</option> 
                                        <option value="Sweden" <?php if ($user['location'] == "Sweden") echo 'selected="selected"'; ?>>Sweden</option> 
                                        <option value="Switzerland" <?php if ($user['location'] == "Switzerland") echo 'selected="selected"'; ?>>Switzerland</option> 
                                        <option value="Syrian Arab Republic" <?php if ($user['location'] == "Syrian Arab Republic") echo 'selected="selected"'; ?>>Syrian Arab Republic</option> 
                                        <option value="Taiwan, Province of China" <?php if ($user['location'] == "Taiwan, Province of China") echo 'selected="selected"'; ?>>Taiwan, Province of China</option> 
                                        <option value="Tajikistan" <?php if ($user['location'] == "Tajikistan") echo 'selected="selected"'; ?>>Tajikistan</option> 
                                        <option value="Tanzania, United Republic of" <?php if ($user['location'] == "Tanzania, United Republic of") echo 'selected="selected"'; ?>>Tanzania, United Republic of</option> 
                                        <option value="Thailand" <?php if ($user['location'] == "Thailand") echo 'selected="selected"'; ?>>Thailand</option> 
                                        <option value="Timor-leste" <?php if ($user['location'] == "Timor-leste") echo 'selected="selected"'; ?>>Timor-leste</option> 
                                        <option value="Togo" <?php if ($user['location'] == "Togo") echo 'selected="selected"'; ?>>Togo</option> 
                                        <option value="Tokelau" <?php if ($user['location'] == "Tokelau") echo 'selected="selected"'; ?>>Tokelau</option> 
                                        <option value="Tonga" <?php if ($user['location'] == "Tonga") echo 'selected="selected"'; ?>>Tonga</option> 
                                        <option value="Trinidad and Tobago" <?php if ($user['location'] == "Trinidad and Tobago") echo 'selected="selected"'; ?>>Trinidad and Tobago</option> 
                                        <option value="Tunisia" <?php if ($user['location'] == "Tunisia") echo 'selected="selected"'; ?>>Tunisia</option> 
                                        <option value="Turkey" <?php if ($user['location'] == "Turkey") echo 'selected="selected"'; ?>>Turkey</option> 
                                        <option value="Turkmenistan" <?php if ($user['location'] == "Turkmenistan") echo 'selected="selected"'; ?>>Turkmenistan</option> 
                                        <option value="Turks and Caicos Islands" <?php if ($user['location'] == "Turks and Caicos Islands") echo 'selected="selected"'; ?>>Turks and Caicos Islands</option> 
                                        <option value="Tuvalu" <?php if ($user['location'] == "Tuvalu") echo 'selected="selected"'; ?>>Tuvalu</option> 
                                        <option value="Uganda" <?php if ($user['location'] == "Uganda") echo 'selected="selected"'; ?>>Uganda</option> 
                                        <option value="Ukraine" <?php if ($user['location'] == "Ukraine") echo 'selected="selected"'; ?>>Ukraine</option> 
                                        <option value="United Arab Emirates" <?php if ($user['location'] == "United Arab Emirates") echo 'selected="selected"'; ?>>United Arab Emirates</option> 
                                        <option value="United Kingdom" <?php if ($user['location'] == "United Kingdom") echo 'selected="selected"'; ?>>United Kingdom</option> 
                                        <option value="United States" <?php if ($user['location'] == "United States") echo 'selected="selected"'; ?>>United States</option> 
                                        <option value="United States Minor Outlying Islands" <?php if ($user['location'] == "United States Minor Outlying Islands") echo 'selected="selected"'; ?>>United States Minor Outlying Islands</option> 
                                        <option value="Uruguay" <?php if ($user['location'] == "Uruguay") echo 'selected="selected"'; ?>>Uruguay</option> 
                                        <option value="Uzbekistan" <?php if ($user['location'] == "Uzbekistan") echo 'selected="selected"'; ?>>Uzbekistan</option> 
                                        <option value="Vanuatu" <?php if ($user['location'] == "Vanuatu") echo 'selected="selected"'; ?>>Vanuatu</option> 
                                        <option value="Venezuela" <?php if ($user['location'] == "Venezuela") echo 'selected="selected"'; ?>>Venezuela</option> 
                                        <option value="Viet Nam" <?php if ($user['location'] == "Viet Nam") echo 'selected="selected"'; ?>>Viet Nam</option> 
                                        <option value="Virgin Islands, British" <?php if ($user['location'] == "Virgin Islands, British") echo 'selected="selected"'; ?>>Virgin Islands, British</option> 
                                        <option value="Virgin Islands, U.S." <?php if ($user['location'] == "Virgin Islands, U.S.") echo 'selected="selected"'; ?>>Virgin Islands, U.S.</option> 
                                        <option value="Wallis and Futuna" <?php if ($user['location'] == "Wallis and Futuna") echo 'selected="selected"'; ?>>Wallis and Futuna</option> 
                                        <option value="Western Sahara" <?php if ($user['location'] == "Western Sahara") echo 'selected="selected"'; ?>>Western Sahara</option> 
                                        <option value="Yemen" <?php if ($user['location'] == "Yemen") echo 'selected="selected"'; ?>>Yemen</option> 
                                        <option value="Zambia" <?php if ($user['location'] == "Zambia") echo 'selected="selected"'; ?>>Zambia</option> 
                                        <option value="Zimbabwe" <?php if ($user['location'] == "Zimbabwe") echo 'selected="selected"'; ?>>Zimbabwe</option>
                                    </select>

                                </div>
                                <div>
                                    <label  for="contactMessage">Work</label>
                                    <input placeholder="<?php echo $user['work']; ?>" type="text" name="work"  id="work" size="15" value="" />
                                </div>
                                <div>
                                    <label  for="contactMessage">Education</label>
                                    <input placeholder="<?php echo $user['education']; ?>" type="text" name="education"  id="education" size="15" value="" />
                                </div>

                                <div>
                                    <label  for="contactMessage">Biography</label>
                                    <textarea placeholder="<?php echo $user['bio']; ?>" name="biography"  value="" id="biography" rows="5" cols="50" ></textarea>
                                </div>

                                <div>
                                    <button type="button" id="info-button">Submit</button>
                                    <span id="image-loader">
                                        <img src="images/loader.gif" alt="" />
                                    </span>
                                </div>

                            </fieldset>
                        </form> <!-- Form End -->

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

        </footer>
    <!-- Java Script
    ================================================== -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
    <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.form.min.js"></script>
    <script src="js/jquery.flexslider.js"></script>
    <script src="js/doubletaptogo.js"></script>
    <script src="js/init.js"></script>
    <script>
                                               $(document).ready(function() {
                                                   $('#info-button').click(function() {
                                                       var first = $.trim($('#first').val());
                                                       var last = $.trim($('#last').val());
                                                       var age = $.trim($('#age').val());
                                                       var gender = $.trim($('#gender').val());
                                                       var work = $.trim($('#work').val());
                                                       var education = $.trim($('#education').val());
                                                       var bio = $.trim($('#biography').val());
                                                       var country = $.trim($('#country').val());

                                                       if (first != "" || last != "" || age != "" || gender != "" || work != "" || education != "" || bio != ""
                                                               || country != "") {
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
</body>




