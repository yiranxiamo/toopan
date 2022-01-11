DROP TABLE IF EXISTS `pre_config`;
create table `pre_config` (
  `k` varchar(32) NOT NULL,
  `v` text NULL,
  PRIMARY KEY  (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pre_config` VALUES ('cache', '');
INSERT INTO `pre_config` VALUES ('admin_user', 'admin');
INSERT INTO `pre_config` VALUES ('admin_pwd', '123456');
INSERT INTO `pre_config` VALUES ('blackip', '');
INSERT INTO `pre_config` VALUES ('title', '云端托盘');
INSERT INTO `pre_config` VALUES ('en_title', 'Cloud tray');
INSERT INTO `pre_config` VALUES ('keywords', '免费网盘, 免费图床, 临时网盘, 文件外链, 文件猎奇, 免费外链, 游客上传');
INSERT INTO `pre_config` VALUES ('en_keywords', 'Free network disk, free map bed, temporary network disk, file outside chain, free outside chain, tourists upload');
INSERT INTO `pre_config` VALUES ('description', '云托盘提供临时文件分享与图床服务');
INSERT INTO `pre_config` VALUES ('en_description', 'Cloud tray provides temporary file sharing and mapping services');
INSERT INTO `pre_config` VALUES ('storage', 'local');
INSERT INTO `pre_config` VALUES ('filepath', '');
INSERT INTO `pre_config` VALUES ('aliyun_ak', '');
INSERT INTO `pre_config` VALUES ('aliyun_sk', '');
INSERT INTO `pre_config` VALUES ('name_block', '');
INSERT INTO `pre_config` VALUES ('type_block', '');
INSERT INTO `pre_config` VALUES ('type_image', 'png|jpg|jpeg|gif|bmp|webp|ico|svg|svgz|tif|tiff');
INSERT INTO `pre_config` VALUES ('type_audio', 'mp3|wav|wma|ogg|m4a|flac|aac|dts|ac3');
INSERT INTO `pre_config` VALUES ('type_video', 'mp4|webm|flv|f4v|mov|3gp|3gpp|avi|mpg|mpeg|wmv|mkv|ts|m2ts');
INSERT INTO `pre_config` VALUES ('green_check', '0');
INSERT INTO `pre_config` VALUES ('green_check_region', 'cn-beijing');
INSERT INTO `pre_config` VALUES ('green_check_porn', '0');
INSERT INTO `pre_config` VALUES ('green_check_terrorism', '0');
INSERT INTO `pre_config` VALUES ('green_label_porn', 'sexy,porn');
INSERT INTO `pre_config` VALUES ('green_label_terrorism', 'bloody,explosion,outfit,logo,weapon,politics');
INSERT INTO `pre_config` VALUES ('gg_file', '这个仓库的所有内容都是由用户自己上传和分享的。本网站严格遵守国家有关法律法规，尊重著作权、版权等第三方权利。如果目前的文件侵犯了您的权利，请及时报告给我们，我们会及时处理。');
INSERT INTO `pre_config` VALUES ('en_gg_file', 'All content in the repository is uploaded and Shared by users themselves.This website strictly complies with relevant national laws and regulations, and respects copyright, copyright and other rights of third parties.If the current document violates your rights, please report it to us in time and we will deal with it promptly.');

DROP TABLE IF EXISTS `pre_file`;
CREATE TABLE `pre_file` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `size` int(11) unsigned NOT NULL,
  `hash` varchar(32) NOT NULL,
  `addtime` datetime NOT NULL,
  `lasttime` datetime DEFAULT NULL,
  `ip` varchar(15) NOT NULL,
  `hide` int(1) NOT NULL DEFAULT '0',
  `pwd` varchar(255) DEFAULT NULL,
  `block` int(1) NOT NULL DEFAULT '0',
  `count` int(11) unsigned NOT NULL DEFAULT '0',
   PRIMARY KEY (`id`),
   KEY `hash` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
