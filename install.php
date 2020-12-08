<?php
/**
 * installer wizard
 * 
 * @package Santa Blog
 * @author PSpike
 * https://endgame.ro
 */
 

require 'includes/install.php';

define('SANTA_BLOG', '1.0');

define('ABSPATH',dirname(__FILE__).'/');

// check the config file
if(file_exists(ABSPATH.'includes/configuration.php')) {
    /* the config file exist -> start the system */
    header('Location: ./');
}

// check system requirements
check_system_requirements();


// install
if(isset($_POST['submit'])) {
	
    // connect to the db
    $db = new mysqli($_POST['db_host'], $_POST['db_username'], $_POST['db_password'], $_POST['db_name']);
    if(mysqli_connect_error()) {
        _error(DB_ERROR);
    }

    /* check username */
    if(!valid_username($_POST['admin_username'])) {
        _error("Error", "Please enter a valid username (a-z0-9_.) with minimum 3 characters long");
    }
    /* check password */
    if(is_empty($_POST['admin_password']) || strlen($_POST['admin_password']) < 6) {
        _error("Error", "Your password must be at least 6 characters long. Please try another");
    }
    /* check full name */
    if(is_empty($_POST['admin_fullname'])) {
        _error("Error", "Please enter a Full Name");
    }


    if(is_empty($_POST['site_url'])) {
        _error("Error", "Please enter a url Name");
    }		
    if(is_empty($_POST['site_name'])) {
        _error("Error", "Please enter a Site Name");
    }	

    if(is_empty($_POST['site_description'])) {
        _error("Error", "Please enter a description");
    }

    // create the database
    $structure = "	
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET time_zone = '+00:00';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Table structure for table `admins`
--
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `aname` varchar(30) NOT NULL,
  `aheadline` varchar(30) NOT NULL,
  `abio` varchar(500) NOT NULL,
  `aimage` varchar(60) NOT NULL DEFAULT 'avatar.png',
  `addedby` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `datetime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `approvedby` varchar(50) NOT NULL,
  `status` varchar(3) NOT NULL,
  `post_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  `title` varchar(300) NOT NULL,
  `category` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `post` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Foreign_Relation` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

   ";
    $db->multi_query($structure) or _error("Error", $db->error);
	
	
        do{} while(mysqli_more_results($db) && mysqli_next_result($db));
		
    // add the admin account
    $db->query(sprintf("INSERT INTO admins (`id`, `datetime`, `username`, `password`, `aname`, `aheadline`, `abio`, `aimage`, `addedby`) VALUES ('1', 'January-13-2019 23:54:07', %s, %s, %s, '', '', '', '')", secure($_POST['admin_username']), secure($_POST['admin_password']), secure($_POST['admin_fullname']) )) or _error("Error", $db->error);		
		 




$string = '<?php
$db_host="' . $_POST['db_host'] . '";
$db_name="' . $_POST['db_name'] . '";
$db_user="' . $_POST['db_username'] . '";
$db_pass="' . $_POST['db_password'] . '";
$DSN="mysql:host=$db_host;dbname=$db_name";
$ConnectingDB = new PDO($DSN, $db_user, $db_pass);
?>';
$fp = fopen('includes/DB.php', 'w');
fwrite($fp, $string);
fclose($fp);


   // create config file
    $config_string = "
<?php
class APPConfig{
    const SITE_NAME = '". $_POST["site_name"]. "';
    const SITE_URL = '". $_POST["site_url"]. "';
    const SITE_DESC = '". $_POST["site_description"]. "';
    const SITE_ADS = 'ADS';
	const TRACK_1 = 'assets/mp3/track1.mp3';
	const TRACK_1_NAME = 'WE WISH YOU A MERRY CHRISTMAS';	
	const TRACK_2 = 'assets/mp3/track2.mp3';
	const TRACK_2_NAME = 'O CHRISTMAS TREE ';		
	const TRACK_3 = 'assets/mp3/track3.mp3';
	const TRACK_3_NAME = 'JINGLE BELLS';		
	const TRACK_4 = 'assets/mp3/track1.mp3';
	const TRACK_4_NAME = 'ATMOSPHERIC SILENT NIGHT';		
	const TRACK_5 = 'assets/mp3/track5.mp3';
	const TRACK_5_NAME = 'MERRY CHRISTMAS YA FILTHY ANIMAL';
	const ONESIGNAL_ID = 'your_id';
	const ONESIGNAL_KEY = 'your_key';
	const ADDTHIS_CODE1 = 'addthis 1';
	const ADDTHIS_CODE2 = 'addthis 2';	
}
";
    $config_file = 'includes/configuration.php';
    $handle = fopen($config_file, 'w') or _error("Error", "Santa Blog intsaller wizard cannot create the config file");
    fwrite($handle, $config_string);
    fclose($handle);
    

    // start the system
    header('Location: ./');
}

?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Santa Blog &rsaquo; Installer</title>
      <style>
	    body{
		background: #141E30;  /* fallback for old browsers */
		background: -webkit-linear-gradient(to right, #243B55, #141E30);  /* Chrome 10-25, Safari 5.1-6 */
		background: linear-gradient(to right, #243B55, #141E30); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
		}
         input[type=text], select {
         width: 100%;
         padding: 12px 20px;
         margin: 8px 0;
         display: inline-block;
         border: 1px solid #ccc;
         border-radius: 4px;
         box-sizing: border-box;
         }
         input[type=submit] {
         width: 100%;
         background-color: #4CAF50;
         color: white;
         padding: 14px 20px;
         margin: 8px 0;
         border: none;
         border-radius: 4px;
         cursor: pointer;
         }
         input[type=submit]:hover {
         background-color: #45a049;
         }
         div {
         border-radius: 100px;
         background-color: #f2f2f2;
         padding: 20px;
         }
      </style>
   </head>
   <body>
      <div class="container">
         <div class="fs-form-wrap" id="fs-form-wrap">
            <div class="fs-title">
               <h1>Santa Blog Installer (<?php echo SANTA_BLOG ?>)</h1>
            </div>
            <form id="myform" class="fs-form fs-form-full" autocomplete="off" action="install.php" method="post">
               <ol class="fs-fields">
                  <li>
                     <p class="fs-field-label fs-anim-upper">
                        Welcome to <strong>Santa Blog</strong> installation process! Just fill in the information below and create your own Blog
                     </p>
                  </li>
                  <li>
                     <label for="db_name" data-info="The name of the database you want to run Santa Blog in">What's Database Name?</label>
                     <input id="db_name" name="db_name" type="text" placeholder="database" required/>
                  </li>
                  <li>
                     <label for="db_username" data-info="Your MySQL username">What's Database Username?</label>
                     <input id="db_username" name="db_username" type="text" placeholder="username" required/>
                  </li>
                  <li>
                     <label for="db_password" data-info="Your MySQL password">What's Database Password?</label>
                     <input id="db_password" name="db_password" type="text" placeholder="password"/>
                  </li>
                  <li>
                     <label for="db_host" data-info="You should be able to get this info from your web host, if localhost does not work">What's Database Host?</label>
                     <input id="db_host" name="db_host" type="text" placeholder="localhost" value="localhost" required/>
                  </li>
                  <li>
                     <label for="admin_username" data-info="Usernames can have only alphanumeric characters, underscores, and periods.">Admin Username (like santa)</label>
                     <input id="admin_username" name="admin_username" type="text" placeholder="username" required/>
                  </li>
                  <li>
                     <label for="admin_password" data-info=' The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ & ).'>Admin Password (min 6 characters)</label>
                     <input id="admin_password" name="admin_password" type="text" placeholder="password" required/>
                  </li>
                  <li>
                     <label for="admin_fullname" data-info=''>Administrator name (like Santa Claus)</label>
                     <input id="admin_fullname" name="admin_fullname" type="text" placeholder="Full Name" required/>
                  </li>
                  <li>
                     <label for="site_url" data-info=''>Site url (like https://domain.com without "/") </label>
                     <input id="site_name" name="site_url" type="text" placeholder="Site Name" value="<?php echo $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";?>" required/>
                  </li>
                  <li>
                     <label for="site_name" data-info=''>Site Name</label>
                     <input id="site_name" name="site_name" type="text" placeholder="Site Name" required/>
                  </li>
                  <li>
                     <label for="site_description" data-info=''>Site Description</label>
                     <input id="site_description" name="site_description" type="text" placeholder="Site Description" required/>
                  </li>
               </ol>
               <button class="fs-submit" name="submit" type="submit">Install</button>
            </form>
         </div>
      </div>
   </body>
</html>