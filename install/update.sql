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
INSERT INTO `pre_config` VALUES ('title', '云托盘');
INSERT INTO `pre_config` VALUES ('keywords', '免费网盘, 免费图床, 临时网盘, 文件仓库, 文件外链, 文件猎奇, 免费外链, 游客上传');
INSERT INTO `pre_config` VALUES ('description', '平步云端');
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
INSERT INTO `pre_config` VALUES ('gg_file', '网站所有文件内容均由用户自行上传分享，本站严格遵守国家相关法律法规，尊重著作权、版权等第三方权利，如果当前文件侵犯了您的相关权利，请邮件反馈至@qq.com，我们将及时处理。');

ALTER TABLE `udisk` RENAME TO `pre_file`;

ALTER TABLE `pre_file`
CHANGE COLUMN `filename` `name` varchar(255) NOT NULL,
CHANGE COLUMN `datetime` `addtime` datetime NOT NULL,
CHANGE COLUMN `fileurl` `hash` varchar(32) NOT NULL,
MODIFY COLUMN `type` varchar(50) DEFAULT NULL,
MODIFY COLUMN `size` int(11) unsigned NOT NULL,
ADD COLUMN `count` int(11) unsigned NOT NULL DEFAULT '0';

ALTER TABLE `pre_file`
ADD INDEX `hash` (`hash`);
