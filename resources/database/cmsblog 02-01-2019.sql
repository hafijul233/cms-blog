-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2019 at 08:36 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cmsblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--
-- Creation: Dec 05, 2018 at 08:44 PM
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `categorycreator` varchar(255) NOT NULL DEFAULT '',
  `datetime` varchar(45) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `categorycreator`, `datetime`, `created`, `modified`, `status`) VALUES
(1, 'PHP', 'Hafijul', '07-12-2018 01:00:38', '2018-12-07 01:00:38', '2018-12-07 01:00:38', 1),
(2, 'JAVA', 'Hafijul', '07-12-2018 01:02:46', '2018-12-07 01:02:46', '2018-12-07 01:02:46', 1),
(3, 'Python', 'Hafijul', '07-12-2018 01:11:05', '2018-12-07 01:11:05', '2018-12-07 01:11:05', 1),
(4, 'C++', 'Hafijul', '07-12-2018 01:50:30', '2018-12-07 01:50:30', '2018-12-07 01:50:30', 1),
(5, 'Web Development', 'Hafijul', '07-12-2018 01:52:03', '2018-12-07 01:52:03', '2018-12-07 01:52:03', 1),
(6, 'Object Oriented Programming', 'Hafijul', '07-12-2018 01:58:25', '2018-12-07 01:58:25', '2018-12-07 01:58:25', 1),
(7, 'UI and UX Design', 'Hafijul', '07-12-2018 02:57:37', '2018-12-07 02:57:37', '2018-12-07 02:57:37', 1),
(8, 'ASP.Net', 'Hafijul', '11-12-2018 16:52:37', '2018-12-11 16:52:37', '2018-12-11 16:52:37', 1),
(9, 'Facebook Marketing', 'Hafijul', '11-12-2018 16:52:58', '2018-12-11 16:52:58', '2018-12-11 16:52:58', 1),
(10, 'Google Admob', 'Hafijul', '11-12-2018 16:53:10', '2018-12-11 16:53:10', '2018-12-11 16:53:10', 1),
(11, 'Quantum Computing', 'Hafijul', '11-12-2018 16:53:31', '2018-12-11 16:53:31', '2018-12-11 16:53:31', 1),
(12, 'Network Security', 'Hafijul', '11-12-2018 17:03:43', '2018-12-11 17:03:43', '2018-12-11 17:03:43', 1),
(13, 'C# Desktop Application', 'Hafijul', '11-12-2018 18:53:22', '2018-12-11 18:53:22', '2018-12-11 18:53:22', 1),
(14, 'Graphic Design', 'Hafijul', '28-12-2018 12:20:03', '2018-12-28 12:20:03', '2018-12-28 12:20:03', 1),
(15, 'AngularJS', 'Hafijul', '31-12-2018 23:28:33', '2018-12-31 23:28:33', '2018-12-31 23:28:33', 1),
(16, 'C# Desktop Application2', 'Hafijul', '01-01-2019 14:47:04', '2019-01-01 14:47:04', '2019-01-01 14:47:04', 1),
(17, 'C# Desktop Application2', 'Hafijul', '01-01-2019 14:48:45', '2019-01-01 14:48:45', '2019-01-01 14:48:45', 1),
(18, 'PHP2', 'Hafijul', '01-01-2019 14:48:51', '2019-01-01 14:48:51', '2019-01-01 14:48:51', 1),
(19, 'C# Desktop Application3', 'Hafijul', '01-01-2019 14:51:30', '2019-01-01 14:51:30', '2019-01-01 14:51:30', 1),
(20, 'PHP7', 'Hafijul', '01-01-2019 14:52:42', '2019-01-01 14:52:42', '2019-01-01 14:52:42', 1),
(21, 'PHP5', 'Hafijul', '01-01-2019 14:58:46', '2019-01-01 14:58:46', '2019-01-01 14:58:46', 1),
(22, 'Hafijul22', 'Hafijul', '01-01-2019 14:59:32', '2019-01-01 14:59:32', '2019-01-01 14:59:32', 1),
(23, 'C# Desktop Application2', 'Hafijul', '01-01-2019 14:59:38', '2019-01-01 14:59:38', '2019-01-01 14:59:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userposts`
--
-- Creation: Dec 11, 2018 at 11:44 AM
--

DROP TABLE IF EXISTS `userposts`;
CREATE TABLE `userposts` (
  `id` int(10) UNSIGNED NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `categoryno` int(10) UNSIGNED NOT NULL,
  `datetime` varchar(45) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` text NOT NULL,
  `post` text NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userposts`
--

INSERT INTO `userposts` (`id`, `author`, `categoryno`, `datetime`, `title`, `image`, `post`, `created`, `modified`, `status`) VALUES
(1, 'Hafijul', 2, '21-12-2018 01:58:40', 'Hridoy', '47adcfacc35c8b4f3c17e4cf227a4509.png', '<p>fghgfhfh<br></p>', '2018-12-21 01:58:40', '2018-12-21 01:58:40', 1),
(2, 'Hafijul', 1, '21-12-2018 02:09:18', 'Web Development using PHP', '55e4fbad58dddb24617b1ff450cb6d52.png', '<p>\r\n<b>Web Development Using PHP</b> And MySQL. <b>PHP</b> (or <b>PHP</b> Hypertext Preprocessor) is a server-side scripting language that is used to create dynamic <b>web</b> pages that can interact with databases. It is a widely-used open source language that is specifically used for <b>web</b> application <b>development</b> and can be embedded within HTML.<br></p>', '2018-12-21 02:09:18', '2018-12-21 02:09:18', 1),
(3, 'Hafijul', 8, '28-12-2018 15:56:43', 'Building Websites in ASP.NET', '1f65d567cc224b91f845ffd1ce0b07ff.png', '<p>\r\n</p><p><b>ASP.NET</b> offers three frameworks for creating web applications: <a target=\"_blank\" rel=\"nofollow\" href=\"https://www.asp.net/get-started/websites#web-forms\">Web Forms</a>, <a target=\"_blank\" rel=\"nofollow\" href=\"https://www.asp.net/get-started/websites#mvc\">ASP.NET MVC</a>, and <a target=\"_blank\" rel=\"nofollow\" href=\"https://www.asp.net/get-started/websites#web-pages\">ASP.NET Web Pages</a>. All three frameworks are stable and mature, and you can create great web applications with any of them. <i>No matter what framework you choose, you will get all the benefits and features of </i><b><i>ASP.NET</i></b><i> everywhere.</i></p>\r\n<p>Each framework targets a different development style. The one you choose depends on a combination of your programming assets (knowledge, skills, and development experience), the type of application youâ€™re creating, and the development approach youâ€™re comfortable with. All three frameworks will be supported, updated, and improved in future releases of ASP.NET.</p>\r\n<p>Below is an overview of each of the frameworks and some ideas for how to choose between them. If you prefer a video introduction, see <a target=\"_blank\" rel=\"nofollow\" href=\"https://www.asp.net/aspnet/overview/making-websites-with-aspnet/making-websites-with-aspnet\"> Making Websites with ASP.NET</a>.</p><p></p>', '2018-12-28 15:56:43', '2018-12-28 15:56:43', 1),
(4, 'Hafijul', 2, '28-12-2018 15:59:29', 'Java Web Application Tutorial for Beginners', '1a9108a961b4d45821f71539cc4ba828.jpg', '<p>\r\n<strong>Java Web Application</strong> is used to create dynamic websites. Java provides support for web application through <strong>Servlets</strong> and <strong>JSPs</strong>. We can create a website with static HTML pages but when we want information to be dynamic, we need web application. <br></p><p>\r\n</p><h2>Java Web Application</h2>\r\n<p>The aim of this article is to provide basic details of different components in Web Application and how can we use Servlet and JSP to create our first java web application.</p>\r\n<ol>\r\n<li><a target=\"_blank\" rel=\"nofollow\" href=\"https://www.journaldev.com/1854/java-web-application-tutorial-for-beginners#web-server-client\">Web Server and Client</a></li>\r\n<li><a target=\"_blank\" rel=\"nofollow\" href=\"https://www.journaldev.com/1854/java-web-application-tutorial-for-beginners#html-http\">HTML and HTTP</a></li>\r\n<li><a target=\"_blank\" rel=\"nofollow\" href=\"https://www.journaldev.com/1854/java-web-application-tutorial-for-beginners#url-parts\">Understanding URL</a></li>\r\n<li><a target=\"_blank\" rel=\"nofollow\" href=\"https://www.journaldev.com/1854/java-web-application-tutorial-for-beginners#servlets-jsps\">Why we need Servlet and JSPs?</a></li>\r\n<li><a target=\"_blank\" rel=\"nofollow\" href=\"https://www.journaldev.com/1854/java-web-application-tutorial-for-beginners#first-web-app-servlet\">First Web Application with Servlet and JSP</a></li>\r\n<li><a target=\"_blank\" rel=\"nofollow\" href=\"https://www.journaldev.com/1854/java-web-application-tutorial-for-beginners#web-container\">Web Container</a></li>\r\n<li><a target=\"_blank\" rel=\"nofollow\" href=\"https://www.journaldev.com/1854/java-web-application-tutorial-for-beginners#web-application-directory\">Web Application Directory Structure</a></li>\r\n<li><a target=\"_blank\" rel=\"nofollow\" href=\"https://www.journaldev.com/1854/java-web-application-tutorial-for-beginners#deployment-descriptor\">Deployment Descriptor</a></li>\r\n</ol>\r\n<p><a target=\"_blank\" rel=\"nofollow\"></a></p>\r\n<h3>Web Server and Client</h3>\r\n<p>Web Server is a software that can process the client request and send the response back to the client. For example, Apache is one of the most widely used web server. Web Server runs on some physical machine and listens to client request on specific port.</p>\r\n<p>A web client is a software that helps in communicating with the server. Some of the most widely used web clients are Firefox, Google Chrome, Safari etc. When we request something from server (through URL), web client takes care of creating a request and sending it to server and then parsing the server response and present it to the user.</p>\r\n\r\n<div>\r\n<div></div>\r\n</div>\r\n\r\n<p><a target=\"_blank\" rel=\"nofollow\"></a></p>\r\n<h3>HTML and HTTP</h3>\r\n<p>Web Server and Web Client are two separate softwares, so there should be some common language for communication. HTML is the common language between server and client and stands for <strong>H</strong>yper<strong>T</strong>ext <strong>M</strong>arkup <strong>L</strong>anguage.</p>\r\n<p>Web server and client needs a common communication protocol, HTTP (<strong>H</strong>yper<strong>T</strong>ext <strong>T</strong>ransfer <strong>P</strong>rotocol) is the communication protocol between server and client. HTTP runs on top of TCP/IP communication protocol.</p>\r\n<p>Some of the important parts of HTTP Request are:</p>\r\n<ul>\r\n<li><strong>HTTP Method</strong> â€“ action to be performed, usually GET, POST, PUT etc.</li>\r\n<li><strong>URL</strong> â€“ Page to access</li>\r\n<li><strong>Form Parameters</strong> â€“ similar to arguments in a java method, for example user,password details from login page.</li>\r\n</ul>\r\n<p>Sample HTTP Request:</p>\r\n<pre><code>\r\nGET /FirstServletProject/jsps/hello.jsp HTTP/1.1\r\nHost: localhost:8080\r\nCache-Control: no-cache\r\n</code></pre>\r\n<p>Some of the important parts of HTTP Response are:</p>\r\n<ul>\r\n<li><strong>Status Code</strong> â€“ an integer to indicate whether the request was success or not. Some of the well known status codes are 200 for success, 404 for Not Found and 403 for Access Forbidden.</li>\r\n<li><strong>Content Type</strong> â€“ text, html, image, pdf etc. Also known as MIME type</li>\r\n<li><strong>Content</strong> â€“ actual data that is rendered by client and shown to user.</li>\r\n</ul>\r\n<p>Sample HTTP Response:</p>\r\n<pre><code>\r\n200 OK\r\nDate: Wed, 07 Aug 2013 19:55:50 GMT\r\nServer: Apache-Coyote/1.1\r\nContent-Length: 309\r\nContent-Type: text/html;charset=US-ASCII\r\n\r\n&lt;!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\"&gt;\r\n&lt;html&gt;\r\n&lt;head&gt;\r\n&lt;meta http-equiv=\"Content-Type\" content=\"text/html; charset=US-ASCII\"&gt;\r\n&lt;title&gt;Hello&lt;/title&gt;\r\n&lt;/head&gt;\r\n&lt;body&gt;\r\n&lt;h2&gt;Hi There!&lt;/h2&gt;\r\n&lt;br&gt;\r\n&lt;h3&gt;Date=Wed Aug 07 12:57:55 PDT 2013\r\n&lt;/h3&gt;\r\n&lt;/body&gt;\r\n&lt;/html&gt;\r\n</code></pre>\r\n<p><strong>MIME Type or Content Type</strong>: If you see above sample HTTP response header, it contains tag â€œContent-Typeâ€. Itâ€™s also called MIME type and server sends it to client to let them know the kind of data itâ€™s sending. It helps client in rendering the data for user. Some of the mostly used mime types are text/html, text/xml, application/xml etc.</p>\r\n<p><a target=\"_blank\" rel=\"nofollow\"></a></p>\r\n<h3>Understanding URL</h3>\r\n<p>URL is acronym of Universal Resource Locator and itâ€™s used to locate the server and resource. Every resource on the web has itâ€™s own unique address. Letâ€™s see parts of URL with an example.</p>\r\n<p><strong><a target=\"_blank\" rel=\"nofollow\" href=\"http://localhost:8080/FirstServletProject/jsps/hello.jsp\">http://localhost:8080/FirstServletProject/jsps/hello.jsp</a></strong></p>\r\n<p><strong>http://</strong> â€“ This is the first part of URL and provides the communication protocol to be used in server-client communication.</p>\r\n<p><strong>localhost</strong> â€“ The unique address of the server, most of the times itâ€™s the hostname of the server that maps to unique IP address. Sometimes multiple hostnames point to same IP addresses and <a target=\"_blank\" rel=\"nofollow\" href=\"https://www.journaldev.com/1456/how-to-install-apache-php-and-mysql-on-mac-os-x\">web server virtual host</a> takes care of sending request to the particular server instance.</p>\r\n<p><strong>8080</strong> â€“ This is the port on which server is listening, itâ€™s optional and if we donâ€™t provide it in URL then request goes to the default port of the protocol. Port numbers 0 to 1023 are reserved ports for well known services, for example 80 for HTTP, 443 for HTTPS, 21 for FTP etc.</p>\r\n<p><strong>FirstServletProject/jsps/hello.jsp</strong> â€“ Resource requested from server. It can be static html, pdf, JSP, servlets, PHP etc.</p>\r\n<p><a target=\"_blank\" rel=\"nofollow\"></a></p>\r\n<h3>Why we need Servlet and JSPs?</h3>\r\n<p>Web servers are good for static contents HTML pages but they donâ€™t know how to generate dynamic content or how to save data into databases, so we need another tool that we can use to generate dynamic content. There are several programming languages for dynamic content like PHP, Python, Ruby on Rails, Java Servlets and JSPs.</p>\r\n<p>Java Servlet and JSPs are server side technologies to extend the capability of web servers by providing support for dynamic response and data persistence.</p>\r\n<p><a target=\"_blank\" rel=\"nofollow\"></a></p>\r\n<h2>Java Web Development</h2>\r\n<h3>First Web Application with Servlet and JSP</h3>\r\n<p>We will use â€œEclipse IDE for Java EE Developersâ€ for creating our first servlet application. Since servlet is a server side technology, we will need a web container that supports Servlet technology, so we will use Apache Tomcat server. Itâ€™s very easy to setup and I am leaving that part to yourself.</p>\r\n<p>For ease of development, we can add configure Tomcat with Eclipse, it helps in easy deployment and running applications.</p><br><p></p>', '2018-12-28 15:59:29', '2018-12-28 15:59:29', 1),
(5, 'Hafijul', 13, '31-12-2018 23:27:23', 'C Sharp (programming language)', '0d4dd1e0d55a6f1de835349a057207e1.png', '<p>So far we have seen how to work with C# to create console based applications. But in a real-life scenario team normally use Visual Studio and C# to create either Windows Forms or Web-based applications.</p><p>A windows form application is an application, which is designed to run on a computer. It will not run on web browser because then it becomes a web application.<br/>This Tutorial will focus on how we can create Windows-based applications. We will also learn some basics on how to work with the various elements of Windows applications.</p>', '2018-12-31 23:27:23', '2018-12-31 23:27:23', 1),
(6, 'Hafijul', 15, '31-12-2018 23:29:20', 'AngularJS Web Application Development', 'ea9939b4bed8a653699a263c2b11c80c.jpg', '<p>\r\n</p><p><b>AngularJS</b> is a JavaScript framework originally created by Google, who actively support its development. The main idea of Angular is to combine well-known components, patterns and development practices in one framework that is straightforward to use and encourages following the best practices of web development. The underlying goal is that with Angular, developers can and will choose not just any solution that works, but the best known solution, the â€œAngular way of doing thingsâ€.</p> <p>To achieve this purpose, AngularJS supports standard components such as models, views, controllers and services. This leads to Angular making use of two important software design patterns, Model View Controller and Dependency Injection. Besides that, Angular makes use of many abstractions, paying attention to balancing modularity and complexity.</p> <p>Importantly, AngularJS is created with special attention to testing. It supports writing test friendly code, which in practice leads to higher quality software and less interruptions in service and business. Angular also supports well the use of jQuery library, which ensures that many of the popular web development practices can be used as before.</p> <p>Finally, when comparing web technologies, you canâ€™t ignore the popularity factor. AngularJS has high adoption and growth rate, and the framework has active development progress going on continuously. This makes Angular a safe choice to rely on.</p>\r\n\r\n<p></p><br>', '2018-12-31 23:29:20', '2018-12-31 23:29:20', 1),
(7, 'Hafijul', 3, '31-12-2018 23:30:13', 'Python Programming Language Importance', '222f578788049d155a5abfebfccbc4cf.jpeg', '<p>\r\n</p><p>According to the latest <a target=\"_blank\" rel=\"nofollow\" href=\"https://www.tiobe.com/tiobe-index/\">TIOBE Programming Community Index</a>,\r\n Python is one of the top 10 popular programming languages of 2017. \r\nPython is a general purpose and high level programming language. You can\r\n use Python for developing desktop GUI applications, websites and web \r\napplications. Also, Python, as a high level programming language, allows\r\n you to focus on core functionality of the application by taking care of\r\n common programming tasks. The simple syntax rules of the programming \r\nlanguage further makes it easier for you to keep the code base readable \r\nand application maintainable. There are also a number of reasons why you\r\n should prefer Python to other programming languages.</p><p><strong>7 Reasons Why You Must Consider Writing Software Applications in Python</strong></p><p><strong>1) Readable and Maintainable Code</strong></p><p>While\r\n writing a software application, you must focus on the quality of its \r\nsource code to simplify maintenance and updates. The syntax rules of \r\nPython allow you to express concepts without writing additional code. At\r\n the same time, Python, unlike other programming languages, emphasizes \r\non code readability, and allows you to use English keywords instead of \r\npunctuations. Hence, you can use Python to build custom applications \r\nwithout writing additional code. The readable and clean code base will \r\nhelp you to maintain and update the software without putting extra time \r\nand effort.</p><p><strong>2) Multiple Programming Paradigms</strong></p><p>Like\r\n other modern programming languages, Python also supports several \r\nprogramming paradigm. It supports object oriented and structured \r\nprogramming fully. Also, its language features support various concepts \r\nin functional and aspect-oriented programming. At the same time, Python \r\nalso features a dynamic type system and automatic memory management. The\r\n programming paradigms and language features help you to use Python for \r\ndeveloping large and complex software applications.</p><p><strong>3) Compatible with Major Platforms and Systems</strong></p><p>At\r\n present, Python is supports many operating systems. You can even use \r\nPython interpreters to run the code on specific platforms and tools. \r\nAlso, Python is an interpreted programming language. It allows you to \r\nyou to run the same code on multiple platforms without recompilation. \r\nHence, you are not required to recompile the code after making any \r\nalteration. You can run the modified application code without \r\nrecompiling and check the impact of changes made to the code \r\nimmediately. The feature makes it easier for you to make changes to the \r\ncode without increasing development time.</p><p><strong>4) Robust Standard Library</strong></p><p>Its\r\n large and robust standard library makes Python score over other \r\nprogramming languages. The standard library allows you to choose from a \r\nwide range of modules according to your precise needs. Each module \r\nfurther enables you to add functionality to the Python application \r\nwithout writing additional code. For instance, while writing a web \r\napplication in Python, you can use specific modules to implement web \r\nservices, perform string operations, manage operating system interface \r\nor work with internet protocols. You can even gather information about \r\nvarious modules by browsing through the Python Standard Library \r\ndocumentation.</p><p><strong>5) Many Open Source Frameworks and Tools</strong></p><p>As\r\n an open source programming language, Python helps you to curtail \r\nsoftware development cost significantly. You can even use several open \r\nsource Python frameworks, libraries and development tools to curtail \r\ndevelopment time without increasing development cost. You even have \r\noption to choose from a wide range of open source Python frameworks and \r\ndevelopment tools according to your precise needs. For instance, you can\r\n simplify and speedup web application development by using robust Python\r\n web frameworks like Django, Flask, Pyramid, Bottle and Cherrypy. \r\nLikewise, you can accelerate desktop GUI application development using <a target=\"_blank\" rel=\"nofollow\" href=\"http://www.allaboutweb.biz/python-gui-frameworks-usage/\"><strong>Python GUI frameworks</strong></a><strong> </strong>and toolkits like PyQT, PyJs, PyGUI, Kivy, PyGTK and WxPython.</p><p><strong>6) Simplify Complex Software Development</strong></p><p>Python\r\n is a general purpose programming language. Hence, you can use the \r\nprogramming language for developing both desktop and web applications. \r\nAlso, you can use Python for developing complex scientific and numeric \r\napplications. Python is designed with features to facilitate data \r\nanalysis and visualization. You can take advantage of the data analysis \r\nfeatures of Python to create custom big data solutions without putting \r\nextra time and effort. At the same time, the data visualization \r\nlibraries and APIs provided by Python help you to visualize and present \r\ndata in a more appealing and effective way. Many <a target=\"_blank\" rel=\"nofollow\" href=\"http://www.mindfiresolutions.com/python-development.htm\"><strong>Python developers</strong></a> even use Python to accomplish artificial intelligence (AI) and natural language processing tasks.</p><p><strong>7) Adopt Test Driven Development</strong></p><p>You\r\n can use Python to create prototype of the software application rapidly.\r\n Also, you can build the software application directly from the \r\nprototype simply by refactoring the Python code. Python even makes it \r\neasier for you to perform coding and testing simultaneously by adopting \r\ntest driven development (TDD) approach. You can easily write the \r\nrequired tests before writing code and use the tests to assess the \r\napplication code continuously. The tests can also be used for checking \r\nif the application meets predefined requirements based on its source \r\ncode.</p><p>However,\r\n Python, like other programming languages, has its own shortcomings. It \r\nlacks some of the built-in features provided by other modern programming\r\n language. Hence, you have to use Python libraries, modules, and \r\nframeworks to accelerate custom software development. Also, several \r\nstudies have shown that Python is slower than several widely used \r\nprogramming languages including Java and C++. You have to speed up the \r\nPython application by making changes to the application code or using \r\ncustom runtime. But you can always use Python to speed up software \r\ndevelopment and simplify software maintenance.</p>\r\n\r\n<br><p></p>', '2018-12-31 23:30:13', '2018-12-31 23:30:13', 1),
(8, 'Hafijul', 5, '01-01-2019 14:11:20', 'Mid-Level Developer', 'f7b1272e0fe54121532caf69622029d5.PNG', '<p>kl;k;<br></p>', '2019-01-01 14:11:20', '2019-01-01 14:11:20', 1),
(9, 'Hafijul', 5, '01-01-2019 14:15:44', 'Mid-Level Developer', 'f7b1272e0fe54121532caf69622029d5.PNG', '<p>hjkhjkhjk<br></p>', '2019-01-01 14:15:44', '2019-01-01 14:15:44', 1),
(10, 'Hafijul', 10, '01-01-2019 14:18:19', 'AngularJS Web Application Development', 'f7b1272e0fe54121532caf69622029d5.PNG', '<p>fghfhfh<br></p>', '2019-01-01 14:18:19', '2019-01-01 14:18:19', 1),
(11, 'Hafijul', 2, '01-01-2019 14:19:38', 'Hridoy', '3afb0ab99db130ef0707715c9ac74c1e.png', '<p>hjkhjk<br></p>', '2019-01-01 14:19:38', '2019-01-01 14:19:38', 1),
(12, 'Hafijul', 2, '01-01-2019 14:22:39', 'AngularJS Web Application Development', '3de9b99983c29aad1bd0fec6c1e90571.png', '<p>hjkhjk<br></p>', '2019-01-01 14:22:39', '2019-01-01 14:22:39', 1),
(13, 'Hafijul', 3, '01-01-2019 14:24:05', 'AngularJS Web Application Development', '469deeffa347443264011de6b378c490.png', '<p>hgjghjghj<br></p>', '2019-01-01 14:24:05', '2019-01-01 14:24:05', 1),
(14, 'Hafijul', 2, '01-01-2019 14:25:26', 'Hridoy', '5bfffa0cd665bc4e1b00846c5da0d3b0.png', '<p>kl;lk;<br></p>', '2019-01-01 14:25:26', '2019-01-01 14:25:26', 1),
(15, 'Hafijul', 2, '01-01-2019 14:26:27', 'Hridoy', '0eb0ee99eff6231050b7ee9a20432c33.png', '<p>kl;lk;<br></p>', '2019-01-01 14:26:27', '2019-01-01 14:26:27', 1),
(16, 'Hafijul', 3, '01-01-2019 14:27:11', 'Hridoy', 'a6cb8748a417eaf0f1ae765830f7b194.png', '<p>fghfghg<br></p>', '2019-01-01 14:27:11', '2019-01-01 14:27:11', 1),
(17, 'Hafijul', 3, '01-01-2019 14:29:21', 'Hridoy', 'b7e5bf38948354f7bb288ce2298bbcfa.png', '<p>hghgfhf<br></p>', '2019-01-01 14:29:21', '2019-01-01 14:29:21', 1),
(18, 'Hafijul', 3, '01-01-2019 14:59:51', 'AngularJS Web Application Development', '8371af100e98e1807e59acc3b4cb035f.png', '<p>hgjghj<br></p>', '2019-01-01 14:59:51', '2019-01-01 14:59:51', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userposts`
--
ALTER TABLE `userposts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `userposts`
--
ALTER TABLE `userposts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
