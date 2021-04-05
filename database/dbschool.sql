-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2021 at 01:24 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbschool`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(250) NOT NULL,
  `classId` text DEFAULT NULL,
  `subjectId` int(250) DEFAULT NULL,
  `teacherId` int(250) DEFAULT NULL,
  `AssignTitle` varchar(250) DEFAULT NULL,
  `AssignDescription` text DEFAULT NULL,
  `AssignFile` varchar(250) DEFAULT NULL,
  `AssignDeadLine` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `classId`, `subjectId`, `teacherId`, `AssignTitle`, `AssignDescription`, `AssignFile`, `AssignDeadLine`) VALUES
(5, '[\"7\",\"11\"]', 21, NULL, 'General apptitude 1', 'Carefully read the question and give the answer ', 'assignments_5c70087fd0e9f.jpg', '03/02/2019');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(250) NOT NULL,
  `classId` int(250) NOT NULL,
  `subjectId` int(250) NOT NULL,
  `date` varchar(250) NOT NULL,
  `studentId` int(250) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `classId`, `subjectId`, `date`, `studentId`, `status`) VALUES
(1, 1, 1, '04/04/2018', 4, 1),
(2, 1, 2, '04/04/2018', 4, 3),
(3, 1, 3, '04/04/2018', 4, 0),
(4, 1, 1, '04/11/2018', 4, 1),
(5, 1, 1, '04/01/2018', 4, 1),
(6, 1, 1, '05/15/2018', 4, 1),
(7, 1, 1, '05/05/2018', 4, 1),
(8, 1, 2, '05/24/2018', 4, 1),
(9, 10, 13, '07/09/2018', 8, 1),
(10, 10, 13, '07/09/2018', 9, 3),
(11, 10, 13, '07/11/2018', 8, 1),
(12, 10, 13, '07/11/2018', 9, 1),
(13, 10, 13, '07/11/2018', 10, 0),
(14, 10, 13, '08/01/2018', 10, 1),
(15, 10, 13, '08/01/2018', 14, 1),
(16, 6, 7, '10/04/2018', 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `booklibrary`
--

CREATE TABLE `booklibrary` (
  `id` int(250) NOT NULL,
  `bookName` varchar(250) NOT NULL,
  `bookDescription` text NOT NULL,
  `bookAuthor` varchar(250) NOT NULL,
  `bookType` varchar(20) NOT NULL,
  `bookPrice` varchar(250) DEFAULT NULL,
  `bookFile` varchar(250) DEFAULT NULL,
  `bookState` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `booklibrary`
--

INSERT INTO `booklibrary` (`id`, `bookName`, `bookDescription`, `bookAuthor`, `bookType`, `bookPrice`, `bookFile`, `bookState`) VALUES
(1, 'HTML ', 'Many books that teach HTML \r\nresemble dull manuals. To make it easier for \r\nyou to learn, we threw away the traditional \r\ntemplate used by publishers and redesigned \r\nthis book from scratch.', 'Jon Du Cke TT', 'electronic', '', 'book_5c3c100ce5e71.pdf', 1),
(2, 'C', 'Basic of C language', 'Dennis Ritchie', 'electronic', '950', 'book_5c3c0fa13012f.pdf', 1),
(3, 'C++', 'C++ without fear is a good first book  in computer programming ', 'Bjrane Stroustrup', 'traditional', '499', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(250) NOT NULL,
  `className` varchar(250) NOT NULL,
  `classTeacher` text NOT NULL,
  `dormitoryId` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `className`, `classTeacher`, `dormitoryId`) VALUES
(3, 'First Year-A', '[\"24\"]', 19),
(4, 'First Year-B', '[\"11\"]', 19),
(6, 'E&TC-SE', '[\"11\"]', 17),
(7, 'E&TC-TE', '[\"20\"]', 17),
(8, 'E&TC-BE', '[\"12\"]', 17),
(9, 'CSE-SE', '[\"6\"]', 2),
(10, 'CSE-TE', '[\"12\"]', 3),
(11, 'CSE-BE', '[\"20\"]', 4),
(15, 'Mechanical TE', '[\"59\"]', 14),
(16, 'Mechanical SE', '[\"59\"]', 13),
(17, 'Mechanical BE', '[\"59\"]', 12),
(18, 'Civil SE', '[\"58\"]', 16),
(19, 'Civil TE', '[\"58\"]', 15),
(20, 'Civil', '[\"58\"]', 16);

-- --------------------------------------------------------

--
-- Table structure for table `classschedule`
--

CREATE TABLE `classschedule` (
  `id` int(250) NOT NULL,
  `classId` int(250) NOT NULL,
  `subjectId` int(250) NOT NULL,
  `dayOfWeek` varchar(10) NOT NULL,
  `startTime` varchar(20) NOT NULL,
  `endTime` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classschedule`
--

INSERT INTO `classschedule` (`id`, `classId`, `subjectId`, `dayOfWeek`, `startTime`, `endTime`) VALUES
(4, 10, 13, '1', '0930', '1130'),
(5, 10, 13, '2', '0930', '1130'),
(6, 10, 13, '3', '0930', '1130'),
(7, 10, 13, '4', '0930', '1130'),
(8, 10, 13, '5', '0930', '1130'),
(9, 10, 13, '6', '0930', '1130'),
(10, 11, 14, '1', '1045', '1145'),
(11, 11, 14, '3', '0930', '1030'),
(12, 11, 14, '4', '0830', '0930'),
(13, 11, 16, '4', '1045', '1245'),
(14, 11, 16, '4', '0130', '0330'),
(16, 12, 15, '2', '0930', '1030'),
(17, 12, 15, '3', '1145', '1245'),
(18, 12, 17, '5', '1045', '1245'),
(19, 12, 17, '5', '0130', '0330'),
(20, 12, 15, '5', '0830', '0930'),
(21, 5, 7, '2', '0830', '0930'),
(22, 5, 5, '2', '0930', '1030'),
(23, 6, 9, '4', '0325', '0430');

-- --------------------------------------------------------

--
-- Table structure for table `dormitories`
--

