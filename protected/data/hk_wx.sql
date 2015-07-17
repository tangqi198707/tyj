-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014-06-10 10:44:41
-- 服务器版本: 5.1.34-community
-- PHP 版本: 5.2.9-2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `hk_wx`
--

-- --------------------------------------------------------

--
-- 表的结构 `manager`
--

CREATE TABLE IF NOT EXISTS `manager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `entry_time` int(11) NOT NULL,
  `update_time` int(11) DEFAULT NULL,
  `entry_id` int(10) unsigned NOT NULL,
  `update_id` int(10) unsigned DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `manager`
--

INSERT INTO `manager` (`id`, `name`, `password`, `email`, `tel`, `entry_time`, `update_time`, `entry_id`, `update_id`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '78227489@qq.com', '158********', 1362471353, 1369381835, 0, 1, 1),
(2, '123123', '4297f44b13955235245b2497399d7a93', '1231@dfd.com', '12312311', 1400213330, NULL, 1, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `wx_category`
--

CREATE TABLE IF NOT EXISTS `wx_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `property` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `entry_id` int(10) NOT NULL,
  `entry_time` int(11) NOT NULL,
  `update_id` int(10) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- 转存表中的数据 `wx_category`
--

INSERT INTO `wx_category` (`id`, `name`, `property`, `entry_id`, `entry_time`, `update_id`, `update_time`) VALUES
(8, 'test1', 'normal', 1, 1397183753, NULL, NULL),
(11, 'test33', 'normal', 1, 1397184131, NULL, NULL),
(12, 'test11', 'normal', 1, 1397184690, NULL, NULL),
(13, 'test33333', 'normal', 1, 1397185348, NULL, NULL),
(14, 'test444', 'normal', 1, 1397185354, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `wx_group`
--

CREATE TABLE IF NOT EXISTS `wx_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) DEFAULT '1',
  `entry_id` int(10) unsigned NOT NULL,
  `entry_time` int(11) NOT NULL,
  `update_id` int(10) unsigned DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`entry_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `wx_group`
--

INSERT INTO `wx_group` (`id`, `name`, `type`, `status`, `entry_id`, `entry_time`, `update_id`, `update_time`) VALUES
(3, 'test', 'new', 1, 1, 1397441957, NULL, NULL),
(4, 'aaa', 'new', 1, 1, 1397447047, 1, 1397803769),
(5, 'car', 'new', 1, 1, 1397804008, NULL, NULL),
(6, 'test111', 'random', 0, 1, 1398415393, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `wx_keyword`
--

CREATE TABLE IF NOT EXISTS `wx_keyword` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `groupid` int(10) NOT NULL,
  `count` int(10) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL,
  `entry_id` int(10) unsigned NOT NULL,
  `entry_time` int(11) NOT NULL,
  `update_id` int(10) unsigned DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groupid` (`groupid`,`status`,`entry_time`),
  KEY `status` (`status`,`entry_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `wx_keyword`
--

INSERT INTO `wx_keyword` (`id`, `name`, `groupid`, `count`, `status`, `entry_id`, `entry_time`, `update_id`, `update_time`) VALUES
(4, 'test', 3, 0, 1, 1, 1397441957, NULL, NULL),
(5, 'a', 4, 0, 1, 1, 1397447047, 1, 1397803769),
(6, 'car', 5, 2, 1, 1, 1397804008, NULL, NULL),
(7, 'aaa', 6, 0, 1, 1, 1398415393, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `wx_log`
--

CREATE TABLE IF NOT EXISTS `wx_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `groupid` int(10) NOT NULL,
  `keywordid` int(10) DEFAULT NULL,
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `msgid` int(10) NOT NULL,
  `entry_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupid` (`groupid`,`entry_time`),
  KEY `entry_time` (`entry_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `wx_log`
--

INSERT INTO `wx_log` (`id`, `username`, `content`, `groupid`, `keywordid`, `type`, `msgid`, `entry_time`) VALUES
(17, 'opXCkjp4ktEH1iGbCmFqoZ3E0gY4', '加关注', 0, NULL, 'text', 12, 1397449608),
(18, 'opXCkjp4ktEH1iGbCmFqoZ3E0gY4', 'car', 5, 6, 'text', 14, 1397804097),
(19, 'opXCkjp4ktEH1iGbCmFqoZ3E0gY4', 'car', 5, 6, 'text', 14, 1397804135),
(20, 'opXCkjp4ktEH1iGbCmFqoZ3E0gY4aa', '加关注', 0, NULL, 'text', 15, 1398335645),
(21, 'oftpatyvtqioVBxY-8jOvI1smtdM', '菜单事件http://panawx.dig24.cn/car/index', 0, NULL, 'view', 5, 1398668014),
(22, 'opXCkjp4ktEH1iGbCmFqoZ3E0gY4aabb', '加关注', 0, NULL, 'text', 24, 1399430109);

-- --------------------------------------------------------

--
-- 表的结构 `wx_menu`
--

CREATE TABLE IF NOT EXISTS `wx_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(11) NOT NULL,
  `msg_id` int(11) NOT NULL DEFAULT '0',
  `weight` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `entry_id` int(10) NOT NULL,
  `entry_time` int(11) NOT NULL,
  `update_id` int(10) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `wx_menu`
--

INSERT INTO `wx_menu` (`id`, `name`, `pid`, `msg_id`, `weight`, `status`, `entry_id`, `entry_time`, `update_id`, `update_time`) VALUES
(1, 'test111', 0, 0, 0, 0, 1, 1397197355, 1, 1397197539),
(2, 'aaabbb', 0, 0, 0, 0, 1, 1397197594, 1, 1397197597),
(3, 'aaa', 0, 0, 0, 0, 1, 1397197615, NULL, NULL),
(4, 'aaa', 0, 0, 0, 0, 1, 1397197663, NULL, NULL),
(5, 'aaa', 0, 0, 0, 0, 1, 1397197844, NULL, NULL),
(6, 'aaa', 0, 0, 5, 1, 1, 1397197856, NULL, NULL),
(7, 'bbbbb', 0, 0, 1, 0, 1, 1397198119, 1, 1397198130),
(8, 'ccc', 7, 0, 2, 0, 1, 1397198123, NULL, NULL),
(9, 'bbb', 0, 0, 1, 0, 1, 1397198138, 1, 1397198141),
(10, 'bbb', 0, 48, 9, 1, 1, 1397198148, NULL, NULL),
(11, 'b11', 10, 0, 2, 0, 1, 1397198154, 1, 1397198160),
(12, 'a1', 6, 53, 7, 1, 1, 1397198170, NULL, NULL),
(13, 'ccccdd', 0, 33, 0, 1, 1, 1397447369, 1, 1397447561),
(14, '222', 13, 0, 4, 0, 1, 1397447595, 1, 1397447604),
(15, 'bbb', 13, 34, 4, 0, 1, 1397447637, NULL, NULL),
(16, 'a2', 6, 8, 6, 1, 1, 1397447739, NULL, NULL),
(17, '111', 10, 51, 12, 1, 1, 1398301427, NULL, NULL),
(18, '2222', 10, 0, 6, 0, 1, 1398301716, 1, 1398301721),
(19, '222', 10, 52, 11, 1, 1, 1398301728, NULL, NULL),
(20, 'zzz', 13, 5, 1, 1, 1, 1398319844, NULL, NULL),
(21, 'dfdfd', 13, 62, 2, 1, 1, 1398320242, NULL, NULL),
(22, 'aaa', 6, 16, 8, 1, 1, 1398415521, NULL, NULL),
(23, 'vvv', 13, 17, 3, 1, 1, 1398415534, NULL, NULL),
(24, 'ddddd', 13, 0, 4, 1, 1, 1398415552, 1, 1398415556),
(25, '333', 10, 7, 10, 1, 1, 1398415593, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `wx_menu_msg`
--

CREATE TABLE IF NOT EXISTS `wx_menu_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `show_cover` int(1) NOT NULL DEFAULT '1',
  `abstract` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `imgurl` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multiple` int(1) DEFAULT NULL,
  `fid` int(1) NOT NULL DEFAULT '0',
  `show` int(1) NOT NULL DEFAULT '1',
  `cate_id` int(11) NOT NULL,
  `entry_id` int(10) NOT NULL,
  `entry_time` int(11) NOT NULL,
  `update_id` int(10) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `wx_menu_msg`
--

INSERT INTO `wx_menu_msg` (`id`, `type`, `title`, `author`, `show_cover`, `abstract`, `content`, `imgurl`, `link`, `multiple`, `fid`, `show`, `cate_id`, `entry_id`, `entry_time`, `update_id`, `update_time`) VALUES
(1, 'news', '111', NULL, 1, NULL, '[{"title":"111","author":"111","show_cover":"1","imgurl":"\\/upfile\\/wx\\/201404\\/1398826379_2027.jpg","content":"<p>111<br\\/><\\/p>","link":""},{"title":"222","author":"222","show_cover":"0","imgurl":"\\/upfile\\/wx\\/201404\\/1398826392_9596.jpg","content":"<p>222<br\\/><\\/p>","link":""},{"title":"333","author":"333","show_cover":"1","imgurl":"\\/upfile\\/wx\\/201404\\/1398826416_6570.jpg","content":"<p>333<br\\/><\\/p>","link":""}]', 'imgurl', 'link', 1, 0, 0, 14, 1, 1398654913, 1, 1398826430),
(2, 'news', '111', '111', 1, NULL, '&lt;p&gt;111&lt;br/&gt;&lt;/p&gt;', '/upfile/wx/201404/1398826379_2027.jpg', '', NULL, 1, 1, 14, 1, 1398654913, 1, 1398826430),
(3, 'news', '222', '222', 0, NULL, '&lt;p&gt;222&lt;br/&gt;&lt;/p&gt;', '/upfile/wx/201404/1398826392_9596.jpg', '', NULL, 1, 1, 14, 1, 1398654913, 1, 1398826430),
(4, 'news', '333', '333', 1, NULL, '&lt;p&gt;333&lt;br/&gt;&lt;/p&gt;', '/upfile/wx/201404/1398826416_6570.jpg', '', NULL, 1, 1, 14, 1, 1398654913, 1, 1398826430),
(5, 'view', NULL, NULL, 1, NULL, 'http://panawx.dig24.cn/car/index', NULL, NULL, NULL, 0, 1, 0, 1, 1398667918, NULL, NULL),
(6, 'news', '11', '', 1, '11', '<ul class=" list-paddingleft-2" style="list-style-type: square;"><li><p>11</p></li><li><p>22</p></li><li><p>33<br/></p></li></ul>', '/upfile/wx/201404/1398826248_8052.jpg', '', NULL, 0, 1, 13, 1, 1398825929, 1, 1398828895),
(7, 'news', 'test_新书：被高官强行染指：一夜激缠', '艾数达', 1, '新婚夜，为躲新郎她逃进他的房，一宿激缠，悦心蚀骨，醒来却发现他不是自己该爱的男人。本以为悄悄逃离，神不知鬼不觉，不曾想，一次人物专访，她与他再度相遇。', '<p>新婚夜被下药<br/><br/>临江而立的盛达酒店，是华淮市最昂贵、最奢华的五星级酒店，能在这儿举办婚宴的，一般都是非富即贵的有钱人家。今晚，在盛达顶楼的旋转宴会大厅里，一场豪华的婚礼正在举行。<br/><br/>“听说新娘子是下面小县城的，父母都下了岗，靠摆地摊为生。”<br/><br/>“这有什么，人长得漂亮就行。”<br/><br/>“嗤，我看她很一般，我若是化了妆，肯定比她还漂亮。”<br/><br/>“你比她漂亮也白搭，嘻嘻，谁让你的福气没有她的好？”<br/><br/>两个女人含满忌妒和羡慕，窃窃私语着经过门前喜迎宾客的一对新人，步进了富丽堂皇的喜宴大厅。<br/><br/>我的福气，真有这么好吗？苏若彤一袭白纱站在肖子易身边，精雕细琢后的俏脸依旧在甜甜微笑，内心，却一片涩然。<br/><br/>一个月前，肖子易犯下了不可饶恕的大错，他没能经受住诱惑，跟大学时期的恋人任菲儿上了床。对于肖子易来说，可悲的不是上床，而是跟任菲儿在床上翻云覆雨时，被突然归来的苏若彤抓了个正着。<br/><br/>倘若时间能倒流，倘若没有发生这件事，此时此刻，苏若彤肯定会认为自己是全天下最幸福的女人，只是……<br/><br/>正闪失，苏若彤突然瞧见任菲儿跟随几位同学，朝大厅这边走了过来，在七八个男同学中，身穿天蓝色吊带裙的任菲儿就是一道靓丽的风景线，特别抢眼夺目。<br/><br/>不用说，任菲儿的出现，令肖子易脸色大变，刚要张嘴喊保安，苏若彤却笑盈盈出了声：“子易，你招呼他们，我跟菲儿聊聊，呵呵，她这身裙子真漂亮。”<br/><br/>忍忍忍，就算不为肖家的脸面，为了她的爸爸妈妈，此刻，她也要将这把刀子吞下去。含笑说完，苏若彤十分亲热地挽住了任菲儿。<br/><br/>一个月前发生的事，这些同学并不知情，来前有所顾虑，是怕苏若彤计较以往那些陈谷子烂芝麻，现在见她对菲儿这般热情，同学们心头的那点小顾虑，也就完全被打消。<br/><br/>肖子易则非常不安，强装笑颜寒暄几句，赶紧将这帮哥们打发到了大厅，而后，快步朝前往新娘休息室的两个女人追了过去。闭眼也知道，菲儿绝对没安好心，他不能让她胡言乱语！<br/><br/>只是，肖子易还是迟了一步，等他追上去时，新娘休息室的门，却紧紧关上了。<br/><br/>好在时间不长，最多不过十分钟，紧闭着的门就被打开。<br/><br/>从休息室出来后，尽管滴血的心痛得要窒息，苏若彤却依然保持着最可人的笑容。是的，她不想发脾气不想使性子，更不想闹得人尽皆知。对于肖家来说，这是一件丑事，难道对她又何曾不是？<br/><br/>反正今晚要离婚，她没有必要像个泼妇一样大吵大闹。<br/><br/>整个喜宴，苏若彤一直在幸福地笑啊笑，哪怕脸笑僵了，她也没有让疲倦的面颊休息片刻，而且，几乎从不沾酒的她，居然帮肖子易代喝了一杯白酒。<br/><br/>苏若彤甜甜的笑容及亲昵的举动，渐渐化解了肖子易的不安，于是，所有的惶惶不安变为了兴奋与祈盼。<br/><br/>和她相处四年，他最多只能亲一亲，连摸摸她饱满的胸，她都会满脸羞赧将他推开。今晚，今晚她就要成为他的女人了。<br/><br/>想到这儿，肖子易心身激荡，对他的新婚之夜，更是充满了憧憬。<br/><br/>俩人的新房，就设在这个酒店之中，好不容易挨到闹新房的人离开，在肖子易关上新房门转身的那一刹那，苏若彤开口了。<br/><br/>“子易，离婚吧。”浑身的气力像是被抽尽，苏若彤的声音显得极其柔弱。<br/><br/>“你说什么？”肖子易没听清，晶亮的眸子，注满兴奋和激动。<br/><br/>“我要离婚！”<br/><br/>“你……不！我不离！”转眼间，他已卷到她面前，“我不知道这死女人跟你说了什么，但是若彤，你千万不要听信她的胡言乱语。她今天来的目的，就是想要咱俩的婚结不成，你不要上了她的当啊！”<br/><br/>“我上她的当？”苏若彤嗤鼻一笑，恨恨地，“那一幕，可是我亲眼所见。”<br/><br/>“这……这件事不是已经过去了，你不已原谅我了吗？”<br/><br/>像这种事情，怎么能过去得了？<br/><br/>原谅他，是她不想放弃四年的感情，是她相信了他的悔过，还有，是她拿不出保她弟弟出狱的那笔巨额。<br/><br/>“若彤，咱俩好不容易和好如初，你千万不要再受她的影响了。你想想看，一般出了这种状况，谁还有脸前来祝贺？可是，她偏偏来了，就冲着这一点，你就不应相信她的话呀。”<br/><br/>见她一脸伤心没反驳，肖子易暗自松了口气，然后放柔声音向她保证：“彤彤，我曾给你发过毒誓，现在我再次保证，保证这种事情再也不会发生，我肖子易这辈子只爱你，只爱我的彤彤！”<br/><br/>信誓旦旦说罢，唇一俯，就想亲她。苏若彤见状，猛力将他一推：“滚开！”<br/><br/>“若彤……”<br/><br/>冲他冷冷一哼，苏若彤将手机往豪华的婚床上一扔：“你自己听听吧。”<br/><br/>“是什么？”肖子易眼透茫然，看了看苏若彤，才一把抓起手机。随着拇指一阵忙碌，手机里便传来了男人粗重的喘息及女人愉悦得变了音的低喊。<br/><br/>“哦……嗯哦……舒……啊哟哟……舒服死了……易……我爱……啊哟哟……爽死我了……”<br/><br/>“小妖精，我让你爽！我让你舒服！”<br/><br/>接下来，就是一阵颠狂般的低吼和娇吟，不等剧烈的喘息平稳，娇媚的女声便发出了由衷的赞叹：“易，你真……真棒！我爱死你了……”<br/><br/>“亲爱的，我也……也爱死你这小身子了。”<br/><br/>“可你马上就要结……”<br/><br/>死贱人，她居然录了音！不等听完，肖子易脸色胀红，猛地按下了关闭。接下来说些什么，他当然清楚。当时他趴在她身上，说结了婚也没关系，说俩人还可以保持这种关系，因为她风 骚的身子，的确让他舍不得，可是现在……<br/><br/>假如任菲儿在此，肖子易悔恨之下，肯定会一刀将她捅死。用力将手机往床上一摔，他眼透惊慌，结结巴巴申辩说：“彤彤，男人在……在床上说的话，都是……是骗人的谎话，你不要当……当真了。”<br/><br/>“哦？是吗？那男人什么时候讲的话，才是真话？”<br/><br/>“这个……”肖子易急得满头大汗，吞吞吐吐半天，也没答上来。焦急中，他猛然抱住苏若彤恳求说，“彤彤，对不起，我知道说什么都无法抹去我的过错，但是错已经犯了，请你给我一次改过自新的机会，我真的知错了！”<br/><br/>“滚开！”苏若彤怒不可遏，一下将他推到几步开外，“肖子易，现在说什么都没有用，这个婚，我离定了！”<br/><br/>斩钉截铁扔下一句，苏若彤一头钻进了洗漱间。俩人吵吵闹闹近两个月，现在她一句话也不想与他多讲，决定稍作处理，然后离开这个让她疯狂的房间。<br/><br/>“彤彤！”望着紧闭的浴室门，肖子易傻了。和她相处几年，她刚烈的性格他深知，这一次，只怕真的玩完了。<br/><br/>自从大学毕业那年第一次见到她，他就发了疯似的爱上了她。苦追四年，等她毕业，眼看婚期临近，可在这个节骨眼上，他却没抗住菲儿这贱人的诱惑。我他妈的，真浑啊，怎么犯了这种错误。<br/><br/>不，我不能失去她，决不能！肖子易心一横，大步朝衣橱走过去。<br/><br/>在他随身携带的公文包里，有一盒citemn，这药是被捉奸在床之后他准备的，后来她原谅了他，就一直没派上用场。<br/><br/>若彤的思想非常传统，只要彻底成为了他的女人，她就不会再提出离婚了。<br/><br/>未完待续，欲知后事如何，请登录新浪原创订阅更多章节。支持作者，支持正版。<br/><br/></p>', '/upfile/wx/201405/1400550969_4758.jpg', 'http://www.ishowdata.com/wx', NULL, 0, 1, 14, 1, 1400551044, 1, 1400551619),
(8, 'news', '111', '111', 1, '111222', '<p>111222</p>', '/upfile/wx/201405/1401334389_7189.jpg', '', NULL, 0, 1, 13, 1, 1401334394, 1, 1401334633);

-- --------------------------------------------------------

--
-- 表的结构 `wx_message`
--

CREATE TABLE IF NOT EXISTS `wx_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `groupid` int(10) NOT NULL,
  `status` int(1) DEFAULT '1',
  `entry_id` int(10) unsigned NOT NULL,
  `entry_time` int(11) NOT NULL,
  `update_id` int(10) unsigned DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `groupid` (`groupid`,`status`,`entry_time`),
  KEY `status` (`status`,`entry_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- 转存表中的数据 `wx_message`
--

INSERT INTO `wx_message` (`id`, `type`, `content`, `groupid`, `status`, `entry_id`, `entry_time`, `update_id`, `update_time`) VALUES
(7, 'text', 'test', 3, 1, 1, 1397441957, NULL, NULL),
(8, 'news', '25', 3, 1, 1, 1397441957, NULL, NULL),
(9, 'text', 'bbbb', 4, 1, 1, 1397447047, 1, 1397803769),
(10, 'news', '8', 4, 1, 1, 1397447047, 1, 1397803769),
(12, 'text', '你好', -1, 1, 1, 1397447339, NULL, NULL),
(13, 'text', '<a href="#">1111</a>', 4, 1, 1, 1397803769, NULL, NULL),
(14, 'text', '<a href="http://panawx.dig24.cn/car/index">小汽车活动</a>', 5, 1, 1, 1397804008, NULL, NULL),
(15, 'text', '<span style="color: rgb(34, 34, 34); font-family: ''Microsoft YaHei'', 微软雅黑, Helvetica, 黑体, Arial, Tahoma; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 22.399999618530273px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;">你好，感谢您关注松下电器官方网站公众账号。</span><br style="color: rgb(34, 34, 34); font-family: ''Microsoft YaHei'', 微软雅黑, Helvetica, 黑体, Arial, Tahoma; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 22.399999618530273px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px;"><span style="color: rgb(34, 34, 34); font-family: ''Microsoft YaHei'', 微软雅黑, Helvetica, 黑体, Arial, Tahoma; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 22.399999618530273px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;">松下集团中国公益林绿色志愿者招募活动开始啦！</span><br style="color: rgb(34, 34, 34); font-family: ''Microsoft YaHei'', 微软雅黑, Helvetica, 黑体, Arial, Tahoma; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 22.399999618530273px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px;"><span style="color: rgb(34, 34, 34); font-family: ''Microsoft YaHei'', 微软雅黑, Helvetica, 黑体, Arial, Tahoma; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 22.399999618530273px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;">1000000棵树苗等你见证它们的种植和成长哦。</span><br style="color: rgb(34, 34, 34); font-family: ''Microsoft YaHei'', 微软雅黑, Helvetica, 黑体, Arial, Tahoma; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 22.399999618530273px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px;"><span style="color: rgb(34, 34, 34); font-family: ''Microsoft YaHei'', 微软雅黑, Helvetica, 黑体, Arial, Tahoma; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 22.399999618530273px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;">松下特别邀请你加入绿色志愿者的行列，跟我们一起远赴内蒙，在一片荒芜之中播下绿色的希望，筑起绿色的屏障。</span><br style="color: rgb(34, 34, 34); font-family: ''Microsoft YaHei'', 微软雅黑, Helvetica, 黑体, Arial, Tahoma; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 22.399999618530273px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px;"><span style="color: rgb(34, 34, 34); font-family: ''Microsoft YaHei'', 微软雅黑, Helvetica, 黑体, Arial, Tahoma; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 22.399999618530273px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;">要植树不要霾，为绿色益起来！</span><br style="color: rgb(34, 34, 34); font-family: ''Microsoft YaHei'', 微软雅黑, Helvetica, 黑体, Arial, Tahoma; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 22.399999618530273px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px;"><br style="color: rgb(34, 34, 34); font-family: ''Microsoft YaHei'', 微软雅黑, Helvetica, 黑体, Arial, Tahoma; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 22.399999618530273px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px;"><span style="color: rgb(34, 34, 34); font-family: ''Microsoft YaHei'', 微软雅黑, Helvetica, 黑体, Arial, Tahoma; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 22.399999618530273px; orphans: auto; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: auto; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255); display: inline !important; float: none;">&lt;a&nbsp;href="http://panasonic.cn/treeplanting_Inner_Mongolia_2014/index.html"&gt;&nbsp;点击即可参与互动和招募哦！~&lt;/a&gt;</span>', -1, 1, 1, 1398335549, NULL, NULL),
(26, 'text', 'ddd/::|', 6, 1, 1, 1398415393, NULL, NULL),
(27, 'news', '7', 6, 1, 1, 1398415393, NULL, NULL),
(28, 'news', '1', 6, 1, 1, 1398415393, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `wx_user`
--

CREATE TABLE IF NOT EXISTS `wx_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` int(1) DEFAULT NULL,
  `city_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `headimgurl` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wxkey` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `entry_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`wxkey`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

--
-- 转存表中的数据 `wx_user`
--

INSERT INTO `wx_user` (`id`, `nickname`, `sex`, `city_name`, `province`, `country`, `headimgurl`, `wxkey`, `entry_time`) VALUES
(30, '11111', NULL, NULL, NULL, NULL, 'http://wx.qlogo.cn/mmopen/XIUZibrcEr1ReiaLXafictd1tB1KFhTaJl8fPpn8VLWAsnCI1NDU07SjPRCPUASlelcwzQcBo6O5gUkCnbK7W0hshXCPkpXu9Pg/0', 'opXCkjp4ktEH1iGbCmFqoZ3E0gY4', 1397806899),
(31, '22222', NULL, NULL, NULL, NULL, NULL, 'opXCkjp4ktEH1iGbCmFqoZ3E0gY4aa', 1398335645),
(32, NULL, NULL, NULL, NULL, NULL, NULL, 'oftpatyvtqioVBxY-8jOvI1smtdM', 1398668066),
(33, '3333', NULL, NULL, NULL, NULL, NULL, '', 1),
(34, NULL, NULL, NULL, NULL, NULL, NULL, 'opXCkjp4ktEH1iGbCmFqoZ3E0gY4aabb', 1399430109);

-- --------------------------------------------------------

--
-- 表的结构 `wx_user_msg`
--

CREATE TABLE IF NOT EXISTS `wx_user_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `keyword` int(1) NOT NULL,
  `reply` int(1) NOT NULL,
  `star` int(1) NOT NULL,
  `entry_time` int(11) NOT NULL,
  `star_id` int(11) DEFAULT NULL,
  `star_time` int(11) DEFAULT NULL,
  `reply_id` int(11) DEFAULT NULL,
  `reply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_BOOK` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `wx_user_msg`
--

INSERT INTO `wx_user_msg` (`id`, `uid`, `type`, `content`, `keyword`, `reply`, `star`, `entry_time`, `star_id`, `star_time`, `reply_id`, `reply_time`) VALUES
(14, 30, '', 't', 0, 1, 1, 1397449660, 1, 1397450076, 1, 1397450098),
(15, 30, '', '123', 0, 0, 1, 1397617697, 1, 1397623347, NULL, NULL),
(16, 31, '', 'car', 1, 0, 1, 1397804098, 1, 1398415908, NULL, NULL),
(17, 31, '', 'car', 1, 1, 1, 1397804135, 1, 1398415905, 1, 1398415898);

--
-- 限制导出的表
--

--
-- 限制表 `wx_keyword`
--
ALTER TABLE `wx_keyword`
  ADD CONSTRAINT `wx_keyword_ibfk_1` FOREIGN KEY (`groupid`) REFERENCES `wx_group` (`id`);

--
-- 限制表 `wx_user_msg`
--
ALTER TABLE `wx_user_msg`
  ADD CONSTRAINT `FK_BOOK` FOREIGN KEY (`uid`) REFERENCES `wx_user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
