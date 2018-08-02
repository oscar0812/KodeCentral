-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 01, 2018 at 09:12 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kodeCentral`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Beginner'),
(2, 'Bots'),
(3, 'Desktop'),
(4, 'Games'),
(5, 'Mobile'),
(6, 'Web'),
(7,'Request');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `text` varchar(512) NOT NULL,
  `posted_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `library`
--

INSERT INTO `library` (`id`, `name`) VALUES
(1, 'All');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `hyperlink` varchar(128) NOT NULL,
  `text` varchar(32768) NOT NULL,
  `posted_date` date NOT NULL,
  `posted_by_user_id` int(11) NOT NULL,
  `library_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `hyperlink`, `text`, `posted_date`, `posted_by_user_id`, `library_id`) VALUES
(1,'Reverse number','reverse-number','<p>Problem:</p><p class=\"ql-indent-2\">Given the number N, print reverse of number N. Note: do not print leading zeros in output. </p><p class=\"ql-indent-2\">For example N = 100, Reverse will be 1, not 001</p><p class=\"ql-indent-2\">input: input contains a single integer N.</p><p class=\"ql-indent-2\">Output: print reverse of integer N.</p><p class=\"ql-indent-2\">Constraints:</p><p class=\"ql-indent-2\">1&lt;=N&lt;=10_000</p><p>Solution: </p><p>First reverse the integer, you can do this in various ways, but the easiest would be to transform it into a string, then reverse the string.</p><p>Lex x be the integer you want to reverse.</p><pre><code>String reversed = new StringBuilder().append(x).reverse().toString();\nSystem.out.println(reversed);\n</code></pre><p><br></p><p>Since the question asks for no leading zeros you can get that desired output by putting the reversed value back into an integer like so:</p><pre><code>Integer.parseInt(reversed);\n</code></pre><p><br></p><p>Make sure to comment below if this was helpful to you. See you next time.</p>','2018-08-01',1,1),
(2,'Gift distance','gift-distance','<p>Problem:</p><p class=\"ql-indent-2\">You are on your way to find the gifts. All the gifts lie in your path in a straight line at prime numbers and your house is at 0. </p><p class=\"ql-indent-2\">Given your current position find the closest gift to your position, and calculate the distance between your current position and gift and tell the distance. </p><p>Solution:</p><p>The problem is asking what the nearest prime to the current location is. Every prime is surrounded by other numbers (869, 870, ...) which can be prime; for example, 870 has the prime 877 close to it, but also 863, they are both 7 numbers away, resulting in the output of 7, but if that wasn\'t the case, then the closest prime distance would be the answer.</p><p><br></p><p>We first need a way to know when a number is prime, which requires simple math:</p><pre><code>private static boolean check_prime(long n) {\n    for(long i = 2; i&lt;Math.sqrt(n);i++) {\n        if((n%i)==0)\n            return false;\n    }\n    return true;\n}\n</code></pre><p><br></p><p>or you can use the built in function of big integer to check for primes:</p><p><br></p><pre><code>private static boolean check_prime(long n)\n{\n    // Converting long to BigInteger\n    BigInteger b = new BigInteger(String.valueOf(n));\n\n    return b.isProbablePrime(1);\n}\n</code></pre><p><br></p><p>Once you have that, you have to loop to both sides of the number and continuously check if the number that you looped to is prime, like so:</p><p><br></p><pre><code>while (true) {\n    long number, i;\n\n    // get input from keyboard\n    Scanner scanner = new Scanner(System.in);\n    number = scanner.nextLong();\n\n    if (check_prime(number))\n        // if already prime, just print 0\n        System.out.println(0);\n    else {\n        // loop to both sides of the number\n        for (i = 1; i &lt; number - 2; i++) {\n            // this print is for debugging purposes\n            System.out.println((number - i) + \", \" + (number + i));\n            if (check_prime(number - i)) {\n                // found answer as prime before input\n                System.out.printf(\"%d\\n\", (number - (number - i)));\n                break;\n            } else if (check_prime(number + i)) {\n                // found answer as prime after input\n                System.out.printf(\"%d\\n\", ((number + i) - number));\n                break;\n            }\n        }\n    }\n}\n</code></pre><p><br></p><p>Hope this helped!</p>','2018-08-01',1,1),
(3,'Maximum number','maximum-number','<p>Problem:</p><p class=\"ql-indent-2\">Given an array of numbers, arrange them in a way that yields the largest value. For example, if the given numbers are 154, 546, 548, 60}, the arrangement 6054854654 gives the largest value. </p><p class=\"ql-indent-2\">Input: First line contains an integer N , Next line contains N integers separated by space. </p><p class=\"ql-indent-2\">Output: Print the maximum number that can be obtained by using given numbers. </p><p class=\"ql-indent-2\">Constraints: 1&lt;=N&lt;=1000 1aNumber&lt;=1000000</p><p>Solution:</p><p>First you need to have the numbers stored in an array of integers, then you do the following:</p><p><br></p><pre><code>private static String largestNumber(int[] nums) {\n    String[] strings = new String[nums.length];\n    \n    // convert the integer array into a string array\n    for (int i = 0; i &lt; nums.length; i++) {\n        strings[i] = String.valueOf(nums[i]);\n    }\n    \n    // sort the string array by comparing values a and b\n    // for example: \"9\" + \"8\" vs \"8\"+ \"9\", \"98\" &gt; \"89\" so \"98\" goes first\n    Arrays.sort(strings, (a, b) -&gt; (b + a).compareTo(a + b));\n    \n    // combine the array into a big string\n    StringBuilder sb = new StringBuilder();\n    for (String s : strings) {\n        sb.append(s);\n    }\n    \n    // remove any leading zeros\n    while (sb.charAt(0) == \'0\' &amp;&amp; sb.length() &gt; 1)\n        sb.deleteCharAt(0);\n    \n    // return the final value as a string, since it can be large and cause overflow\n    return sb.toString();\n}\n</code></pre><p><br></p><p>Hope this helped!</p>','2018-08-01',1,1);

-- --------------------------------------------------------

--
-- Table structure for table `post_category`
--

CREATE TABLE `post_category` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_category`
--

INSERT INTO `post_category` (`post_id`, `category_id`) VALUES
(1, 7),
(2, 7),
(3, 7);


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `profile_picture` varchar(128) NOT NULL,
  `join_date` date NOT NULL,
  `password` varchar(256) NOT NULL,
  `is_super` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `join_date`, `password`, `is_super`) VALUES
(1, 'Bittle', 'bittle@gmail.com', '2018-07-22', '$2a$12$7NLDHcbW5CmKPxW68rz4seOOx/o0dTyf4TX.D6gFRC2MyK4KYZ8L6', 1),
(2, 'Bit', 'cwmversion4@gmail.com','2018-07-30', '$2a$12$fUsQoTkZnB/gE/cyiJ4Eb.SUbswWokm0/h2OI0oPnWNuWulN7JaaS', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posted_by_user_id` (`posted_by_user_id`),
  ADD KEY `category_id` (`library_id`);

--
-- Indexes for table `post_category`
--
ALTER TABLE `post_category`
  ADD PRIMARY KEY (`post_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `library`
--
ALTER TABLE `library`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`posted_by_user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `post_ibfk_3` FOREIGN KEY (`library_id`) REFERENCES `library` (`id`);

--
-- Constraints for table `post_category`
--
ALTER TABLE `post_category`
  ADD CONSTRAINT `post_category_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `post_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