CREATE TABLE `dormitories` (
  `id` int(250) NOT NULL,
  `dormitory` varchar(250) NOT NULL,
  `dormDesc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dormitories`
--

INSERT INTO `dormitories` (`id`, `dormitory`, `dormDesc`) VALUES
(2, 'Computer Department Classroom 1', 'Main Building 3rd floor'),
(3, 'Computer Department Classroom 2', 'Main Building 3rd Floor'),
(4, 'Computer Department Classroom 3', 'Main Building 3rd floor'),
(5, 'Computer Department Classroom 4', '2nd Floor'),
(6, 'Computer Department Operating System Laboratory', '2nd Floor'),
(7, 'Computer Department Database System Laboratory', '2nd Floor'),
(8, 'Computer Department Project & Interner Laboratory', '2nd Floor'),
(9, 'Computer Department Application Development Tool Laboratory I', '2nd Floor'),
(10, 'Computer Department Application Development Tool Laboratory II', '2nd Floor'),
(11, 'Computer Department Web Development Laboratory', '2nd Floor'),
(12, 'Mechanical Department Laboratory', '2nd Floor'),
(13, 'Mechanical Department Classroom', '2nd Floor'),
(14, 'Mechanical Department Classroom 1', '1st Floor'),
(15, 'Civil Department Classroom', '1st Floor'),
(16, 'Civil Department Laboratory', '2nd Floor'),
(17, 'E&TC Department Classroom', 'Main Building 2nd Floor'),
(18, 'E&TC Department Laboratory', 'Main Building 2nd Floor'),
(19, 'General Science Department Classroom', '1st Floor'),
(20, 'Ground Floor', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(250) NOT NULL,
  `eventTitle` varchar(250) NOT NULL,
  `eventDescription` text DEFAULT NULL,
  `eventFor` varchar(10) DEFAULT NULL,
  `enentPlace` varchar(250) DEFAULT NULL,
  `eventDate` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exammarks`
--

CREATE TABLE `exammarks` (
  `id` int(250) NOT NULL,
  `examId` int(250) NOT NULL,
  `classId` int(250) NOT NULL,
  `subjectId` int(250) NOT NULL,
  `studentId` int(250) NOT NULL,
  `examMark` varchar(250) NOT NULL,
  `attendanceMark` varchar(250) NOT NULL,
  `markComments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exammarks`
--

INSERT INTO `exammarks` (`id`, `examId`, `classId`, `subjectId`, `studentId`, `examMark`, `attendanceMark`, `markComments`) VALUES
(1, 2, 10, 4, 8, '', '', ''),
(2, 2, 10, 4, 9, '', '', ''),
(3, 2, 10, 4, 10, '', '', ''),
(4, 2, 10, 4, 13, '100', '90', 'Very Good'),
(5, 2, 10, 4, 14, '', '', ''),
(6, 2, 10, 4, 15, '', '', ''),
(7, 2, 10, 4, 16, '', '', ''),
(8, 2, 10, 4, 17, '', '', ''),
(9, 2, 10, 4, 18, '', '', ''),
(10, 4, 9, 19, 51, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `examslist`
--

CREATE TABLE `examslist` (
  `id` int(250) NOT NULL,
  `examTitle` varchar(250) NOT NULL,
  `examDescription` text DEFAULT NULL,
  `examDate` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `examslist`
--

INSERT INTO `examslist` (`id`, `examTitle`, `examDescription`, `examDate`) VALUES
(4, 'C Test', 'Each and every question 1mark', '02/02/2019'),
(5, 'C++ Test', 'Each and every question 1Mark', '04/02/2019'),
(6, 'Probability', 'Each every question 1mark', '06/02/2019'),
(7, 'General apptitude', 'Each and every question for 1Mark', '08/02/2019'),
(8, 'General apptitude', 'Each and every question for 1Mark', '08/02/2019');

-- --------------------------------------------------------

--
-- Table structure for table `gradelevels`
--

CREATE TABLE `gradelevels` (
  `id` int(250) NOT NULL,
  `gradeName` varchar(250) NOT NULL,
  `gradeDescription` text DEFAULT NULL,
  `gradePoints` varchar(250) NOT NULL,
  `gradeFrom` varchar(250) NOT NULL,
  `gradeTo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gradelevels`
--

INSERT INTO `gradelevels` (`id`, `gradeName`, `gradeDescription`, `gradePoints`, `gradeFrom`, `gradeTo`) VALUES
(1, 'A', 'Those are above 80%', '80', '80', '100'),
(2, 'B', 'Those are above 60', '60', '60', '80'),
(3, 'C', 'Those are above 40%', '40', '40', '60'),
(4, 'D', 'Below 40%', 'less 40', '0', '40');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(250) NOT NULL,
  `languageTitle` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `isRTL` int(1) DEFAULT NULL,
  `languagePhrases` text CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `languageTitle`, `isRTL`, `languagePhrases`) VALUES
(1, 'English', 0, '{\"dashboard\":\"Dashboard\",\"usercode\":\"User Code\",\"classes\":\"Classes\",\"students\":\"Students\",\"teachers\":\"Teachers\",\"newmessages\":\"New Messages\",\"student\":\"Student\",\"teacher\":\"Teacher\",\"leaderboard\":\"Leader Board\",\"NewsEvents\":\"News & Events\",\"quicklinks\":\"Quick links\",\"AccountSettings\":\"Account Settings\",\"ChgProfileData\":\"Change profile data\",\"FullName\":\"Full name\",\"Gender\":\"Gender\",\"Birthday\":\"Birthday\",\"mobileNo\":\"Mobile No\",\"editProfile\":\"Edit profile\",\"reemail\":\"Retype Email address\",\"oldPassword\":\"Old password\",\"editPassword\":\"Edit password\",\"newPassword\":\"New password\",\"editMailAddress\":\"Edit e-mail address\",\"chgEmailAddress\":\"Change e-mail address\",\"Photo\":\"Photo\",\"Address\":\"Address\",\"Male\":\"Male\",\"Female\":\"Female\",\"phoneNo\":\"Phone No\",\"defLang\":\"Default language\",\"email\":\"Email address\",\"chgPassword\":\"Change password\",\"renewPassword\":\"Retype New password\",\"adminTasks\":\"Administrative tasks\",\"ClassSchedule\":\"Class Schedule\",\"Assignments\":\"Assignments\",\"booksLibrary\":\"Books library\",\"Attendance\":\"Attendance\",\"Onlineexams\":\"Online exams\",\"media\":\"Media\",\"Payments\":\"Payments\",\"Return\":\"Return\",\"Transport\":\"Transport\",\"Polls\":\"Polls\",\"votes\":\"View Votes\",\"Calendar\":\"Calendar\",\"Search\":\"Search\",\"username\":\"Username\",\"name\":\"Name\",\"ID\":\"ID\",\"Operations\":\"Operations\",\"cancelAdd\":\"Cancel add\",\"Calender\":\"Calender\",\"Status\":\"Status\",\"toggleDropdown\":\"Toggle Dropdown\",\"from\":\"From\",\"Export\":\"Export\",\"ExportCSV\":\"Export to CSV\",\"ImportCSV\":\"Import from CSV\",\"details\":\"Details\",\"Active\":\"Active\",\"specifyFileToImport\":\"Please specify file to upload\",\"Inactive\":\"Inactive\",\"saveSettings\":\"Save Settings\",\"available\":\"Available\",\"Import\":\"Import\",\"ExportExcel\":\"Export to Excel\",\"to\":\"To\",\"for\":\"For\",\"all\":\"All\",\"Calenderlist\":\"Calender list\",\"cancelEdit\":\"Cancel Edit\",\"Edit\":\"Edit\",\"Remove\":\"Remove\",\"Download\":\"Download\",\"Date\":\"Date\",\"Print\":\"Print\",\"Comments\":\"Comments\",\"Extras\":\"Extras\",\"ExportPDF\":\"Export to PDF\",\"ImportExcel\":\"Import from Excel\",\"unavailable\":\"Unavailable\",\"Description\":\"Description\",\"dataImported\":\"Data imported successfully\",\"registerAcc\":\"Registeration\",\"chkMailRestore\":\"Please check your e-mail for restore link\",\"expRestoreId\":\"Expired resore id ( > 24h ), please make new password resore request\",\"mustTypePwd\":\"You must type password\",\"usernameUsed\":\"Username already used, use another one\",\"mailUsed\":\"E-mail address already used, check it or restore password\",\"mustTypeFullName\":\"You must type full name\",\"invRstoreId\":\"Invalid URL or restore id, please make new password resore request\",\"chkInputFields\":\"Please check the input fields\",\"chkUserPass\":\"Please check your username & password\",\"chkUserMail\":\"Please check your username\\/e-mail\",\"pwdChangedSuccess\":\"Password changed successfully, press login to continue\",\"mustSelAccType\":\"You must select account type\",\"mustSelUsername\":\"You must type username\",\"invEmailAdd\":\"Invalid e-mail address\",\"notRepStCode\":\"is not represent student code\",\"Address2\":\"Address 2\",\"oldPwdDontMatch\":\"Old password don\'t match stored one\",\"mailAlreadyUsed\":\"E-mail address already used, check it or restore password\",\"allowLanguage\":\"Allow users change languages\",\"sysMail\":\"System E-mail\",\"setZero\":\"Set to 0 for none\",\"subBased\":\"Subject Based\",\"None\":\"None\",\"sendStudentsAbsendVia\":\"Send student\'s absense via\",\"schoolTerms\":\"School Terms\",\"generalSettings\":\"General Settings\",\"allowed\":\"Allowed\",\"paymentMail\":\"Paypal payment E-mail\",\"footer\":\"Footer Copyrights\",\"classBased\":\"Class only\",\"sendExamDet\":\"Send exam details to\",\"activatedModules\":\"Activated Modules\",\"siteTitle\":\"Site title\",\"notAllowed\":\"Not allowed\",\"payTax\":\"Payment Tax\",\"attendanceModel\":\"Attendance model\",\"examNotif\":\"Exam details notifications\",\"studentsParents\":\"Students & Parents\",\"editSettings\":\"Edit settings\",\"Administrators\":\"Administrators\",\"listAdministrators\":\"List administrators\",\"password\":\"Password\",\"adminUpdated\":\"Admin updated successfully\",\"usernameAlreadyUsed\":\"Username already used, use another one\",\"adminFullName\":\"Admin full name\",\"addAdministrator\":\"Add admininstrator\",\"editAdministrator\":\"Edit admininstrator\",\"emailAlreadyUsed\":\"E-mail address already used, check it or restore password\",\"AssignmentTitle\":\"Assignment title\",\"noAssignments\":\"No assignments\",\"assignmentCreated\":\"Assignment created successfully\",\"AddAssignments\":\"Add assignment\",\"AssignmentDescription\":\"Assignment Description\",\"AssignmentFile\":\"Assignment File\",\"assignmentModified\":\"Assignment modified successfully\",\"listAssignments\":\"List Assignments\",\"AssignmentDeadline\":\"Assignment Deadline\",\"editAssignment\":\"Edit Assignment\",\"selectAttendance\":\"Select attendance info to add\",\"Present\":\"Present\",\"LateExecuse\":\"Late with excuse\",\"attendanceStats\":\"Attendance Statistics\",\"attendanceFilters\":\"Search for attendance ( Select filters )\",\"absentReport\":\"Student absense report\",\"controlAttendance\":\"Control attendance\",\"Absent\":\"Absent\",\"earlyDismissal\":\"Early Dismissal\",\"attendancePerDay\":\"Attendance per day\",\"attendanceSearch\":\"Search attendance\",\"studentName\":\"Student Name\",\"Late\":\"Late\",\"saveAttendance\":\"Save attendance\",\"attendanceToday\":\"Attendance today\",\"attendanceSaved\":\"Attecndance saved successfully\",\"class\":\"Class\",\"addClass\":\"Add class\",\"classTeacher\":\"Class teacher\",\"className\":\"Class name\",\"listClasses\":\"List classes\",\"classDorm\":\"Class dormitory\",\"classSch\":\"Classes Schedule\",\"editClassSch\":\"Edit Class Schedule\",\"endTime\":\"End Time\",\"Sunday\":\"Sunday\",\"Wednesday\":\"Wednesday\",\"Saturday\":\"Saturday\",\"NoClasses\":\"No classes\",\"classEditSch\":\"Select class to edit schedule\",\"Day\":\"Day\",\"addSch\":\"Add Schedule\",\"Monday\":\"Monday\",\"Thurusday\":\"Thurusday\",\"classCreated\":\"Class created successfully\",\"editClass\":\"Edit Class\",\"ReadSchedule\":\"Read schedule\",\"startTime\":\"Start Time\",\"editSch\":\"Edit Schedule\",\"Tuesday\":\"Tuesday\",\"Friday\":\"Friday\",\"classUpdated\":\"Class updated successfully\",\"Dormitories\":\"Dormitories\",\"DormName\":\"Dormitory Name\",\"addDorm\":\"Add Dormitory\",\"dormUpdated\":\"Dormitory updated successfully\",\"addDormitories\":\"Add dormitory\",\"DormDesc\":\"Dormitory Description\",\"editDorm\":\"Edit Dormitory\",\"listDormitories\":\"List dormitories\",\"noDorm\":\"No dormitories\",\"dormCreated\":\"Dormitory created successfully\",\"listNews\":\"List news\",\"newsContent\":\"News content\",\"listEvents\":\"List events\",\"noEvents\":\"No events\",\"eventPlace\":\"Event Place\",\"eventModified\":\"Event modified successfully\",\"newsCreated\":\"News created successfully\",\"editEvent\":\"Edit event\",\"addEvent\":\"Add event\",\"eventNamePlace\":\"Event Name \\/ Place\",\"noNews\":\"No news\",\"addNews\":\"Add News\",\"newsboard\":\"News Board\",\"events\":\"Events\",\"newsTitle\":\"News title\",\"editNews\":\"Edit News\",\"eventDescription\":\"Event Description\",\"eventTitle\":\"Event Title\",\"eventCreated\":\"Event created successfully\",\"newsModified\":\"News modified successfully\",\"examsList\":\"Exams List\",\"examName\":\"Exam Name\",\"mark\":\"Mark\",\"selClassSubExam\":\"Select class & subject for exam\",\"attendanceMakrs\":\"Attendance Marks\",\"gradeLevels\":\"Grade levels\",\"gradeName\":\"Grade Name\",\"noGrades\":\"No grades\",\"editGrade\":\"Edit grade\",\"onlineExams\":\"Online Exams\",\"examDeadline\":\"Exam Deadline\",\"gradeCreated\":\"Grade created successfully\",\"gradeFrom\":\"Grade From\",\"gradeDesc\":\"Grade Description\",\"addLevel\":\"Add Grade level\",\"examMarks\":\"Exam Marks\",\"addMarks\":\"Add marks\",\"sendExamMarks\":\"Send marks notifications\",\"examDesc\":\"Exam Description\",\"addExam\":\"Add exam\",\"listExams\":\"List exams\",\"showMarks\":\"Show marks\",\"noExams\":\"No exams\",\"controlMarksExam\":\"Control marks for Exam\",\"addUpdateMarks\":\"Add\\/Update Marks\",\"listMarks\":\"List grades\",\"gradePoint\":\"Grade Point\",\"gradeTo\":\"Grade To\",\"gradeUpdated\":\"Grade updated successfully\",\"takeExam\":\"Take exam\",\"showExamGradesAfter\":\"Show grade after finish exams\",\"Answers\":\"Answers\",\"infoBox\":\"Info Box\",\"Grade\":\"Grade\",\"examModified\":\"Exam modified successfully\",\"examNotSent\":\"Notifications sent successfully\",\"examCreated\":\"Exam created successfully\",\"examDetailsNot\":\"Exam details notifications\",\"AveragePoints\":\"Average Points\",\"editExam\":\"Edit Exam\",\"trueAns\":\"True Answer\",\"Questions\":\"Questions\",\"Question\":\"Question\",\"addQuestion\":\"Add question\",\"submitAnswers\":\"Submit answers\",\"adjustExamNot\":\"Please adjust exam notifications first from General settings\",\"Languages\":\"Languages\",\"noLanguage\":\"No languages\",\"languagePhrases\":\"Language phrases\",\"langModified\":\"Language updated successfully\",\"editLanguage\":\"Edit Language\",\"addLanguage\":\"Add language\",\"listLanguage\":\"List languages\",\"languageName\":\"Language Name\",\"langCreated\":\"Language created successfully\",\"Library\":\"Library\",\"bookTitle\":\"Book title\",\"noBooks\":\"No books\",\"bookType\":\"Book Type\",\"bookPrice\":\"Book Price\",\"editBook\":\"Edit book\",\"bookAdded\":\"Book added successfully\",\"uploadBook\":\"Upload book\",\"traditionalBook\":\"Traditional Book\",\"addBook\":\"Add book\",\"bookAuthor\":\"Book Author\",\"listBooks\":\"List Books\",\"bookPriceState\":\"Book Price \\/ State\",\"bookDescription\":\"Book Description\",\"electronicBook\":\"Electronic Book\",\"State\":\"State\",\"bookModified\":\"Book modified successfully\",\"mailsms\":\"Mail \\/ SMS\",\"mailsmsSettings\":\"Mail\\/SMS Settings\",\"sendAs\":\"Send as\",\"mailSMSSend\":\"Send Mail \\/ SMS\",\"Sender\":\"Sender\",\"smsProvider\":\"SMS Provider\",\"mailsmsTemplates\":\"Mail \\/ SMS Templates\",\"noTemplates\":\"No templates\",\"mailTemplate\":\"Mail template\",\"smsTemplate\":\"SMS template\",\"editTemplate\":\"Edit template\",\"listTemplates\":\"List templates\",\"mailSettings\":\"Mail Settings\",\"noMessages\":\"No messages\",\"listMessages\":\"List Messages\",\"messageTitle\":\"Message Title\",\"selUsers\":\"Select users\",\"sms\":\"SMS\",\"listSentMessages\":\"List of sent messages\",\"typeUsers\":\"Type of users\",\"messageContent\":\"Message Content\",\"typeDate\":\"Type \\/ Date\",\"smsSettings\":\"SMS Settings\",\"mailDeliverType\":\"Mail Delivery Type\",\"templateTitle\":\"Template title\",\"templateVars\":\"Template variables\",\"templateUpdated\":\"Template updated successfully\",\"mediaCenter\":\"Media Center\",\"addAlbum\":\"Add album\",\"noMediaInAlbum\":\"No media exist in this album\",\"albumImage\":\"Album image\",\"mediaTitle\":\"Media title\",\"editMedia\":\"Edit media\",\"mediaCreated\":\"Media created successfully\",\"mediaModified\":\"Media modified successfully\",\"albumCreated\":\"Album created successfully\",\"mediaDesc\":\"Media description\",\"editAlbum\":\"Edit album\",\"albumTitle\":\"Album title\",\"albums\":\"Albums\",\"goUp\":\"Go to up\",\"uploadMedia\":\"Upload media\",\"albumDesc\":\"Album description\",\"addMedia\":\"Add media\",\"mediaImage\":\"Media image\",\"albumModified\":\"Album modified successfully\",\"Messages\":\"Messages\",\"composeMessage\":\"Compose Message\",\"typeReply\":\"Type reply ( press enter to submit ) ...\",\"message\":\"Message\",\"messageNotExist\":\"The message you try to reach not exist\",\"userisntExist\":\"User isn\'t exist\",\"sendMessage\":\"Send Message\",\"markRead\":\"Mark as read\",\"markUnread\":\"Mark as unread\",\"loadOldMessages\":\"Load old messages\",\"sendMessageTo\":\"Send message to (username)\",\"readMessage\":\"Read Message\",\"paymentTitleDate\":\"Payment Title \\/ Date\",\"paid\":\"PAID\",\"noPayments\":\"No payments\",\"editPayment\":\"Edit payment\",\"AmountDue\":\"Amount Due\",\"paymentCreated\":\"Payments created successfully\",\"noPaymentDetails\":\"No Payment Details exist\",\"paymentModified\":\"Payments modified successfully\",\"Total\":\"Total\",\"Product\":\"Product\",\"paymentTitle\":\"Payment Title\",\"unpaid\":\"UNPAID\",\"paymentDesc\":\"Payment Description\",\"addPayment\":\"Add payment\",\"listPayments\":\"List payments\",\"Amount\":\"Amount\",\"viewInvoice\":\"View invoice\",\"paymentSelectMultiple\":\"Selecting multiple students will generate seperate invoice for each one\",\"Subtotal\":\"Subtotal\",\"listPaymentDetail\":\"List payment details\",\"paymentDetails\":\"Payment details\",\"pollTitle\":\"Poll title\",\"noPolls\":\"No Polls\",\"editPoll\":\"Edit poll\",\"pollCreated\":\"Poll created successfully\",\"pollUpdated\":\"Poll updated successfully\",\"activatePoll\":\"Activate Poll\",\"votePoll\":\"Vote poll\",\"pollOptions\":\"Poll Options\",\"pollTarget\":\"Poll target\",\"addPoll\":\"Add poll\",\"listPolls\":\"List polls\",\"pollStatus\":\"Poll status\",\"newOption\":\"New Option\",\"alreadyvoted\":\"You already voted before\",\"pollActivated\":\"Poll activated successfully\",\"staticPages\":\"Static pages\",\"listPages\":\"List pages\",\"editPage\":\"Edit page\",\"pageModified\":\"Page modified successfully\",\"controlPages\":\"Control Pages\",\"pageTitle\":\"Page title\",\"activeInactivePage\":\"Active \\/ Inactive page\",\"pageChanged\":\"Page changed successfully\",\"addPage\":\"Add page\",\"pageContent\":\"Page content\",\"pageCreated\":\"Page created successfully\",\"Subjects\":\"Subjects\",\"subjectName\":\"Subject name\",\"subjectCreated\":\"Subject created successfully\",\"Subject\":\"Subject\",\"noSubjects\":\"No subjects\",\"subjectEdited\":\"Subject edited successfully\",\"addSubject\":\"Add subject\",\"editSubject\":\"Edit Subject\",\"Transportation\":\"Transportation\",\"transportTitle\":\"Transport title\",\"Fare\":\"Fare\",\"editTransport\":\"Edit Transport\",\"transportCreated\":\"Transportation created successfully\",\"addTransport\":\"Add transport\",\"transportDesc\":\"Transport Description\",\"listSubs\":\"List subscribers\",\"Contact\":\"Contact\",\"transportUpdated\":\"Transportation updated successfully\",\"listTransport\":\"List transportation\",\"driverContact\":\"Driver Contact\",\"noTransportation\":\"No Transportation\",\"noMatches\":\"No matches\",\"parents\":\"Parents\",\"role\":\"Role\",\"listTeachers\":\"List teachers\",\"EditTeacher\":\"Edit Teacher\",\"rollid\":\"Roll id\",\"listParents\":\"List parents\",\"studentDetails\":\"Student Details\",\"parent\":\"Parent\",\"addTeacher\":\"Add teacher\",\"noTeachers\":\"No teachers\",\"fileToImport\":\"File to import\",\"Marksheet\":\"Marksheet\",\"editStudent\":\"Edit student\",\"noParents\":\"No parents\",\"Relation\":\"Relation\",\"editParent\":\"Edit Parent\",\"Profession\":\"Profession\",\"AddParent\":\"Add parent\",\"noStudents\":\"No students\",\"addStudent\":\"Add student\",\"Approve\":\"Approve\",\"waitingApproval\":\"Waiting approval\",\"csvParentInvalid\":\"This file not represent CSV parents file\",\"Profile\":\"Profile\",\"teacherInfo\":\"Teacher Information\",\"studentHaveNoMarks\":\"Student has no marks till now\",\"teacherCreated\":\"Teacher created successfully\",\"teacherUpdated\":\"Teacher updated successfully\",\"studentModified\":\"Student modified successfully\",\"csvStudentInvalid\":\"This file not represent CSV student file\",\"parentInfo\":\"Parent Information\",\"parentCreated\":\"Parent created successfully\",\"csvTeacherInvalid\":\"This file not represent CSV teacher file\",\"studentCreatedSuccess\":\"Student created successfully\",\"studentInfo\":\"Student Information\",\"parentModified\":\"Parent modified successfully\",\"listStudents\":\"List students\",\"latestVersion\":\"Latest Version\",\"logout\":\"Logout\",\"registerNewAccount\":\"Register a new membership\",\"restorePwd\":\"Restore Password\",\"userNameOrEmail\":\"Username \\/ E-mail\",\"rememberMe\":\"Remember me\",\"youfindStId\":\"You\'ll find Student code in your student dashboard main page, it look like:\",\"parntStudentIdSep\":\"Parent\'s Students ids - seperate with ,\",\"thankReg\":\"Thank you for register, please contact school for activating your account with id\",\"signIn\":\"Sign in\",\"resetPwdNow\":\"Reset password now\",\"printPage\":\"Print this page\",\"loginToAccount\":\"Login to your account\",\"theme\":\"Theme\",\"blue\":\"Blue\",\"black\":\"Black\",\"idNumber\":\"ID Number\",\"position\":\"ltr\",\"direction\":\"Direction\",\"rtl\":\"Right to left\",\"ltr\":\"Left to right\",\"Promotion\":\"Promotion\",\"studentsPromotedClass\":\"Students will promoted to class\",\"promoteStudents\":\"Promote students\",\"studentsToBPronoted\":\"Students to be promoted\"}');
INSERT INTO `languages` (`id`, `languageTitle`, `isRTL`, `languagePhrases`) VALUES
(6, 'Hindi', 0, '{\"dashboard\":\"\\u0921\\u0948\\u0936\\u092c\\u094b\\u0930\\u094d\\u0921\",\"usercode\":\"\\u0909\\u092a\\u092f\\u094b\\u0917\\u0915\\u0930\\u094d\\u0924\\u093e \\u0915\\u094b\\u0921\",\"classes\":\"\\u0915\\u094d\\u0932\\u093e\\u0938\\u0947\\u0938\",\"students\":\"\\u091b\\u093e\\u0924\\u094d\\u0930\",\"teachers\":\"\\u0936\\u093f\\u0915\\u094d\\u0937\\u0915\",\"newmessages\":\"\\u0928\\u090f \\u0938\\u0902\\u0926\\u0947\\u0936\",\"student\":\"\\u091b\\u093e\\u0924\\u094d\\u0930\",\"teacher\":\"\\u0936\\u093f\\u0915\\u094d\\u0937\\u0915\",\"leaderboard\":\"\\u0928\\u0947\\u0924\\u093e \\u092c\\u094b\\u0930\\u094d\\u0921\",\"NewsEvents\":\"\\u0938\\u092e\\u093e\\u091a\\u093e\\u0930 \\u090f\\u0935\\u0902 \\u0918\\u091f\\u0928\\u093e\\u0915\\u094d\\u0930\\u092e\",\"quicklinks\":\"\\u0924\\u094d\\u0935\\u0930\\u093f\\u0924 \\u0938\\u092e\\u094d\\u092a\\u0915\",\"AccountSettings\":\"\\u0905\\u0915\\u093e\\u0909\\u0902\\u091f \\u0938\\u0947\\u091f\\u093f\\u0902\\u0917\",\"ChgProfileData\":\"\\u092a\\u094d\\u0930\\u094b\\u092b\\u093c\\u093e\\u0907\\u0932 \\u0921\\u0947\\u091f\\u093e \\u092c\\u0926\\u0932\\u0947\\u0902\",\"FullName\":\"\\u092a\\u0942\\u0930\\u093e \\u0928\\u093e\\u092e\",\"Gender\":\"\\u0932\\u093f\\u0902\\u0917\",\"Birthday\":\"\\u091c\\u0928\\u094d\\u092e\\u0926\\u093f\\u0928\",\"mobileNo\":\"\\u092e\\u094b\\u092c\\u093e\\u0907\\u0932 \\u0928\\u0939\\u0940\\u0902 \\u0939\\u0948\",\"editProfile\":\"\\u092a\\u094d\\u0930\\u094b\\u092b\\u093c\\u093e\\u0907\\u0932 \\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0915\\u0930\\u0947\\u0902\",\"reemail\":\"\\u0908\\u092e\\u0947\\u0932 \\u090f\\u0921\\u094d\\u0930\\u0947\\u0938 \\u0915\\u094b \\u092a\\u0941\\u0928: \\u0932\\u093f\\u0916\\u0947\\u0902\",\"oldPassword\":\"\\u092a\\u0941\\u0930\\u093e\\u0928\\u093e \\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921\",\"editPassword\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921\",\"newPassword\":\"\\u0928\\u092f\\u093e \\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921\",\"editMailAddress\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0915\\u0930\\u0947\\u0902 \\u0908-\\u092e\\u0947\\u0932 \\u092a\\u0924\\u093e\",\"chgEmailAddress\":\"\\u0908\\u092e\\u0947\\u0932 \\u092a\\u0924\\u093e \\u092c\\u0926\\u0932\\u0947\\u0902\",\"Photo\":\"\\u0924\\u0938\\u094d\\u0935\\u0940\\u0930\",\"Address\":\"\\u092a\\u0924\\u093e\",\"Male\":\"\\u092a\\u0941\\u0930\\u0941\\u0937\",\"Female\":\"\\u0938\\u094d\\u0924\\u094d\\u0930\\u0940\",\"phoneNo\":\"\\u092b\\u094b\\u0928 \\u0928\",\"defLang\":\"\\u0921\\u093f\\u092b\\u093c\\u0949\\u0932\\u094d\\u091f \\u092d\\u093e\\u0937\\u093e\",\"email\":\"\\u0908\\u092e\\u0947\\u0932 \\u092a\\u0924\\u093e\",\"chgPassword\":\"\\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921 \\u092c\\u0926\\u0932\\u0947\\u0902\",\"renewPassword\":\"\\u0928\\u092f\\u093e \\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921 \\u0926\\u094b\\u092c\\u093e\\u0930\\u093e \\u091f\\u093e\\u0907\\u092a \\u0915\\u0930\\u0947\\u0902\",\"adminTasks\":\"\\u092a\\u094d\\u0930\\u0936\\u093e\\u0938\\u0928\\u093f\\u0915 \\u0915\\u093e\\u0930\\u094d\\u092f\",\"ClassSchedule\":\"\\u0935\\u0930\\u094d\\u0917 \\u0905\\u0928\\u0941\\u0938\\u0942\\u091a\\u0940\",\"Assignments\":\"\\u090f\\u0938\\u093e\\u0907\\u0928\\u092e\\u0947\\u0902\\u091f\",\"booksLibrary\":\"\\u092a\\u0941\\u0938\\u094d\\u0924\\u0915\\u0947\\u0902 \\u092a\\u0941\\u0938\\u094d\\u0924\\u0915\\u093e\\u0932\\u092f\",\"Attendance\":\"\\u0909\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f\",\"Onlineexams\":\"\\u0911\\u0928\\u0932\\u093e\\u0907\\u0928 \\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e\",\"media\":\"\\u092e\\u0940\\u0921\\u093f\\u092f\\u093e\",\"Payments\":\"\\u092d\\u0941\\u0917\\u0924\\u093e\\u0928\",\"Return\":\"\\u0930\\u093f\\u091f\\u0930\\u094d\\u0928\",\"Transport\":\"\\u091f\\u094d\\u0930\\u093e\\u0902\\u0938\\u092a\\u094b\\u0930\\u094d\\u091f\",\"Polls\":\"\\u092a\\u094b\\u0932\",\"votes\":\"\\u0926\\u0947\\u0916\\u0947\\u0902 \\u0935\\u094b\\u091f\",\"Calendar\":\"\\u0915\\u0947\\u0932\\u0947\\u0902\\u0921\\u0930\",\"Search\":\"\\u0938\\u0930\\u094d\\u091a\",\"username\":\"\\u092f\\u0942\\u091c\\u0930 \\u0915\\u093e \\u0928\\u093e\\u092e\",\"name\":\"\\u0928\\u093e\\u092e\",\"ID\":\"\\u0906\\u0908\\u0921\\u0940\",\"Operations\":\"\\u0938\\u0902\\u091a\\u093e\\u0932\\u0928\",\"cancelAdd\":\"\\u091c\\u094b\\u0921\\u093c \\u0930\\u0926\\u094d\\u0926\",\"Calender\":\"\\u0915\\u0947\\u0932\\u093f\\u0928\\u094d\\u0921\\u0930\",\"Status\":\"\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f\",\"toggleDropdown\":\"\\u091f\\u0949\\u0917\\u0932 \\u0921\\u094d\\u0930\\u093e\\u092a\\u0921\\u093e\\u0909\\u0928\",\"from\":\"\\u0938\\u0947\",\"Export\":\"\\u0928\\u093f\\u0930\\u094d\\u092f\\u093e\\u0924\",\"ExportCSV\":\"\\u0938\\u0940\\u090f\\u0938\\u0935\\u0940 \\u0928\\u093f\\u0930\\u094d\\u092f\\u093e\\u0924\",\"ImportCSV\":\"\\u0938\\u0940\\u090f\\u0938\\u0935\\u0940 \\u0938\\u0947 \\u0906\\u092f\\u093e\\u0924\",\"details\":\"\\u0935\\u093f\\u0935\\u0930\\u0923\",\"Active\":\"\\u0938\\u0915\\u094d\\u0930\\u093f\\u092f\",\"specifyFileToImport\":\"\\u0905\\u092a\\u0932\\u094b\\u0921 \\u0915\\u0930\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u092b\\u093c\\u093e\\u0907\\u0932 \\u0928\\u093f\\u0930\\u094d\\u0926\\u093f\\u0937\\u094d\\u091f \\u0915\\u0930\\u0947\\u0902\",\"Inactive\":\"\\u0928\\u093f\\u0937\\u094d\\u0915\\u094d\\u0930\\u093f\\u092f\",\"saveSettings\":\"\\u0938\\u092e\\u093e\\u092f\\u094b\\u091c\\u0928 \\u092c\\u091a\\u093e\\u0913\",\"available\":\"\\u092c\\u093f\\u0915\\u093e\\u090a\",\"Import\":\"\\u0906\\u092f\\u093e\\u0924\",\"ExportExcel\":\"\\u090f\\u0915\\u094d\\u0938\\u0947\\u0932 \\u092e\\u0947\\u0902 \\u0928\\u093f\\u0930\\u094d\\u092f\\u093e\\u0924 \\u0915\\u0930\\u0947\\u0902\",\"to\":\"\\u0915\\u094b\",\"for\":\"\\u0932\\u093f\\u090f\",\"all\":\"\\u0938\\u092d\\u0940\",\"Calenderlist\":\"\\u0915\\u0948\\u0932\\u0947\\u0902\\u0921\\u0930 \\u0938\\u0942\\u091a\\u0940\",\"cancelEdit\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0930\\u0926\\u094d\\u0926\",\"Edit\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924\",\"Remove\":\"\\u0939\\u091f\\u093e\",\"Download\":\"\\u0921\\u093e\\u0909\\u0928\\u0932\\u094b\\u0921\",\"Date\":\"\\u0926\\u093f\\u0928\\u093e\\u0902\\u0915\",\"Print\":\"\\u091b\\u093e\\u092a\",\"Comments\":\"\\u0915\\u092e\\u0947\\u0902\\u091f\\u094d\\u0938\",\"Extras\":\"\\u090f\\u0915\\u094d\\u0938\\u094d\\u091f\\u094d\\u0930\\u093e \\u0915\\u0932\\u093e\\u0915\\u093e\\u0930\",\"ExportPDF\":\"\\u092a\\u0940\\u0921\\u0940\\u090f\\u092b \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0928\\u093f\\u0930\\u094d\\u092f\\u093e\\u0924\",\"ImportExcel\":\"Excel \\u0938\\u0947 \\u0906\\u092f\\u093e\\u0924\",\"unavailable\":\"\\u0905\\u0928\\u0941\\u092a\\u0932\\u092c\\u094d\\u0927\",\"Description\":\"\\u0935\\u093f\\u0935\\u0930\\u0923\",\"dataImported\":\"\\u0921\\u093e\\u091f\\u093e \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0906\\u092f\\u093e\\u0924\",\"registerAcc\":\"registeration\",\"chkMailRestore\":\"\\u0932\\u093f\\u0902\\u0915 \\u092c\\u0939\\u093e\\u0932 \\u0915\\u0930\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0905\\u092a\\u0928\\u0947 \\u0908-\\u092e\\u0947\\u0932 \\u0915\\u0940 \\u091c\\u093e\\u0902\\u091a \\u0915\\u0930\\u0947\\u0902\",\"expRestoreId\":\"\\u0938\\u092e\\u092f \\u0938\\u0940\\u092e\\u093e \\u0938\\u092e\\u093e\\u092a\\u094d\\u0924 resore \\u0906\\u0908\\u0921\\u0940 (> 24), \\u0928\\u092f\\u093e \\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921 resore \\u0915\\u0943\\u092a\\u092f\\u093e \\u0905\\u0928\\u0941\\u0930\\u094b\\u0927 \\u0915\\u0930\\u0928\\u093e\",\"mustTypePwd\":\"\\u0924\\u094b \\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921 \\u091f\\u093e\\u0907\\u092a \\u0915\\u0930\\u0928\\u093e \\u0939\\u094b\\u0917\\u093e\",\"usernameUsed\":\"\\u092f\\u0942\\u091c\\u0930 \\u0915\\u093e \\u0928\\u093e\\u092e \\u092a\\u0939\\u0932\\u0947 \\u0938\\u0947 \\u0939\\u0940 \\u090f\\u0915 \\u0914\\u0930 \\u090f\\u0915 \\u0915\\u093e \\u0909\\u092a\\u092f\\u094b\\u0917, \\u092a\\u094d\\u0930\\u092f\\u094b\\u0917\",\"mailUsed\":\"\\u0908-\\u092e\\u0947\\u0932 \\u092a\\u0924\\u093e \\u092a\\u0939\\u0932\\u0947 \\u0938\\u0947 \\u0939\\u0940 \\u092f\\u0939 \\u091c\\u093e\\u0901\\u091a \\u0915\\u0930\\u0947\\u0902 \\u092f\\u093e \\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921 \\u0915\\u094b \\u092c\\u0939\\u093e\\u0932 \\u0915\\u0930\\u0928\\u0947, \\u0907\\u0938\\u094d\\u0924\\u0947\\u092e\\u093e\\u0932 \\u0915\\u093f\\u092f\\u093e\",\"mustTypeFullName\":\"\\u0906\\u092a \\u092a\\u0942\\u0930\\u093e \\u0928\\u093e\\u092e \\u0932\\u093f\\u0916\\u0928\\u093e \\u0906\\u0935\\u0936\\u094d\\u092f\\u0915 \\u0939\\u0948\",\"invRstoreId\":\"\\u0905\\u092e\\u093e\\u0928\\u094d\\u092f URL \\u092f\\u093e \\u0906\\u0908\\u0921\\u0940 \\u0915\\u094b \\u092c\\u0939\\u093e\\u0932 \\u0915\\u0930\\u0928\\u0947, \\u0928\\u092f\\u093e \\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921 resore \\u0915\\u0943\\u092a\\u092f\\u093e \\u0905\\u0928\\u0941\\u0930\\u094b\\u0927 \\u0915\\u0930\\u0928\\u093e\",\"chkInputFields\":\"\\u0907\\u0928\\u092a\\u0941\\u091f \\u0915\\u094d\\u0937\\u0947\\u0924\\u094d\\u0930\\u094b\\u0902 \\u0915\\u0940 \\u091c\\u093e\\u0902\\u091a \\u0915\\u0930\\u0947\\u0902\",\"chkUserPass\":\"\\u0905\\u092a\\u0928\\u0947 \\u0909\\u092a\\u092f\\u094b\\u0917\\u0915\\u0930\\u094d\\u0924\\u093e \\u0928\\u093e\\u092e \\u0914\\u0930 \\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921 \\u0915\\u0940 \\u091c\\u093e\\u0902\\u091a \\u0915\\u0930\\u0947\\u0902\",\"chkUserMail\":\"\\u0905\\u092a\\u0928\\u0947 \\u0909\\u092a\\u092f\\u094b\\u0917\\u0915\\u0930\\u094d\\u0924\\u093e \\u0928\\u093e\\u092e \\/ \\u0908-\\u092e\\u0947\\u0932 \\u0915\\u0940 \\u091c\\u093e\\u0902\\u091a \\u0915\\u0930\\u0947\\u0902\",\"pwdChangedSuccess\":\"\\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0926\\u0932 \\u0917\\u092f\\u093e \\u0939\\u0948, \\u092a\\u094d\\u0930\\u0947\\u0938 \\u0932\\u0949\\u0917\\u093f\\u0928 \\u091c\\u093e\\u0930\\u0940 \\u0930\\u0916\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f\",\"mustSelAccType\":\"\\u0906\\u092a \\u0916\\u093e\\u0924\\u093e \\u092a\\u094d\\u0930\\u0915\\u093e\\u0930 \\u0915\\u093e \\u091a\\u092f\\u0928 \\u0915\\u0930\\u0928\\u093e \\u0939\\u094b\\u0917\\u093e\",\"mustSelUsername\":\"\\u0906\\u092a \\u0909\\u092a\\u092f\\u094b\\u0917\\u0915\\u0930\\u094d\\u0924\\u093e \\u0928\\u093e\\u092e \\u0932\\u093f\\u0916\\u0928\\u093e \\u0906\\u0935\\u0936\\u094d\\u092f\\u0915 \\u0939\\u0948\",\"invEmailAdd\":\"\\u0905\\u092e\\u093e\\u0928\\u094d\\u092f \\u0908\\u092e\\u0947\\u0932 \\u092a\\u0924\\u093e\",\"notRepStCode\":\"\\u091b\\u093e\\u0924\\u094d\\u0930 \\u0915\\u094b\\u0921 \\u0915\\u093e \\u092a\\u094d\\u0930\\u0924\\u093f\\u0928\\u093f\\u0927\\u093f\\u0924\\u094d\\u0935 \\u0928\\u0939\\u0940\\u0902 \\u0915\\u0930 \\u0930\\u0939\\u093e \\u0939\\u0948\",\"Address2\":\"\\u092a\\u0924\\u093e \\u0926\\u094d\\u0935\\u093f\\u0924\\u0940\\u092f\",\"oldPwdDontMatch\":\"\\u092a\\u0941\\u0930\\u093e\\u0928\\u0947 \\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921 \\u090f\\u0915 \\u0938\\u0902\\u0917\\u094d\\u0930\\u0939\\u0940\\u0924 \\u092e\\u0947\\u0932 \\u0928\\u0939\\u0940\\u0902 \\u0916\\u093e\\u0924\\u0947\",\"mailAlreadyUsed\":\"\\u0908-\\u092e\\u0947\\u0932 \\u092a\\u0924\\u093e \\u092a\\u0939\\u0932\\u0947 \\u0938\\u0947 \\u0939\\u0940 \\u092f\\u0939 \\u091c\\u093e\\u0901\\u091a \\u0915\\u0930\\u0947\\u0902 \\u092f\\u093e \\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921 \\u0915\\u094b \\u092c\\u0939\\u093e\\u0932 \\u0915\\u0930\\u0928\\u0947, \\u0907\\u0938\\u094d\\u0924\\u0947\\u092e\\u093e\\u0932 \\u0915\\u093f\\u092f\\u093e\",\"allowLanguage\":\"\\u0909\\u092a\\u092f\\u094b\\u0917\\u0915\\u0930\\u094d\\u0924\\u093e\\u0913\\u0902 \\u092d\\u093e\\u0937\\u093e\\u0913\\u0902 \\u0915\\u094b \\u092c\\u0926\\u0932\\u0928\\u0947 \\u0915\\u0940 \\u0905\\u0928\\u0941\\u092e\\u0924\\u093f \\u0926\\u0947\\u0902\",\"sysMail\":\"\\u092a\\u094d\\u0930\\u0923\\u093e\\u0932\\u0940 \\u0908-\\u092e\\u0947\\u0932\",\"setZero\":\"\\u0915\\u094b\\u0908 \\u0928\\u0939\\u0940\\u0902 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0936\\u0942\\u0928\\u094d\\u092f \\u0915\\u0930\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0938\\u0947\\u091f\",\"subBased\":\"\\u0935\\u093f\\u0937\\u092f \\u0915\\u0947 \\u0906\\u0927\\u093e\\u0930\",\"None\":\"\\u0915\\u094b\\u0908 \\u0928\\u0939\\u0940\\u0902\",\"sendStudentsAbsendVia\":\"\\u0915\\u0947 \\u092e\\u093e\\u0927\\u094d\\u092f\\u092e \\u0938\\u0947 \\u091b\\u093e\\u0924\\u094d\\u0930 \\u0915\\u0940 \\u0905\\u0928\\u0941\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f \\u092d\\u0947\\u091c\\u0947\\u0902\",\"schoolTerms\":\"\\u0938\\u094d\\u0915\\u0942\\u0932 \\u0915\\u0940 \\u0936\\u0930\\u094d\\u0924\\u0947\\u0902\",\"generalSettings\":\"\\u0938\\u093e\\u092e\\u093e\\u0928\\u094d\\u092f \\u0938\\u0947\\u091f\\u093f\\u0902\\u0917\\u094d\\u0938\",\"allowed\":\"\\u0915\\u0940 \\u0905\\u0928\\u0941\\u092e\\u0924\\u093f \\u0926\\u0940\",\"paymentMail\":\"\\u092a\\u0947\\u092a\\u0948\\u0932 \\u092d\\u0941\\u0917\\u0924\\u093e\\u0928 \\u0908-\\u092e\\u0947\\u0932\",\"footer\":\"\\u092a\\u093e\\u0926 \\u0915\\u0949\\u092a\\u0940\\u0930\\u093e\\u0907\\u091f\",\"classBased\":\"\\u0915\\u0915\\u094d\\u0937\\u093e \\u0915\\u0947\\u0935\\u0932\",\"sendExamDet\":\"\\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0935\\u093f\\u0935\\u0930\\u0923 \\u092d\\u0947\\u091c\\u0947\\u0902\",\"activatedModules\":\"\\u0938\\u0915\\u094d\\u0930\\u093f\\u092f \\u092e\\u0949\\u0921\\u094d\\u092f\\u0942\\u0932\",\"siteTitle\":\"\\u0918\\u091f\\u0928\\u093e\\u0938\\u094d\\u0925\\u0932 \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915\",\"notAllowed\":\"\\u0905\\u0928\\u0941\\u092e\\u0924\\u093f \\u0928\\u0939\\u0940\\u0902\",\"payTax\":\"\\u092d\\u0941\\u0917\\u0924\\u093e\\u0928 \\u091f\\u0948\\u0915\\u094d\\u0938\",\"attendanceModel\":\"\\u0909\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f \\u092e\\u0949\\u0921\\u0932\",\"examNotif\":\"\\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0938\\u0942\\u091a\\u0928\\u093e\\u0913\\u0902 \\u0915\\u093e \\u0935\\u093f\\u0935\\u0930\\u0923\",\"studentsParents\":\"\\u091b\\u093e\\u0924\\u094d\\u0930\\u094b\\u0902 \\u0914\\u0930 \\u092e\\u093e\\u0924\\u093e-\\u092a\\u093f\\u0924\\u093e\",\"editSettings\":\"\\u0935\\u093f\\u0928\\u094d\\u092f\\u093e\\u0938 \\u092c\\u0926\\u0932\\u0947\\u0902\",\"Administrators\":\"\\u0935\\u094d\\u092f\\u0935\\u0938\\u094d\\u0925\\u093e\\u092a\\u0915\\u094b\\u0902\",\"listAdministrators\":\"\\u0938\\u0942\\u091a\\u0940 \\u092a\\u094d\\u0930\\u0936\\u093e\\u0938\\u0915\\u094b\\u0902\",\"password\":\"\\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921\",\"adminUpdated\":\"\\u0935\\u094d\\u092f\\u0935\\u0938\\u094d\\u0925\\u093e\\u092a\\u0915 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0905\\u0926\\u094d\\u092f\\u0924\\u0928\",\"usernameAlreadyUsed\":\"\\u092f\\u0942\\u091c\\u0930 \\u0915\\u093e \\u0928\\u093e\\u092e \\u092a\\u0939\\u0932\\u0947 \\u0938\\u0947 \\u0939\\u0940 \\u090f\\u0915 \\u0914\\u0930 \\u090f\\u0915 \\u0915\\u093e \\u0909\\u092a\\u092f\\u094b\\u0917, \\u092a\\u094d\\u0930\\u092f\\u094b\\u0917\",\"adminFullName\":\"\\u0935\\u094d\\u092f\\u0935\\u0938\\u094d\\u0925\\u093e\\u092a\\u0915 \\u092a\\u0942\\u0930\\u093e \\u0928\\u093e\\u092e\",\"addAdministrator\":\"admininstrator \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"editAdministrator\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 admininstrator\",\"emailAlreadyUsed\":\"\\u0908-\\u092e\\u0947\\u0932 \\u092a\\u0924\\u093e \\u092a\\u0939\\u0932\\u0947 \\u0938\\u0947 \\u0939\\u0940 \\u092f\\u0939 \\u091c\\u093e\\u0901\\u091a \\u0915\\u0930\\u0947\\u0902 \\u092f\\u093e \\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921 \\u0915\\u094b \\u092c\\u0939\\u093e\\u0932 \\u0915\\u0930\\u0928\\u0947, \\u0907\\u0938\\u094d\\u0924\\u0947\\u092e\\u093e\\u0932 \\u0915\\u093f\\u092f\\u093e\",\"AssignmentTitle\":\"\\u0905\\u0938\\u093e\\u0907\\u0928\\u092e\\u0947\\u0902\\u091f \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915\",\"noAssignments\":\"\\u0915\\u094b\\u0908 \\u0905\\u0938\\u093e\\u0907\\u0928\\u092e\\u0947\\u0902\\u091f\",\"assignmentCreated\":\"\\u0905\\u0938\\u093e\\u0907\\u0928\\u092e\\u0947\\u0902\\u091f \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"AddAssignments\":\"\\u0905\\u0938\\u093e\\u0907\\u0928\\u092e\\u0947\\u0902\\u091f \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"AssignmentDescription\":\"\\u0905\\u0938\\u093e\\u0907\\u0928\\u092e\\u0947\\u0902\\u091f \\u0935\\u093f\\u0935\\u0930\\u0923\",\"AssignmentFile\":\"\\u0905\\u0938\\u093e\\u0907\\u0928\\u092e\\u0947\\u0902\\u091f \\u092b\\u093c\\u093e\\u0907\\u0932\",\"assignmentModified\":\"\\u0905\\u0938\\u093e\\u0907\\u0928\\u092e\\u0947\\u0902\\u091f \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0938\\u0902\\u0936\\u094b\\u0927\\u093f\\u0924\",\"listAssignments\":\"\\u0938\\u0942\\u091a\\u0940 \\u090f\\u0938\\u093e\\u0907\\u0928\\u092e\\u0947\\u0902\\u091f\",\"AssignmentDeadline\":\"\\u0905\\u0938\\u093e\\u0907\\u0928\\u092e\\u0947\\u0902\\u091f \\u0938\\u092e\\u092f \\u0938\\u0940\\u092e\\u093e\",\"editAssignment\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0905\\u0938\\u093e\\u0907\\u0928\\u092e\\u0947\\u0902\\u091f\",\"selectAttendance\":\"\\u091c\\u094b\\u0921\\u093c\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0909\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f \\u091c\\u093e\\u0928\\u0915\\u093e\\u0930\\u0940 \\u0915\\u093e \\u091a\\u092f\\u0928 \\u0915\\u0930\\u0947\\u0902\",\"Present\":\"\\u0935\\u0930\\u094d\\u0924\\u092e\\u093e\\u0928\",\"LateExecuse\":\"\\u092c\\u0939\\u093e\\u0928\\u093e \\u0915\\u0947 \\u0938\\u093e\\u0925 \\u0938\\u094d\\u0935\\u0930\\u094d\\u0917\\u0940\\u092f\",\"attendanceStats\":\"\\u0909\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f \\u0938\\u093e\\u0902\\u0916\\u094d\\u092f\\u093f\\u0915\\u0940\",\"attendanceFilters\":\"\\u0909\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0916\\u094b\\u091c (\\u092b\\u093f\\u0932\\u094d\\u091f\\u0930 \\u0915\\u093e \\u091a\\u092f\\u0928 \\u0915\\u0930\\u0947\\u0902)\",\"absentReport\":\"\\u091b\\u093e\\u0924\\u094d\\u0930 \\u0905\\u0928\\u0941\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f \\u0915\\u0940 \\u0930\\u093f\\u092a\\u094b\\u0930\\u094d\\u091f\",\"controlAttendance\":\"\\u0928\\u093f\\u092f\\u0902\\u0924\\u094d\\u0930\\u0923 \\u0909\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f\",\"Absent\":\"\\u0905\\u0928\\u0941\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\",\"earlyDismissal\":\"\\u091c\\u0932\\u094d\\u0926\\u0940 \\u0928\\u093f\\u092a\\u091f\\u093e\\u0930\\u093e\",\"attendancePerDay\":\"\\u0926\\u093f\\u0928 \\u092a\\u094d\\u0930\\u0924\\u093f \\u0909\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f\",\"attendanceSearch\":\"\\u0916\\u094b\\u091c \\u0909\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f\",\"studentName\":\"\\u091b\\u093e\\u0924\\u094d\\u0930 \\u0915\\u093e \\u0928\\u093e\\u092e\",\"Late\":\"\\u0926\\u0947\\u0930\",\"saveAttendance\":\"\\u0938\\u0939\\u0947\\u091c\\u0947\\u0902 \\u0909\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f\",\"attendanceToday\":\"\\u0909\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f \\u0906\\u091c\",\"attendanceSaved\":\"Attecndance \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u091a\\u093e\\u092f\\u093e\",\"class\":\"\\u0915\\u094d\\u0932\\u093e\\u0938\",\"addClass\":\"\\u0935\\u0930\\u094d\\u0917 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"classTeacher\":\"\\u0915\\u0915\\u094d\\u0937\\u093e \\u0905\\u0927\\u094d\\u092f\\u093e\\u092a\\u0915\",\"className\":\"\\u0915\\u0915\\u094d\\u0937\\u093e \\u0915\\u093e \\u0928\\u093e\\u092e\",\"listClasses\":\"\\u0938\\u0942\\u091a\\u0940 \\u0915\\u0915\\u094d\\u0937\\u093e\\u090f\\u0902\",\"classDorm\":\"\\u0915\\u0915\\u094d\\u0937\\u093e \\u091b\\u093e\\u0924\\u094d\\u0930\\u093e\\u0935\\u093e\\u0938\",\"classSch\":\"\\u0936\\u0948\\u0915\\u094d\\u0937\\u0923\\u093f\\u0915 \\u0905\\u0928\\u0941\\u0938\\u0942\\u091a\\u0940\",\"editClassSch\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0935\\u0930\\u094d\\u0917 \\u0905\\u0928\\u0941\\u0938\\u0942\\u091a\\u0940\",\"endTime\":\"\\u0905\\u0902\\u0924\\u093f\\u092e \\u0938\\u092e\\u092f\",\"Sunday\":\"\\u0930\\u0935\\u093f\\u0935\\u093e\\u0930\",\"Wednesday\":\"\\u092c\\u0941\\u0927\\u0935\\u093e\\u0930\",\"Saturday\":\"\\u0936\\u0928\\u093f\\u0935\\u093e\\u0930\",\"NoClasses\":\"\\u0915\\u094b\\u0908 \\u0915\\u0915\\u094d\\u0937\\u093e \\u0928\\u0939\\u0940\\u0902\",\"classEditSch\":\"\\u0905\\u0928\\u0941\\u0938\\u0942\\u091a\\u0940 \\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0915\\u0930\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0935\\u0930\\u094d\\u0917 \\u0915\\u093e \\u091a\\u092f\\u0928 \\u0915\\u0930\\u0947\\u0902\",\"Day\":\"\\u0926\\u093f\\u0928\",\"addSch\":\"\\u0905\\u0928\\u0941\\u0938\\u0942\\u091a\\u0940 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"Monday\":\"\\u0938\\u094b\\u092e\\u0935\\u093e\\u0930\",\"Thurusday\":\"Thurusday\",\"classCreated\":\"\\u0915\\u0915\\u094d\\u0937\\u093e \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"editClass\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0915\\u094d\\u0932\\u093e\\u0938\",\"ReadSchedule\":\"\\u0905\\u0928\\u0941\\u0938\\u0942\\u091a\\u0940 \\u092a\\u0922\\u093c\\u0947\\u0902\",\"startTime\":\"\\u0938\\u092e\\u092f \\u0936\\u0941\\u0930\\u0942\",\"editSch\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0905\\u0928\\u0941\\u0938\\u0942\\u091a\\u0940\",\"Tuesday\":\"\\u092e\\u0902\\u0917\\u0932\\u0935\\u093e\\u0930\",\"Friday\":\"\\u0936\\u0941\\u0915\\u094d\\u0930\\u0935\\u093e\\u0930\",\"classUpdated\":\"\\u0915\\u0915\\u094d\\u0937\\u093e \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0905\\u0926\\u094d\\u092f\\u0924\\u0928\",\"Dormitories\":\"\\u0936\\u092f\\u0928\\u0917\\u0943\\u0939\",\"DormName\":\"\\u0936\\u092f\\u0928\\u0917\\u0943\\u0939 \\u0928\\u093e\\u092e\",\"addDorm\":\"\\u091b\\u093e\\u0924\\u094d\\u0930\\u093e\\u0935\\u093e\\u0938 \\u092e\\u0947\\u0902 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"dormUpdated\":\"\\u0936\\u092f\\u0928\\u0917\\u0943\\u0939 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0905\\u0926\\u094d\\u092f\\u0924\\u0928\",\"addDormitories\":\"\\u091b\\u093e\\u0924\\u094d\\u0930\\u093e\\u0935\\u093e\\u0938 \\u092e\\u0947\\u0902 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"DormDesc\":\"\\u0936\\u092f\\u0928\\u0917\\u0943\\u0939 \\u0935\\u093f\\u0935\\u0930\\u0923\",\"editDorm\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0936\\u092f\\u0928\\u0917\\u0943\\u0939\",\"listDormitories\":\"\\u0938\\u0942\\u091a\\u0940 \\u0936\\u092f\\u0928\\u0917\\u0943\\u0939\",\"noDorm\":\"\\u0915\\u094b\\u0908 \\u0936\\u092f\\u0928\\u0917\\u0943\\u0939\",\"dormCreated\":\"\\u0936\\u092f\\u0928\\u0917\\u0943\\u0939 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"listNews\":\"\\u0938\\u0942\\u091a\\u0940 \\u0916\\u092c\\u0930\",\"newsContent\":\"\\u0938\\u092e\\u093e\\u091a\\u093e\\u0930 \\u0938\\u093e\\u092e\\u0917\\u094d\\u0930\\u0940\",\"listEvents\":\"\\u0938\\u0942\\u091a\\u0940 \\u0915\\u0940 \\u0918\\u091f\\u0928\\u093e\\u0913\\u0902\",\"noEvents\":\"\\u0915\\u094b\\u0908 \\u0906\\u092f\\u094b\\u091c\\u0928 \\u0928\\u0939\\u0940\\u0902\",\"eventPlace\":\"\\u0918\\u091f\\u0928\\u093e \\u091c\\u0917\\u0939\",\"eventModified\":\"\\u0918\\u091f\\u0928\\u093e \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0938\\u0902\\u0936\\u094b\\u0927\\u093f\\u0924\",\"newsCreated\":\"\\u0938\\u092e\\u093e\\u091a\\u093e\\u0930 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"editEvent\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0918\\u091f\\u0928\\u093e\",\"addEvent\":\"\\u0915\\u093e\\u0930\\u094d\\u092f\\u0915\\u094d\\u0930\\u092e \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"eventNamePlace\":\"\\u0918\\u091f\\u0928\\u093e \\u0928\\u093e\\u092e \\/ \\u092a\\u094d\\u0932\\u0947\\u0938\",\"noNews\":\"\\u0915\\u094b\\u0908 \\u0916\\u092c\\u0930 \\u0928\\u0939\\u0940\\u0902\",\"addNews\":\"\\u0938\\u092e\\u093e\\u091a\\u093e\\u0930 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"newsboard\":\"\\u0938\\u092e\\u093e\\u091a\\u093e\\u0930 \\u092c\\u094b\\u0930\\u094d\\u0921\",\"events\":\"\\u0906\\u092f\\u094b\\u091c\\u0928\",\"newsTitle\":\"\\u0938\\u092e\\u093e\\u091a\\u093e\\u0930 \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915\",\"editNews\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0938\\u092e\\u093e\\u091a\\u093e\\u0930\",\"eventDescription\":\"\\u0918\\u091f\\u0928\\u093e \\u0935\\u093f\\u0935\\u0930\\u0923\",\"eventTitle\":\"\\u0915\\u093e\\u0930\\u094d\\u092f\\u0915\\u094d\\u0930\\u092e \\u0915\\u093e \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915\",\"eventCreated\":\"\\u0918\\u091f\\u0928\\u093e \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"newsModified\":\"\\u0938\\u092e\\u093e\\u091a\\u093e\\u0930 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0938\\u0902\\u0936\\u094b\\u0927\\u093f\\u0924\",\"examsList\":\"\\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0938\\u0942\\u091a\\u0940\",\"examName\":\"\\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0915\\u093e \\u0928\\u093e\\u092e\",\"mark\":\"\\u0928\\u093f\\u0936\\u093e\\u0928\",\"selClassSubExam\":\"\\u092a\\u094d\\u0930\\u0935\\u0930 \\u0935\\u0930\\u094d\\u0917 \\u0914\\u0930 \\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0935\\u093f\\u0937\\u092f\",\"attendanceMakrs\":\"\\u0909\\u092a\\u0938\\u094d\\u0925\\u093f\\u0924\\u093f \\u092e\\u093e\\u0930\\u094d\\u0915\\u094d\\u0938\",\"gradeLevels\":\"\\u0917\\u094d\\u0930\\u0947\\u0921 \\u0915\\u0947 \\u0938\\u094d\\u0924\\u0930\",\"gradeName\":\"\\u0917\\u094d\\u0930\\u0947\\u0921 \\u0928\\u093e\\u092e\",\"noGrades\":\"\\u0915\\u094b\\u0908 \\u0917\\u094d\\u0930\\u0947\\u0921\",\"editGrade\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0917\\u094d\\u0930\\u0947\\u0921\",\"onlineExams\":\"\\u0911\\u0928\\u0932\\u093e\\u0907\\u0928 \\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e\",\"examDeadline\":\"\\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0915\\u0940 \\u0938\\u092e\\u092f \\u0938\\u0940\\u092e\\u093e\",\"gradeCreated\":\"\\u0917\\u094d\\u0930\\u0947\\u0921 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"gradeFrom\":\"\\u0938\\u0947 \\u0917\\u094d\\u0930\\u0947\\u0921\",\"gradeDesc\":\"\\u0917\\u094d\\u0930\\u0947\\u0921 \\u0935\\u093f\\u0935\\u0930\\u0923\",\"addLevel\":\"\\u0917\\u094d\\u0930\\u0947\\u0921 \\u0938\\u094d\\u0924\\u0930 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"examMarks\":\"\\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u092e\\u093e\\u0930\\u094d\\u0915\\u094d\\u0938\",\"addMarks\":\"\\u0928\\u093f\\u0936\\u093e\\u0928 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"sendExamMarks\":\"\\u0928\\u093f\\u0936\\u093e\\u0928 \\u0938\\u0942\\u091a\\u0928\\u093e\\u090f\\u0902 \\u092d\\u0947\\u091c\\u0947\\u0902\",\"examDesc\":\"\\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0935\\u093f\\u0935\\u0930\\u0923\",\"addExam\":\"\\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u092e\\u0947\\u0902 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"listExams\":\"\\u0938\\u0942\\u091a\\u0940 \\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e\",\"showMarks\":\"\\u0936\\u094b \\u0915\\u0947 \\u0928\\u093f\\u0936\\u093e\\u0928\",\"noExams\":\"\\u0915\\u094b\\u0908 \\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e\",\"controlMarksExam\":\"\\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0928\\u093f\\u092f\\u0902\\u0924\\u094d\\u0930\\u0923 \\u0915\\u0947 \\u0928\\u093f\\u0936\\u093e\\u0928\",\"addUpdateMarks\":\"\\/ \\u0905\\u092a\\u0921\\u0947\\u091f \\u092e\\u093e\\u0930\\u094d\\u0915\\u094d\\u0938 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"listMarks\":\"\\u0938\\u0942\\u091a\\u0940 \\u0917\\u094d\\u0930\\u0947\\u0921\",\"gradePoint\":\"\\u0917\\u094d\\u0930\\u0947\\u0921 \\u092c\\u093f\\u0902\\u0926\\u0941\",\"gradeTo\":\"\\u0917\\u094d\\u0930\\u0947\\u0921 \\u0915\\u0947 \\u0932\\u093f\\u090f\",\"gradeUpdated\":\"\\u0917\\u094d\\u0930\\u0947\\u0921 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0905\\u0926\\u094d\\u092f\\u0924\\u0928\",\"takeExam\":\"\\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0932\\u0947\\u0902\",\"showExamGradesAfter\":\"\\u0916\\u0924\\u094d\\u092e \\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0915\\u0947 \\u092c\\u093e\\u0926 \\u0917\\u094d\\u0930\\u0947\\u0921 \\u0926\\u093f\\u0916\\u093e\\u090f\\u0901\",\"Answers\":\"\\u091c\\u0935\\u093e\\u092c\",\"infoBox\":\"\\u091c\\u093e\\u0928\\u0915\\u093e\\u0930\\u0940 \\u092c\\u0949\\u0915\\u094d\\u0938\",\"Grade\":\"\\u0917\\u094d\\u0930\\u0947\\u0921\",\"examModified\":\"\\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0915\\u094b \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0938\\u0902\\u0936\\u094b\\u0927\\u093f\\u0924\",\"examNotSent\":\"\\u0938\\u0942\\u091a\\u0928\\u093e\\u090f\\u0902 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092d\\u0947\\u091c\\u093e\",\"examCreated\":\"\\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"examDetailsNot\":\"\\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0938\\u0942\\u091a\\u0928\\u093e\\u0913\\u0902 \\u0915\\u093e \\u0935\\u093f\\u0935\\u0930\\u0923\",\"AveragePoints\":\"\\u0914\\u0938\\u0924 \\u0905\\u0902\\u0915\",\"editExam\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e\",\"trueAns\":\"\\u0938\\u0939\\u0940 \\u091c\\u0935\\u093e\\u092c\",\"Questions\":\"\\u092a\\u094d\\u0930\\u0936\\u094d\\u0928\",\"Question\":\"\\u0938\\u0935\\u093e\\u0932\",\"addQuestion\":\"\\u092a\\u094d\\u0930\\u0936\\u094d\\u0928 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"submitAnswers\":\"\\u0909\\u0924\\u094d\\u0924\\u0930 \\u091c\\u092e\\u093e \\u0915\\u0930\\u0947\\u0902\",\"adjustExamNot\":\"\\u0938\\u093e\\u092e\\u093e\\u0928\\u094d\\u092f \\u0938\\u0947\\u091f\\u093f\\u0902\\u0917\\u094d\\u0938 \\u0938\\u0947 \\u092a\\u0939\\u0932\\u0947 \\u092a\\u0930\\u0940\\u0915\\u094d\\u0937\\u093e \\u0938\\u0942\\u091a\\u0928\\u093e\\u090f\\u0902 \\u0938\\u092e\\u093e\\u092f\\u094b\\u091c\\u093f\\u0924 \\u0915\\u0930\\u0947\\u0902\",\"Languages\":\"\\u092d\\u093e\\u0937\\u093e\\u090f\\u0901\",\"noLanguage\":\"\\u0915\\u094b\\u0908 \\u092d\\u093e\\u0937\\u093e\",\"languagePhrases\":\"\\u092d\\u093e\\u0937\\u093e \\u0935\\u093e\\u0915\\u094d\\u092f\\u093e\\u0902\\u0936\\u094b\\u0902\",\"langModified\":\"\\u092d\\u093e\\u0937\\u093e \\u0915\\u093e \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0905\\u0926\\u094d\\u092f\\u0924\\u0928\",\"editLanguage\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0932\\u0948\\u0902\\u0917\\u094d\\u0935\\u0947\\u091c\",\"addLanguage\":\"\\u092d\\u093e\\u0937\\u093e \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"listLanguage\":\"\\u0938\\u0942\\u091a\\u0940 \\u092d\\u093e\\u0937\\u093e\\u0913\\u0902\",\"languageName\":\"\\u092d\\u093e\\u0937\\u093e \\u0915\\u093e \\u0928\\u093e\\u092e\",\"langCreated\":\"\\u092d\\u093e\\u0937\\u093e \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"Library\":\"\\u092a\\u0941\\u0938\\u094d\\u0924\\u0915\\u093e\\u0932\\u092f\",\"bookTitle\":\"\\u092a\\u0941\\u0938\\u094d\\u0924\\u0915 \\u0915\\u093e \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915\",\"noBooks\":\"\\u0915\\u094b\\u0908 \\u0915\\u093f\\u0924\\u093e\\u092c\\u0947\\u0902\",\"bookType\":\"\\u092a\\u0941\\u0938\\u094d\\u0924\\u0915 \\u0915\\u0947 \\u092a\\u094d\\u0930\\u0915\\u093e\\u0930\",\"bookPrice\":\"\\u092a\\u0941\\u0938\\u094d\\u0924\\u0915 \\u0915\\u0940 \\u0915\\u0940\\u092e\\u0924\",\"editBook\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u092a\\u0941\\u0938\\u094d\\u0924\\u0915\",\"bookAdded\":\"\\u092a\\u0941\\u0938\\u094d\\u0924\\u0915 \\u0915\\u094b \\u0938\\u092b\\u0932\\u0924\\u093e \\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u091c\\u094b\\u0921\\u093c\",\"uploadBook\":\"\\u0905\\u092a\\u0932\\u094b\\u0921 \\u092a\\u0941\\u0938\\u094d\\u0924\\u0915\",\"traditionalBook\":\"\\u092a\\u093e\\u0930\\u0902\\u092a\\u0930\\u093f\\u0915 \\u092a\\u0941\\u0938\\u094d\\u0924\\u0915\",\"addBook\":\"\\u092a\\u0941\\u0938\\u094d\\u0924\\u0915 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"bookAuthor\":\"\\u092a\\u0941\\u0938\\u094d\\u0924\\u0915 \\u0915\\u0947 \\u0932\\u0947\\u0916\\u0915\",\"listBooks\":\"\\u0938\\u0942\\u091a\\u0940 \\u092a\\u0941\\u0938\\u094d\\u0924\\u0915\\u0947\\u0902\",\"bookPriceState\":\"\\u092a\\u0941\\u0938\\u094d\\u0924\\u0915 \\u0915\\u0940 \\u0915\\u0940\\u092e\\u0924 \\/ \\u0930\\u093e\\u091c\\u094d\\u092f\",\"bookDescription\":\"\\u092a\\u0941\\u0938\\u094d\\u0924\\u0915 \\u0935\\u093f\\u0935\\u0930\\u0923\",\"electronicBook\":\"\\u0907\\u0932\\u0947\\u0915\\u094d\\u091f\\u094d\\u0930\\u0949\\u0928\\u093f\\u0915 \\u092a\\u0941\\u0938\\u094d\\u0924\\u0915\",\"State\":\"\\u0930\\u093e\\u091c\\u094d\\u092f\",\"bookModified\":\"\\u092a\\u0941\\u0938\\u094d\\u0924\\u0915 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0938\\u0902\\u0936\\u094b\\u0927\\u093f\\u0924\",\"mailsms\":\"\\u092e\\u0947\\u0932 \\/ \\u090f\\u0938\\u090f\\u092e\\u090f\\u0938\",\"mailsmsSettings\":\"\\u092e\\u0947\\u0932 \\/ \\u090f\\u0938\\u090f\\u092e\\u090f\\u0938 \\u0938\\u0947\\u091f\\u093f\\u0902\\u0917\\u094d\\u0938\",\"sendAs\":\"\\u0907\\u0938 \\u0930\\u0942\\u092a \\u092e\\u0947\\u0902 \\u092d\\u0947\\u091c\\u0947\\u0902\",\"mailSMSSend\":\"\\u092e\\u0947\\u0932 \\/ \\u090f\\u0938\\u090f\\u092e\\u090f\\u0938 \\u092d\\u0947\\u091c\\u0947\\u0902\",\"Sender\":\"\\u092a\\u094d\\u0930\\u0947\\u0937\\u0915\",\"smsProvider\":\"\\u090f\\u0938\\u090f\\u092e\\u090f\\u0938 \\u092a\\u094d\\u0930\\u0926\\u093e\\u0924\\u093e\",\"mailsmsTemplates\":\"\\u092e\\u0947\\u0932 \\/ \\u090f\\u0938\\u090f\\u092e\\u090f\\u0938 \\u091f\\u0947\\u092e\\u094d\\u092a\\u0932\\u0947\\u091f\",\"noTemplates\":\"\\u0915\\u094b\\u0908 \\u091f\\u0947\\u092e\\u094d\\u092a\\u0932\\u0947\\u091f\\u094d\\u0938\",\"mailTemplate\":\"\\u092e\\u0947\\u0932 \\u091f\\u0947\\u092e\\u094d\\u092a\\u0932\\u0947\\u091f\",\"smsTemplate\":\"\\u090f\\u0938\\u090f\\u092e\\u090f\\u0938 \\u091f\\u0947\\u092e\\u094d\\u092a\\u0932\\u0947\\u091f\",\"editTemplate\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u091f\\u0947\\u092e\\u094d\\u092a\\u0932\\u0947\\u091f\",\"listTemplates\":\"\\u0938\\u0942\\u091a\\u0940 \\u091f\\u0947\\u092e\\u094d\\u092a\\u0932\\u0947\\u091f\\u094d\\u0938\",\"mailSettings\":\"\\u092e\\u0947\\u0932 \\u0938\\u0947\\u091f\\u093f\\u0902\\u0917\\u094d\\u0938\",\"noMessages\":\"\\u0915\\u094b\\u0908 \\u0938\\u0902\\u0926\\u0947\\u0936 \\u0928\\u0939\\u0940\\u0902\",\"listMessages\":\"\\u0938\\u0942\\u091a\\u0940 \\u0938\\u0902\\u0926\\u0947\\u0936\",\"messageTitle\":\"\\u0938\\u0902\\u0926\\u0947\\u0936 \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915\",\"selUsers\":\"\\u0909\\u092a\\u092d\\u094b\\u0915\\u094d\\u0924\\u093e\\u0913\\u0902 \\u0915\\u093e \\u091a\\u092f\\u0928 \\u0915\\u0930\\u0947\\u0902\",\"sms\":\"\\u090f\\u0938\\u090f\\u092e\\u090f\\u0938\",\"listSentMessages\":\"\\u092d\\u0947\\u091c\\u0947 \\u0917\\u090f \\u0938\\u0902\\u0926\\u0947\\u0936\\u094b\\u0902 \\u0915\\u0940 \\u0938\\u0942\\u091a\\u0940\",\"typeUsers\":\"\\u0909\\u092a\\u092f\\u094b\\u0917\\u0915\\u0930\\u094d\\u0924\\u093e\\u0913\\u0902 \\u0915\\u0947 \\u092a\\u094d\\u0930\\u0915\\u093e\\u0930\",\"messageContent\":\"\\u0938\\u0902\\u0926\\u0947\\u0936 \\u0915\\u0940 \\u0938\\u093e\\u092e\\u0917\\u094d\\u0930\\u0940\",\"typeDate\":\"\\u091f\\u093e\\u0907\\u092a \\/ \\u0926\\u093f\\u0928\\u093e\\u0902\\u0915\",\"smsSettings\":\"SMS \\u0938\\u0947\\u091f\\u093f\\u0902\\u0917\",\"mailDeliverType\":\"\\u092e\\u0947\\u0932 \\u0921\\u093f\\u0932\\u093f\\u0935\\u0930\\u0940 \\u092a\\u094d\\u0930\\u0915\\u093e\\u0930\",\"templateTitle\":\"\\u091f\\u0947\\u092e\\u094d\\u092a\\u0932\\u0947\\u091f \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915\",\"templateVars\":\"\\u0916\\u093e\\u0915\\u093e \\u091a\\u0930\",\"templateUpdated\":\"\\u0916\\u093e\\u0915\\u093e \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0905\\u0926\\u094d\\u092f\\u0924\\u0928\",\"mediaCenter\":\"\\u092e\\u0940\\u0921\\u093f\\u092f\\u093e \\u0915\\u0947\\u0902\\u0926\\u094d\\u0930\",\"addAlbum\":\"\\u090f\\u0932\\u094d\\u092c\\u092e \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"noMediaInAlbum\":\"\\u0915\\u094b\\u0908 \\u092e\\u0940\\u0921\\u093f\\u092f\\u093e \\u0907\\u0938 \\u090f\\u0932\\u094d\\u092c\\u092e \\u092e\\u0947\\u0902 \\u092e\\u094c\\u091c\\u0942\\u0926\",\"albumImage\":\"\\u090f\\u0932\\u094d\\u092c\\u092e \\u091b\\u0935\\u093f\",\"mediaTitle\":\"\\u092e\\u0940\\u0921\\u093f\\u092f\\u093e \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915\",\"editMedia\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u092e\\u0940\\u0921\\u093f\\u092f\\u093e\",\"mediaCreated\":\"\\u092e\\u0940\\u0921\\u093f\\u092f\\u093e \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"mediaModified\":\"\\u092e\\u0940\\u0921\\u093f\\u092f\\u093e \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0938\\u0902\\u0936\\u094b\\u0927\\u093f\\u0924\",\"albumCreated\":\"\\u090f\\u0932\\u094d\\u092c\\u092e \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"mediaDesc\":\"\\u092e\\u0940\\u0921\\u093f\\u092f\\u093e \\u0935\\u093f\\u0935\\u0930\\u0923\",\"editAlbum\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u090f\\u0932\\u092c\\u092e\",\"albumTitle\":\"\\u090f\\u0932\\u094d\\u092c\\u092e \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915\",\"albums\":\"\\u090f\\u0932\\u094d\\u092c\\u092e\",\"goUp\":\"\\u0905\\u092a \\u0915\\u0930\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u091c\\u093e\\u0913\",\"uploadMedia\":\"\\u0905\\u092a\\u0932\\u094b\\u0921 \\u092e\\u0940\\u0921\\u093f\\u092f\\u093e\",\"albumDesc\":\"\\u090f\\u0932\\u094d\\u092c\\u092e \\u0935\\u093f\\u0935\\u0930\\u0923\",\"addMedia\":\"\\u092e\\u0940\\u0921\\u093f\\u092f\\u093e \\u091c\\u094b\\u0921\\u093c\\u094b\",\"mediaImage\":\"\\u092e\\u0940\\u0921\\u093f\\u092f\\u093e \\u0915\\u0940 \\u091b\\u0935\\u093f\",\"albumModified\":\"\\u090f\\u0932\\u094d\\u092c\\u092e \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0938\\u0902\\u0936\\u094b\\u0927\\u093f\\u0924\",\"Messages\":\"\\u0938\\u0902\\u0926\\u0947\\u0936\",\"composeMessage\":\"\\u0938\\u0902\\u0926\\u0947\\u0936 \\u0932\\u093f\\u0916\\u0947\\u0902\",\"typeReply\":\"\\u092a\\u094d\\u0930\\u0915\\u093e\\u0930 \\u0909\\u0924\\u094d\\u0924\\u0930 \\u0915\\u0947 (\\u092a\\u094d\\u0930\\u0947\\u0938 \\u092a\\u094d\\u0930\\u0938\\u094d\\u0924\\u0941\\u0924 \\u0915\\u0930\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u092a\\u094d\\u0930\\u0935\\u0947\\u0936) ...\",\"message\":\"\\u0938\\u0902\\u0926\\u0947\\u0936\",\"messageNotExist\":\"\\u0906\\u092a \\u092e\\u094c\\u091c\\u0942\\u0926 \\u0928\\u0939\\u0940\\u0902 \\u092a\\u0939\\u0941\\u0901\\u091a\\u0928\\u0947 \\u0915\\u0940 \\u0915\\u094b\\u0936\\u093f\\u0936 \\u0938\\u0902\\u0926\\u0947\\u0936\",\"userisntExist\":\"\\u092a\\u094d\\u0930\\u092f\\u094b\\u0915\\u094d\\u0924\\u093e \\u092e\\u094c\\u091c\\u0942\\u0926 \\u0928\\u0939\\u0940\\u0902 \\u0939\\u0948\",\"sendMessage\":\"\\u092e\\u0947\\u0938\\u0947\\u091c \\u092d\\u0947\\u091c\\u0947\\u0902\",\"markRead\":\"\\u092a\\u0922\\u093c\\u0947 \\u0939\\u0941\\u090f \\u0915\\u093e \\u091a\\u093f\\u0939\\u094d\\u0928\",\"markUnread\":\"\\u0905\\u092a\\u0920\\u093f\\u0924 \\u0915\\u0947 \\u0930\\u0942\\u092a \\u092e\\u0947\\u0902 \\u091a\\u093f\\u0939\\u094d\\u0928\\u093f\\u0924 \\u0915\\u0930\\u0947\\u0902\",\"loadOldMessages\":\"\\u092a\\u0941\\u0930\\u093e\\u0928\\u0947 \\u0938\\u0902\\u0926\\u0947\\u0936\\u094b\\u0902 \\u0932\\u094b\\u0921\",\"sendMessageTo\":\"\\u0915\\u0930\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0938\\u0902\\u0926\\u0947\\u0936 \\u092d\\u0947\\u091c\\u0947\\u0902 (\\u0909\\u092a\\u092f\\u094b\\u0917\\u0915\\u0930\\u094d\\u0924\\u093e \\u0928\\u093e\\u092e)\",\"readMessage\":\"\\u0938\\u0902\\u0926\\u0947\\u0936 \\u092a\\u0922\\u093c\\u0928\\u093e\",\"paymentTitleDate\":\"\\u092d\\u0941\\u0917\\u0924\\u093e\\u0928 \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915 \\/ \\u0926\\u093f\\u0928\\u093e\\u0902\\u0915\",\"paid\":\"\\u0936\\u094d\\u0930\\u0926\\u094d\\u0927\\u093e\\u0902\\u091c\\u0932\\u093f\",\"noPayments\":\"\\u0915\\u094b\\u0908 \\u092d\\u0941\\u0917\\u0924\\u093e\\u0928\",\"editPayment\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0915\\u0930\\u0947\\u0902 \\u092d\\u0941\\u0917\\u0924\\u093e\\u0928\",\"AmountDue\":\"\\u0926\\u0947\\u092f \\u0930\\u093e\\u0936\\u093f\",\"paymentCreated\":\"\\u092d\\u0941\\u0917\\u0924\\u093e\\u0928 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"noPaymentDetails\":\"\\u0915\\u094b\\u0908 \\u092d\\u0941\\u0917\\u0924\\u093e\\u0928 \\u0935\\u093f\\u0935\\u0930\\u0923 \\u092e\\u094c\\u091c\\u0942\\u0926\",\"paymentModified\":\"\\u092d\\u0941\\u0917\\u0924\\u093e\\u0928 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0938\\u0902\\u0936\\u094b\\u0927\\u093f\\u0924\",\"Total\":\"\\u091f\\u094b\\u091f\\u0932\",\"Product\":\"\\u0909\\u0924\\u094d\\u092a\\u093e\\u0926\",\"paymentTitle\":\"\\u092d\\u0941\\u0917\\u0924\\u093e\\u0928 \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915\",\"unpaid\":\"\\u0905\\u0935\\u0948\\u0924\\u0928\\u093f\\u0915\",\"paymentDesc\":\"\\u092d\\u0941\\u0917\\u0924\\u093e\\u0928 \\u0915\\u093e \\u0935\\u093f\\u0935\\u0930\\u0923\",\"addPayment\":\"\\u092d\\u0941\\u0917\\u0924\\u093e\\u0928 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"listPayments\":\"\\u0938\\u0942\\u091a\\u0940 \\u092d\\u0941\\u0917\\u0924\\u093e\\u0928\",\"Amount\":\"\\u0930\\u093e\\u0936\\u093f\",\"viewInvoice\":\"\\u091a\\u093e\\u0932\\u093e\\u0928 \\u0926\\u0947\\u0916\\u0947\\u0902\",\"paymentSelectMultiple\":\"\\u0915\\u0908 \\u091b\\u093e\\u0924\\u094d\\u0930\\u094b\\u0902 \\u0915\\u093e \\u091a\\u092f\\u0928 \\u0939\\u0930 \\u090f\\u0915 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0905\\u0932\\u0917 \\u0938\\u0947 \\u091a\\u093e\\u0932\\u093e\\u0928 \\u0909\\u0924\\u094d\\u092a\\u0928\\u094d\\u0928 \\u0939\\u094b\\u0917\\u093e\",\"Subtotal\":\"\\u0909\\u092a-\\u092f\\u094b\\u0917\",\"listPaymentDetail\":\"\\u0938\\u0942\\u091a\\u0940 \\u092d\\u0941\\u0917\\u0924\\u093e\\u0928 \\u0915\\u0940 \\u091c\\u093e\\u0928\\u0915\\u093e\\u0930\\u0940\",\"paymentDetails\":\"\\u092d\\u0941\\u0917\\u0924\\u093e\\u0928 \\u0935\\u093f\\u0935\\u0930\\u0923\",\"pollTitle\":\"\\u092a\\u094b\\u0932 \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915\",\"noPolls\":\"\\u0915\\u094b\\u0908 \\u091a\\u0941\\u0928\\u093e\\u0935\",\"editPoll\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0938\\u0930\\u094d\\u0935\\u0947\\u0915\\u094d\\u0937\\u0923\",\"pollCreated\":\"\\u092a\\u094b\\u0932 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"pollUpdated\":\"\\u092a\\u094b\\u0932 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0905\\u0926\\u094d\\u092f\\u0924\\u0928\",\"activatePoll\":\"\\u0938\\u0915\\u094d\\u0930\\u093f\\u092f \\u092a\\u094b\\u0932\",\"votePoll\":\"\\u0935\\u094b\\u091f \\u0938\\u0930\\u094d\\u0935\\u0947\\u0915\\u094d\\u0937\\u0923\",\"pollOptions\":\"\\u092a\\u094b\\u0932 \\u0935\\u093f\\u0915\\u0932\\u094d\\u092a\",\"pollTarget\":\"\\u092a\\u094b\\u0932 \\u0932\\u0915\\u094d\\u0937\\u094d\\u092f\",\"addPoll\":\"\\u0938\\u0930\\u094d\\u0935\\u0947\\u0915\\u094d\\u0937\\u0923 \\u092e\\u0947\\u0902 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"listPolls\":\"\\u0938\\u0942\\u091a\\u0940 \\u091a\\u0941\\u0928\\u093e\\u0935\\u094b\\u0902\",\"pollStatus\":\"\\u092a\\u094b\\u0932 \\u0915\\u0940 \\u0938\\u094d\\u0925\\u093f\\u0924\\u093f\",\"newOption\":\"\\u0928\\u0908 \\u0935\\u093f\\u0915\\u0932\\u094d\\u092a\",\"alreadyvoted\":\"\\u0906\\u092a \\u092a\\u0939\\u0932\\u0947 \\u0938\\u0947 \\u0939\\u0940 \\u0938\\u0947 \\u092a\\u0939\\u0932\\u0947 \\u092e\\u0924\\u0926\\u093e\\u0928 \\u0915\\u093f\\u092f\\u093e\",\"pollActivated\":\"\\u092a\\u094b\\u0932 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0938\\u0915\\u094d\\u0930\\u093f\\u092f\",\"staticPages\":\"\\u0938\\u094d\\u0925\\u0948\\u0924\\u093f\\u0915 \\u092a\\u0943\\u0937\\u094d\\u0920\\u094b\\u0902\",\"listPages\":\"\\u0938\\u0942\\u091a\\u0940 \\u092a\\u0943\\u0937\\u094d\\u0920\\u094b\\u0902\",\"editPage\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u092a\\u0947\\u091c\",\"pageModified\":\"\\u092a\\u0947\\u091c \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0938\\u0902\\u0936\\u094b\\u0927\\u093f\\u0924\",\"controlPages\":\"\\u0928\\u093f\\u092f\\u0902\\u0924\\u094d\\u0930\\u0923 \\u092a\\u0928\\u094d\\u0928\\u0947\",\"pageTitle\":\"\\u092a\\u0943\\u0937\\u094d\\u0920 \\u0915\\u093e \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915\",\"activeInactivePage\":\"\\u0938\\u0915\\u094d\\u0930\\u093f\\u092f \\/ \\u0928\\u093f\\u0937\\u094d\\u0915\\u094d\\u0930\\u093f\\u092f \\u092a\\u0943\\u0937\\u094d\\u0920\",\"pageChanged\":\"\\u092a\\u0943\\u0937\\u094d\\u0920 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0926\\u0932\\u093e\",\"addPage\":\"\\u092a\\u0943\\u0937\\u094d\\u0920 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"pageContent\":\"\\u092a\\u0943\\u0937\\u094d\\u0920 \\u0938\\u093e\\u092e\\u0917\\u094d\\u0930\\u0940\",\"pageCreated\":\"\\u092a\\u0943\\u0937\\u094d\\u0920 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"Subjects\":\"\\u0935\\u093f\\u0937\\u092f\\u094b\\u0902\",\"subjectName\":\"\\u0935\\u093f\\u0937\\u092f \\u0928\\u093e\\u092e\",\"subjectCreated\":\"\\u0935\\u093f\\u0937\\u092f \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"Subject\":\"\\u0935\\u093f\\u0937\\u092f\",\"noSubjects\":\"\\u0915\\u094b\\u0908 \\u0935\\u093f\\u0937\\u092f\\u094b\\u0902\",\"subjectEdited\":\"\\u0935\\u093f\\u0937\\u092f \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924\",\"addSubject\":\"\\u0935\\u093f\\u0937\\u092f \\u091c\\u094b\\u0921\\u093c\\u0928\\u0947\",\"editSubject\":\"\\u0935\\u093f\\u0937\\u092f \\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0915\\u0930\\u0947\\u0902\",\"Transportation\":\"\\u092a\\u0930\\u093f\\u0935\\u0939\\u0928\",\"transportTitle\":\"\\u092a\\u0930\\u093f\\u0935\\u0939\\u0928 \\u0936\\u0940\\u0930\\u094d\\u0937\\u0915\",\"Fare\":\"\\u0915\\u093f\\u0930\\u093e\\u092f\\u093e\",\"editTransport\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u092a\\u0930\\u093f\\u0935\\u0939\\u0928\",\"transportCreated\":\"\\u092a\\u0930\\u093f\\u0935\\u0939\\u0928 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"addTransport\":\"\\u092a\\u0930\\u093f\\u0935\\u0939\\u0928 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"transportDesc\":\"\\u092a\\u0930\\u093f\\u0935\\u0939\\u0928 \\u0935\\u093f\\u0935\\u0930\\u0923\",\"listSubs\":\"\\u0917\\u094d\\u0930\\u093e\\u0939\\u0915\\u094b\\u0902 \\u0915\\u0940 \\u0938\\u0942\\u091a\\u0940\",\"Contact\":\"\\u0938\\u0902\\u092a\\u0930\\u094d\\u0915\",\"transportUpdated\":\"\\u092a\\u0930\\u093f\\u0935\\u0939\\u0928 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0905\\u0926\\u094d\\u092f\\u0924\\u0928\",\"listTransport\":\"\\u0938\\u0942\\u091a\\u0940 \\u092a\\u0930\\u093f\\u0935\\u0939\\u0928\",\"driverContact\":\"\\u091a\\u093e\\u0932\\u0915 \\u0938\\u0902\\u092a\\u0930\\u094d\\u0915\",\"noTransportation\":\"\\u0915\\u094b\\u0908 \\u0922\\u0941\\u0932\\u093e\\u0908\",\"noMatches\":\"\\u0915\\u094b\\u0908 \\u092e\\u0947\\u0932 \\u0928\\u0939\\u0940\\u0902\",\"parents\":\"\\u092e\\u093e\\u0924\\u093e \\u092a\\u093f\\u0924\\u093e\",\"role\":\"\\u092d\\u0942\\u092e\\u093f\\u0915\\u093e\",\"listTeachers\":\"\\u0938\\u0942\\u091a\\u0940 \\u0936\\u093f\\u0915\\u094d\\u0937\\u0915\\u094b\\u0902\",\"EditTeacher\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0915\\u0930\\u0947\\u0902 \\u0936\\u093f\\u0915\\u094d\\u0937\\u0915\",\"rollid\":\"\\u0930\\u094b\\u0932 \\u0906\\u0908\\u0921\\u0940\",\"listParents\":\"\\u0938\\u0942\\u091a\\u0940 \\u092e\\u093e\\u0924\\u093e-\\u092a\\u093f\\u0924\\u093e\",\"studentDetails\":\"\\u091b\\u093e\\u0924\\u094d\\u0930 \\u0935\\u093f\\u0935\\u0930\\u0923\",\"parent\":\"\\u092e\\u093e\\u0924\\u093e-\\u092a\\u093f\\u0924\\u093e\",\"addTeacher\":\"\\u0936\\u093f\\u0915\\u094d\\u0937\\u0915 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"noTeachers\":\"\\u0915\\u094b\\u0908 \\u0936\\u093f\\u0915\\u094d\\u0937\\u0915\",\"fileToImport\":\"\\u0906\\u092f\\u093e\\u0924 \\u0915\\u0930\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u092b\\u093c\\u093e\\u0907\\u0932\",\"Marksheet\":\"\\u0905\\u0902\\u0915 \\u0924\\u093e\\u0932\\u093f\\u0915\\u093e\",\"editStudent\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u0915\\u0930\\u0947\\u0902 \\u091b\\u093e\\u0924\\u094d\\u0930\",\"noParents\":\"\\u0915\\u094b\\u0908 \\u092e\\u093e\\u0924\\u093e-\\u092a\\u093f\\u0924\\u093e\",\"Relation\":\"\\u0938\\u0902\\u092c\\u093e\\u0926\",\"editParent\":\"\\u0938\\u0902\\u092a\\u093e\\u0926\\u093f\\u0924 \\u091c\\u0928\\u0915\",\"Profession\":\"\\u0935\\u094d\\u092f\\u0935\\u0938\\u093e\\u092f\",\"AddParent\":\"\\u092e\\u093e\\u0924\\u093e-\\u092a\\u093f\\u0924\\u093e \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"noStudents\":\"\\u0915\\u094b\\u0908 \\u091b\\u093e\\u0924\\u094d\\u0930\",\"addStudent\":\"\\u091b\\u093e\\u0924\\u094d\\u0930 \\u091c\\u094b\\u0921\\u093c\\u0947\\u0902\",\"Approve\":\"\\u092e\\u0902\\u091c\\u0942\\u0930\",\"waitingApproval\":\"\\u0905\\u0928\\u0941\\u092e\\u094b\\u0926\\u0928 \\u0915\\u0940 \\u092a\\u094d\\u0930\\u0924\\u0940\\u0915\\u094d\\u0937\\u093e\",\"csvParentInvalid\":\"\\u0907\\u0938 \\u092b\\u093c\\u093e\\u0907\\u0932 \\u092e\\u0947\\u0902 \\u0938\\u0940\\u090f\\u0938\\u0935\\u0940 \\u092e\\u093e\\u0924\\u093e-\\u092a\\u093f\\u0924\\u093e \\u092b\\u093c\\u093e\\u0907\\u0932 \\u0915\\u093e \\u092a\\u094d\\u0930\\u0924\\u093f\\u0928\\u093f\\u0927\\u093f\\u0924\\u094d\\u0935 \\u0928\\u0939\\u0940\\u0902\",\"Profile\":\"\\u092a\\u094d\\u0930\\u094b\\u092b\\u093c\\u093e\\u0907\\u0932\",\"teacherInfo\":\"\\u091f\\u0940\\u091a\\u0930 \\u0938\\u0942\\u091a\\u0928\\u093e\",\"studentHaveNoMarks\":\"\\u091b\\u093e\\u0924\\u094d\\u0930 \\u0905\\u092c \\u0924\\u0915 \\u0915\\u094b\\u0908 \\u0928\\u093f\\u0936\\u093e\\u0928 \\u0939\\u0948\",\"teacherCreated\":\"\\u091f\\u0940\\u091a\\u0930 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"teacherUpdated\":\"\\u091f\\u0940\\u091a\\u0930 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0905\\u0926\\u094d\\u092f\\u0924\\u0928\",\"studentModified\":\"\\u091b\\u093e\\u0924\\u094d\\u0930 \\u0915\\u094b \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0938\\u0902\\u0936\\u094b\\u0927\\u093f\\u0924\",\"csvStudentInvalid\":\"\\u0907\\u0938 \\u092b\\u093c\\u093e\\u0907\\u0932 \\u092e\\u0947\\u0902 \\u0938\\u0940\\u090f\\u0938\\u0935\\u0940 \\u091b\\u093e\\u0924\\u094d\\u0930 \\u092b\\u093c\\u093e\\u0907\\u0932 \\u0915\\u093e \\u092a\\u094d\\u0930\\u0924\\u093f\\u0928\\u093f\\u0927\\u093f\\u0924\\u094d\\u0935 \\u0928\\u0939\\u0940\\u0902\",\"parentInfo\":\"\\u091c\\u0928\\u0915 \\u0938\\u0942\\u091a\\u0928\\u093e\",\"parentCreated\":\"\\u091c\\u0928\\u0915 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"csvTeacherInvalid\":\"\\u0907\\u0938 \\u092b\\u093c\\u093e\\u0907\\u0932 \\u092e\\u0947\\u0902 \\u0938\\u0940\\u090f\\u0938\\u0935\\u0940 \\u0936\\u093f\\u0915\\u094d\\u0937\\u0915 \\u092b\\u093c\\u093e\\u0907\\u0932 \\u0915\\u093e \\u092a\\u094d\\u0930\\u0924\\u093f\\u0928\\u093f\\u0927\\u093f\\u0924\\u094d\\u0935 \\u0928\\u0939\\u0940\\u0902\",\"studentCreatedSuccess\":\"\\u091b\\u093e\\u0924\\u094d\\u0930 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u092c\\u0928\\u093e\\u092f\\u093e\",\"studentInfo\":\"\\u091b\\u093e\\u0924\\u094d\\u0930 \\u091c\\u093e\\u0928\\u0915\\u093e\\u0930\\u0940\",\"parentModified\":\"\\u091c\\u0928\\u0915 \\u0938\\u092b\\u0932\\u0924\\u093e\\u092a\\u0942\\u0930\\u094d\\u0935\\u0915 \\u0938\\u0902\\u0936\\u094b\\u0927\\u093f\\u0924\",\"listStudents\":\"\\u0938\\u0942\\u091a\\u0940 \\u0915\\u0947 \\u091b\\u093e\\u0924\\u094d\\u0930\\u094b\\u0902\",\"latestVersion\":\"\\u0928\\u0935\\u0940\\u0928\\u0924\\u092e \\u0938\\u0902\\u0938\\u094d\\u0915\\u0930\\u0923\",\"logout\":\"\\u0932\\u0949\\u0917 \\u0906\\u0909\\u091f\",\"registerNewAccount\":\"\\u090f\\u0915 \\u0928\\u0908 \\u0938\\u0926\\u0938\\u094d\\u092f\\u0924\\u093e \\u0930\\u091c\\u093f\\u0938\\u094d\\u091f\\u0930\",\"restorePwd\":\"\\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921 \\u092a\\u0941\\u0928\\u0930\\u094d\\u0938\\u094d\\u0925\\u093e\\u092a\\u093f\\u0924\",\"userNameOrEmail\":\"\\u092a\\u094d\\u0930\\u092f\\u094b\\u0915\\u094d\\u0924\\u093e \\u0928\\u093e\\u092e \\/ \\u0908-\\u092e\\u0947\\u0932\",\"rememberMe\":\"\\u092e\\u0941\\u091d\\u0947 \\u092f\\u093e\\u0926 \\u0915\\u0930\\u094b\",\"youfindStId\":\"\\u0906\\u092a \\u092f\\u0939 \\u0915\\u0948\\u0938\\u0947 \\u0926\\u093f\\u0916\\u0924\\u0947 \\u0939\\u0948\\u0902, \\u0905\\u092a\\u0928\\u0947 \\u091b\\u093e\\u0924\\u094d\\u0930 \\u0921\\u0948\\u0936\\u092c\\u094b\\u0930\\u094d\\u0921 \\u092e\\u0941\\u0916\\u094d\\u092f \\u092a\\u0943\\u0937\\u094d\\u0920 \\u092e\\u0947\\u0902 \\u091b\\u093e\\u0924\\u094d\\u0930 \\u0915\\u094b\\u0921 \\u092e\\u093f\\u0932\\u0947\\u0917\\u093e:\",\"parntStudentIdSep\":\"\\u091c\\u0928\\u0915 \\u0915\\u0947 \\u091b\\u093e\\u0924\\u094d\\u0930\\u094b\\u0902 \\u0906\\u0908\\u0921\\u0940 - \\u0905\\u0932\\u0917,\",\"thankReg\":\"\\u0930\\u091c\\u093f\\u0938\\u094d\\u091f\\u0930 \\u0915\\u0930\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0927\\u0928\\u094d\\u092f\\u0935\\u093e\\u0926, \\u0906\\u0908\\u0921\\u0940 \\u0915\\u0947 \\u0938\\u093e\\u0925 \\u0905\\u092a\\u0928\\u0947 \\u0916\\u093e\\u0924\\u0947 \\u0915\\u094b \\u0938\\u0915\\u094d\\u0930\\u093f\\u092f \\u0915\\u0930\\u0928\\u0947 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u0938\\u094d\\u0915\\u0942\\u0932 \\u0938\\u0947 \\u0938\\u0902\\u092a\\u0930\\u094d\\u0915 \\u0915\\u0930\\u0947\\u0902 \\u0915\\u0943\\u092a\\u092f\\u093e\",\"signIn\":\"\\u0938\\u093e\\u0907\\u0928 \\u0907\\u0928 \\u0915\\u0930\\u0947\\u0902\",\"resetPwdNow\":\"\\u0905\\u092c \\u092a\\u093e\\u0938\\u0935\\u0930\\u094d\\u0921 \\u0930\\u0940\\u0938\\u0947\\u091f\",\"printPage\":\"\\u0907\\u0938 \\u092a\\u0943\\u0937\\u094d\\u0920 \\u0915\\u093e \\u092e\\u0941\\u0926\\u094d\\u0930\\u0923 \\u0915\\u0940\\u091c\\u093f\\u090f\",\"loginToAccount\":\"\\u0905\\u092a\\u0928\\u0947 \\u0916\\u093e\\u0924\\u0947 \\u092e\\u0947\\u0902 \\u092a\\u094d\\u0930\\u0935\\u0947\\u0936 \\u0915\\u0930\\u0947\\u0902\",\"theme\":\"\\u0935\\u093f\\u0937\\u092f\",\"blue\":\"\\u092c\\u094d\\u0932\\u0942\",\"black\":\"\\u0915\\u093e\\u0932\\u093e\",\"idNumber\":\"\\u0906\\u0908\\u0921\\u0940 \\u0928\\u0902\\u092c\\u0930\",\"position\":\"ltr\",\"direction\":\"\\u0926\\u093f\\u0936\\u093e\",\"rtl\":\"\\u0926\\u093e\\u090f\\u0902 \\u0938\\u0947 \\u092c\\u093e\\u090f\\u0902\",\"ltr\":\"\\u092c\\u093e\\u090f\\u0902 \\u0938\\u0947 \\u0926\\u093e\\u090f\\u0902\",\"Promotion\":\"\\u092a\\u0926\\u094b\\u0928\\u094d\\u0928\\u0924\\u093f\",\"promoteStudents\":\"\\u091b\\u093e\\u0924\\u094d\\u0930\\u094b\\u0902 \\u0915\\u094b \\u092c\\u0922\\u093c\\u093e\\u0935\\u093e \\u0926\\u0947\\u0928\\u093e\",\"studentsToBPronoted\":\"\\u091b\\u093e\\u0924\\u094d\\u0930\\u094b\\u0902 \\u0915\\u094b \\u092c\\u0922\\u093c\\u093e\\u0935\\u093e \\u0926\\u093f\\u092f\\u093e \\u091c\\u093e\\u090f\\u0917\\u093e\",\"studentsPromotedClass\":\"\\u091b\\u093e\\u0924\\u094d\\u0930 \\u0935\\u0930\\u094d\\u0917 \\u0915\\u0947 \\u0932\\u093f\\u090f \\u092a\\u094d\\u0930\\u094b\\u0924\\u094d\\u0938\\u093e\\u0939\\u093f\\u0924 \\u0915\\u093f\\u092f\\u093e \\u091c\\u093e\\u090f\\u0917\\u093e\"}');

-- --------------------------------------------------------

--
-- Table structure for table `mailsms`
--

CREATE TABLE `mailsms` (
  `id` int(250) NOT NULL,
  `mailTo` varchar(250) NOT NULL,
  `mailType` varchar(250) NOT NULL,
  `messageData` text NOT NULL,
  `messageDate` varchar(250) NOT NULL,
  `messageSender` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mailsmstemplates`
--

CREATE TABLE `mailsmstemplates` (
  `id` int(250) NOT NULL,
  `templateTitle` varchar(250) NOT NULL,
  `templateMail` text NOT NULL,
  `templateSMS` text NOT NULL,
  `templateVars` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mailsmstemplates`
--

INSERT INTO `mailsmstemplates` (`id`, `templateTitle`, `templateMail`, `templateSMS`, `templateVars`) VALUES
(1, 'Exam Details', '<p>Dear {studentName},</p>\n\n<p>the following table contain the marks of exam : {examTitle} started on {examDate}</p>\n\n<p>{examGradesTable}</p>\n\n<p>Best Regards,</p>\n\n<p>{schoolTitle}</p>\n', 'Dear {studentName}, exam {examTitle} marks : {examGradesTable}', '{studentName},{studentRoll},{studentEmail},{studentUsername},{examGradesTable},{examTitle},{examDescription},{examDate},{schoolTitle}'),
(2, 'Student Absent', '<p>Dear {parentName},</p>\n\n<p>The student {studentName} is absent Today with status : {absentStatus}</p>\n\n<p>Absense date : {absentDate}</p>\n\n<p>Best Regards,</p>\n\n<p>{schoolTitle}</p>\n', 'Dear {parentName}, The student {studentName} is absent Today with status : {absentStatus}', '{studentName},{studentRoll},{studentEmail},{studentUsername},{parentName},{parentEmail},{parentEmail},{absentDate},{absentStatus},{schoolTitle}');

-- --------------------------------------------------------

--
-- Table structure for table `mediaalbums`
--

CREATE TABLE `mediaalbums` (
  `id` int(250) NOT NULL,
  `albumTitle` varchar(250) CHARACTER SET utf8 NOT NULL,
  `albumDescription` text CHARACTER SET utf8 NOT NULL,
  `albumImage` varchar(250) CHARACTER SET utf8 NOT NULL,
  `albumParent` int(250) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mediaitems`
--

CREATE TABLE `mediaitems` (
  `id` int(250) NOT NULL,
  `albumId` int(250) NOT NULL DEFAULT 0,
  `mediaURL` varchar(250) CHARACTER SET utf8 NOT NULL,
  `mediaTitle` varchar(250) CHARACTER SET utf8 NOT NULL,
  `mediaDescription` text CHARACTER SET utf8 NOT NULL,
  `mediaDate` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(250) NOT NULL,
  `messageId` int(250) NOT NULL,
  `userId` int(250) NOT NULL,
  `fromId` int(250) NOT NULL,
  `toId` int(250) NOT NULL,
  `messageText` text DEFAULT NULL,
  `dateSent` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `messageId`, `userId`, `fromId`, `toId`, `messageText`, `dateSent`) VALUES
(2, 2, 4, 1, 4, 'HGDFKHAGFHAGF', '1526488047'),
(3, 3, 2, 2, 6, 'hi', '1526836089'),
(4, 4, 6, 2, 6, 'hi', '1526836090'),
(5, 3, 2, 2, 6, 'your leave is granted', '1541163493'),
(6, 3, 6, 2, 6, 'your leave is granted', '1541163493'),
(7, 5, 2, 2, 30, 'Please submit your application intime', '1541165240'),
(8, 6, 30, 2, 30, 'Please submit your application intime', '1541165240'),
(9, 6, 30, 30, 2, 'Your Company 123 Your Street Your City, ST 12345 (123) 456-7890 no_reply@example.com September 04, 20XX Ms. Ronny Reader 123 Address St  Anytown, ST 12345 Dear Ms. Reader, Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Best regards,    Your Name CEO, Your Company', '1541165347'),
(10, 6, 2, 30, 2, 'Your Company 123 Your Street Your City, ST 12345 (123) 456-7890 no_reply@example.com September 04, 20XX Ms. Ronny Reader 123 Address St  Anytown, ST 12345 Dear Ms. Reader, Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Best regards,    Your Name CEO, Your Company', '1541165347'),
(11, 5, 2, 2, 30, 'your leve is aproved', '1541344397'),
(12, 5, 30, 2, 30, 'your leve is aproved', '1541344397'),
(13, 7, 33, 33, 2, 'hello sir', '1543732310'),
(14, 8, 2, 33, 2, 'hello sir', '1543732310'),
(16, 1, 4, 1, 4, NULL, '1549696400'),
(18, 1, 4, 1, 4, 'wwqwq', '1549696403'),
(20, 1, 4, 1, 4, NULL, '1549696734');

-- --------------------------------------------------------

--
-- Table structure for table `messageslist`
--

CREATE TABLE `messageslist` (
  `id` int(250) NOT NULL,
  `userId` int(250) NOT NULL,
  `toId` int(250) NOT NULL,
  `lastMessage` varchar(250) NOT NULL,
  `lastMessageDate` varchar(250) NOT NULL,
  `messageStatus` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messageslist`
--

INSERT INTO `messageslist` (`id`, `userId`, `toId`, `lastMessage`, `lastMessageDate`, `messageStatus`) VALUES
(2, 4, 1, 'wwqwq', '1549696403', 1),
(3, 2, 6, 'your leave is granted', '1541163493', 0),
(4, 6, 2, 'your leave is granted', '1541163493', 1),
(5, 2, 30, 'your leve is aproved', '1541344397', 0),
(6, 30, 2, 'your leve is aproved', '1541344397', 1),
(7, 33, 2, 'hello sir', '1543732310', 0),
(8, 2, 33, 'hello sir', '1543732310', 0);

-- --------------------------------------------------------

--
-- Table structure for table `newsboard`
--

CREATE TABLE `newsboard` (
  `id` int(250) NOT NULL,
  `newsTitle` varchar(250) NOT NULL,
  `newsText` text NOT NULL,
  `newsFor` varchar(250) NOT NULL,
  `newsDate` int(250) NOT NULL,
  `creationDate` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `newsboard`
--

INSERT INTO `newsboard` (`id`, `newsTitle`, `newsText`, `newsFor`, `newsDate`, `creationDate`) VALUES
(1, 'Avishkar 2018', 'Avishkar can be organize at college. 5his is a college level event', 'student', 1525132800, 1526836444),
(3, 'Attendance', 'Display', 'teacher', 1540771200, 1540918548),
(4, 'Karmatech  Event 2019', 'All Departments event', 'student', 1550880000, 1550894596);

-- --------------------------------------------------------

--
-- Table structure for table `onlineexams`
--

CREATE TABLE `onlineexams` (
  `id` int(250) NOT NULL,
  `examTitle` varchar(250) NOT NULL,
  `examDescription` text DEFAULT NULL,
  `examClass` varchar(250) NOT NULL,
  `examTeacher` int(250) NOT NULL,
  `examSubject` int(250) NOT NULL,
  `examDate` varchar(250) NOT NULL,
  `ExamEndDate` varchar(250) NOT NULL,
  `ExamShowGrade` int(1) NOT NULL DEFAULT 0,
  `examQuestion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `onlineexams`
--

INSERT INTO `onlineexams` (`id`, `examTitle`, `examDescription`, `examClass`, `examTeacher`, `examSubject`, `examDate`, `ExamEndDate`, `ExamShowGrade`, `examQuestion`) VALUES
(5, 'Online test1', 'Each and every question for 1Mark', '[\"7\",\"8\",\"10\",\"11\"]', 1, 22, '1549065600', '1549065600', 0, '[]'),
(6, 'C test', 'Each question  for 1Mark', '[\"9\",\"10\",\"11\"]', 1, 22, '1550916000', '1550880000', 0, '[{\"title\":\"What  is  (void*)0\",\"ans1\":\"Represention of NULL Pointer\",\"ans2\":\"Represention of void pointer\",\"ans3\":\"Error\",\"ans4\":\"None of  above\"},{\"title\":\"In which header file is the NULL macro defined\",\"ans1\":\"studio.h\",\"ans2\":\"Stdef.h\",\"ans3\":\"studio.h and studded.h\",\"ans4\":\"math.h\",\"Tans\":\"\"},{\"title\":\"A Pointer is\",\"ans1\":\"A keyword used to create  variables\",\"ans2\":\"A variable that stores address of an instruction\",\"ans3\":\"A variable  that stores address of other  variables\",\"ans4\":\"All of  the  above\",\"Tans\":\"\"},{\"title\":\"The operator  used to get value at address  stored in a pointer variable  is\",\"ans1\":\"*\",\"ans2\":\"&\",\"ans3\":\"&&\",\"ans4\":\"\\/\\/\",\"Tans\":\"\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `onlineexamsgrades`
--

CREATE TABLE `onlineexamsgrades` (
  `id` int(250) NOT NULL,
  `examId` int(250) NOT NULL,
  `studentId` int(250) NOT NULL,
  `examQuestionsAnswers` text NOT NULL,
  `examGrade` int(250) NOT NULL,
  `examDate` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(250) NOT NULL,
  `paymentTitle` varchar(250) NOT NULL,
  `paymentDescription` text NOT NULL,
  `paymentStudent` int(250) NOT NULL,
  `paymentAmount` float NOT NULL,
  `paymentStatus` int(1) NOT NULL,
  `paymentDate` varchar(250) NOT NULL,
  `paymentUniqid` varchar(250) NOT NULL,
  `paymentSuccessDetails` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `paymentTitle`, `paymentDescription`, `paymentStudent`, `paymentAmount`, `paymentStatus`, `paymentDate`, `paymentUniqid`, `paymentSuccessDetails`) VALUES
(1, 'General apptitude', 'For the tevata apptitude training', 48, 975, 1, '12/01/2019', '5c700c1e2ff14', NULL),
(2, 'General apptitude', 'For the tevata apptitude training', 49, 975, 1, '12/01/2019', '5c700c1e305f7', NULL),
(3, 'General apptitude', 'For the tevata apptitude training', 50, 975, 1, '12/01/2019', '5c700c1e308ab', NULL),
(4, 'General apptitude', 'For the tevata apptitude training', 51, 975, 1, '12/01/2019', '5c700c1e3842c', NULL),
(5, 'General apptitude', 'For the tevata apptitude training', 52, 975, 1, '12/01/2019', '5c700c1e38755', NULL),
(6, 'General apptitude', 'For the tevata apptitude training', 53, 975, 1, '12/01/2019', '5c700c1e38a01', NULL),
(7, 'General apptitude', 'For the tevata apptitude training', 54, 975, 1, '12/01/2019', '5c700c1e38c1b', NULL),
(8, 'General apptitude', 'For the tevata apptitude training', 55, 975, 1, '12/01/2019', '5c700c1e38e09', NULL),
(9, 'General apptitude', 'For the tevata apptitude training', 56, 975, 1, '12/01/2019', '5c700c1e3907e', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `id` int(250) NOT NULL,
  `pollTitle` varchar(250) NOT NULL,
  `pollOptions` text NOT NULL,
  `pollTarget` varchar(10) NOT NULL,
  `pollStatus` int(1) NOT NULL DEFAULT 1,
  `userVoted` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`id`, `pollTitle`, `pollOptions`, `pollTarget`, `pollStatus`, `userVoted`) VALUES
(3, 'canteen', 'null', 'all', 0, NULL),
(4, 'office', 'null', 'all', 0, NULL),
(5, 'bus', 'null', 'all', 0, NULL),
(7, 'library', 'null', 'all', 0, NULL),
(8, 'teacher', 'null', 'students', 0, NULL),
(9, 'best teacher of the semister', '[{\"title\":\"Deepak Bosale\"},{\"title\":\"Kulkarni sir\"},{\"title\":\"Mane\"}]', 'teachers', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) NOT NULL,
  `fieldName` varchar(250) NOT NULL,
  `fieldValue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `fieldName`, `fieldValue`) VALUES
(1, 'address', ''),
(2, 'footer', 'All Rights Reserved, '),
(3, 'lastUpdateCheck', '1596107477'),
(4, 'latestVersion', '2.2'),
(6, 'phoneNo', ''),
(7, 'siteTitle', 'V1'),
(9, 'systemEmail', 'admin@admin.com'),
(14, 'schoolTerms', ''),
(15, 'attendanceModel', 'class'),
(16, 'smsProvider', '{\"smsProvider\":\"nexmo\",\"nexmoApiKey\":\"\",\"nexmoApiSecret\":\"\",\"nexmoPhoneNumber\":\"dfc\",\"twilioSID\":\"\",\"twilioToken\":\"\",\"twilioFN\":\"\",\"hoiioAppId\":\"\",\"hoiioAccessToken\":\"\",\"clickatellApiKey\":\"\",\"clickatellUserName\":\"\",\"clickatellPassword\":\"\",\"intellismsUserName\":\"\",\"intellismsPassword\":\"\",\"intellismsSenderNumber\":\"\",\"bulksmsUserName\":\"\",\"bulksmsPassword\":\"\",\"conceptoUserName\":\"\",\"conceptoPassword\":\"\",\"conceptoSenderId\":\"\",\"msg91Authkey\":\"\",\"msg91SenderId\":\"\"}'),
(17, 'mailProvider', '{\"mailProvider\":\"mail\",\"smtpHost\":\"\",\"smtpPort\":\"\",\"smtpUserName\":\"\",\"smtpPassWord\":\"\",\"AmazonSESAccessKey\":\"\",\"AmazonSESSecretKey\":\"\",\"AmazonSESVerifiedSender\":\"\"}'),
(18, 'examDetailsNotif', 'mailsms'),
(19, 'examDetailsNotifTo', 'both'),
(20, 'absentNotif', 'mailsms'),
(21, 'address2', ''),
(22, 'paypalPayment', ''),
(23, 'paymentTax', '10'),
(24, 'activatedModules', '[\"newsboardAct\",\"eventsAct\",\"attendanceAct\",\"bookslibraryAct\",\"assignmentsAct\",\"onlineexamsAct\",\"mediaAct\",\"paymentsAct\",\"pollsAct\",\"staticpagesAct\",\"transportAct\"]'),
(25, 'languageDef', '1'),
(26, 'languageAllow', '1'),
(27, 'layoutColor', 'black'),
(28, 'thisVersion', '1.4'),
(29, 'finishInstall', '1'),
(30, 'finishInstall', '1'),
(31, 'finishInstall', '1');

-- --------------------------------------------------------

--
-- Table structure for table `staticpages`
--

CREATE TABLE `staticpages` (
  `id` int(250) DEFAULT NULL,
  `pageTitle` varchar(250) NOT NULL,
  `pageContent` text NOT NULL,
  `pageActive` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staticpages`
--

INSERT INTO `staticpages` (`id`, `pageTitle`, `pageContent`, `pageActive`) VALUES
(NULL, 'cdfsdffd', '<p>fddffd</p>\n', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(250) NOT NULL,
  `subjectTitle` varchar(250) NOT NULL,
  `classId` int(250) NOT NULL,
  `teacherId` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `subjectTitle`, `classId`, `teacherId`) VALUES
(4, 'Theory of Computation', 10, 20),
(5, 'Microprocessors', 9, 12),
(6, 'Data Communication', 4, 6),
(7, 'Data Structures', 4, 6),
(8, 'Compiler Construction', 5, 6),
(9, 'Unix Operating System', 10, 7),
(10, 'Mobile Computing', 10, 6),
(11, 'Management Information System', 6, 6),
(12, 'Information & Cyber Security', 11, 6),
(13, 'Web Technology', 6, 24),
(14, 'TE Fluid Machinery & Fluid Power', 11, 11),
(15, 'Automobile Engineering', 12, 11),
(16, 'TE FMFP Practical', 11, 11),
(17, 'BE automobile Engineering Practical', 12, 11),
(18, 'Data Base', 11, 31),
(19, 'C++', 11, 11),
(20, 'web technology', 11, 44),
(21, 'General apptitude', 11, 57),
(22, 'C', 10, 57);

-- --------------------------------------------------------

--
-- Table structure for table `transportation`
--

CREATE TABLE `transportation` (
  `id` int(250) NOT NULL,
  `transportTitle` varchar(250) NOT NULL,
  `transportDescription` text NOT NULL,
  `transportDriverContact` text NOT NULL,
  `transportFare` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transportation`
--

INSERT INTO `transportation` (`id`, `transportTitle`, `transportDescription`, `transportDriverContact`, `transportFare`) VALUES
(1, 'Own Vehical', 'Bike / Private BUS/  Public Transport', '987654321', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `remember_Token` varchar(250) DEFAULT NULL,
  `fullName` varchar(250) NOT NULL,
  `role` varchar(10) NOT NULL,
  `activated` int(1) NOT NULL DEFAULT 1,
  `studentRollId` varchar(250) DEFAULT NULL,
  `auth_Session` text DEFAULT NULL,
  `birthday` int(250) NOT NULL DEFAULT 0,
  `gender` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phoneNo` varchar(250) DEFAULT NULL,
  `mobileNo` varchar(250) DEFAULT NULL,
  `studentClass` int(250) DEFAULT 0,
  `parentProfession` varchar(250) DEFAULT NULL,
  `parentOf` text DEFAULT NULL,
  `photo` varchar(250) DEFAULT '',
  `isLeaderBoard` text DEFAULT NULL,
  `restoreUniqId` varchar(250) DEFAULT NULL,
  `transport` int(250) DEFAULT NULL,
  `defLang` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `remember_Token`, `fullName`, `role`, `activated`, `studentRollId`, `auth_Session`, `birthday`, `gender`, `address`, `phoneNo`, `mobileNo`, `studentClass`, `parentProfession`, `parentOf`, `photo`, `isLeaderBoard`, `restoreUniqId`, `transport`, `defLang`) VALUES
(1, 'admin', 'admin@admin.com', '$2y$10$5KRjWt7Tz8ld3NHZKXLAFOH1SxM.oeRIqY4fAqcQkIs.gqbMFHAUm', 'FLOb0mGEAIlMnhRuBavb9AsHSxTUqP3T1mchThgeoExmGB9clIFO5Vfm9LRw', 'Admin', 'admin', 1, NULL, '', 343699200, 'male', 'Pune', '02186-257313', '90498229876543210', 0, NULL, '', 'profile_1.JPG', '', '', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booklibrary`
--
ALTER TABLE `booklibrary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classschedule`
--
ALTER TABLE `classschedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dormitories`
--
ALTER TABLE `dormitories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exammarks`
--
ALTER TABLE `exammarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `examslist`
--
ALTER TABLE `examslist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gradelevels`
--
ALTER TABLE `gradelevels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mailsms`
--
ALTER TABLE `mailsms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mailsmstemplates`
--
ALTER TABLE `mailsmstemplates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mediaalbums`
--
ALTER TABLE `mediaalbums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mediaitems`
--
ALTER TABLE `mediaitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messageslist`
--
ALTER TABLE `messageslist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsboard`
--
ALTER TABLE `newsboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `onlineexams`
--
ALTER TABLE `onlineexams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `onlineexamsgrades`
--
ALTER TABLE `onlineexamsgrades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transportation`
--
ALTER TABLE `transportation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `booklibrary`
--
ALTER TABLE `booklibrary`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `classschedule`
--
ALTER TABLE `classschedule`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `dormitories`
--
ALTER TABLE `dormitories`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `exammarks`
--
ALTER TABLE `exammarks`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `examslist`
--
ALTER TABLE `examslist`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gradelevels`
--
ALTER TABLE `gradelevels`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mailsms`
--
ALTER TABLE `mailsms`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mailsmstemplates`
--
ALTER TABLE `mailsmstemplates`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mediaalbums`
--
ALTER TABLE `mediaalbums`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mediaitems`
--
ALTER TABLE `mediaitems`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `messageslist`
--
ALTER TABLE `messageslist`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `newsboard`
--
ALTER TABLE `newsboard`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `onlineexams`
--
ALTER TABLE `onlineexams`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `onlineexamsgrades`
--
ALTER TABLE `onlineexamsgrades`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transportation`
--
ALTER TABLE `transportation`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
