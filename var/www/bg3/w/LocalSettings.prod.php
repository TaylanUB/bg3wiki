<?php
# This file was automatically generated by the MediaWiki 1.37.0
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

require "/var/www/bg3/.secrets.php";

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

$wgSitename = "bg3.wiki";
$wgMetaNamespace = "bg3wiki";

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "/w";
$wgArticlePath = "/wiki/$1";

## The protocol and server name to use in fully-qualified URLs
$wgServer = "https://bg3.wiki";

## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL paths to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogos = [
	'1x'   => "/static/logo-135px.webp",
	'1.5x' => "/static/logo-202px.webp",
	'2x'   => "/static/logo-270px.webp",
];

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "bg3communitywiki@gmail.com";
$wgPasswordSender = "bg3communitywiki@gmail.com";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "mysql";
$wgDBserver = "localhost";
$wgDBname = "bg3wiki";
$wgDBuser = "bg3wiki";
#$wgDBpassword = "(set in secrets.php)";

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Shared database table
# This has no effect unless $wgSharedDB is also set.
$wgSharedTables[] = "actor";

## Shared memory settings
$wgMainCacheType = CACHE_ACCEL;
$wgParserCacheType = CACHE_ACCEL;
$wgSessionCacheType = CACHE_ACCEL;
$wgMessageCacheType = CACHE_ACCEL;
$wgMemCachedServers = [];

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = true;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale. This should ideally be set to an English
## language locale so that the behaviour of C library functions will
## be consistent with typical installations. Use $wgLanguageCode to
## localise the wiki.
$wgShellLocale = "C.UTF-8";

# Site language code, should be one of the list in ./languages/data/Names.php
$wgLanguageCode = "en";

# Time zone
$wgLocaltimezone = "Europe/Berlin";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publicly accessible from the web.
$wgCacheDirectory = "$IP/cache";

#$wgSecretKey = "(set in secrets.php)";

# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
#$wgUpgradeKey = "(set in secrets.php)";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = "bg3wiki:Copyrights";
$wgRightsUrl = "";
$wgRightsText = "CC BY-NC-SA 4.0 or CC BY-SA 4.0";
$wgRightsIcon = null;

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

# End of automatically generated settings.
# Add more configuration options below.

################################################################################
################################################################################

$devSite = false;
$debugMode = false;

if ( $_SERVER['SERVER_NAME'] === 'dev.bg3.wiki' ) {
	$devSite = true;
	$wgServer = "https://dev.bg3.wiki";
}

if ( $devSite && $_SERVER['REMOTE_ADDR'] == $taylanIpAddr ) {
	#$wgDebugLogFile = "/tmp/mw-debug.log";
	$wgDebugToolbar = true;
	$wgShowExceptionDetails = true;
	$wgShowDBErrorBacktrace = true;
	$wgShowSQLErrors = true;
}

wfLoadExtensions([
	"ArrayFunctions",
	"Arrays",
	"Cargo",
	"CategoryTree",
	"CheckUser",
	"CirrusSearch",
	"Cite",
	"CodeEditor",
	"CodeMirror",
	"ConfirmEdit",
	"ConfirmEdit/QuestyCaptcha",
	"ContributionScores",
	# Potentially unsafe.
	#"CSS",
	"DeleteBatch",
	"DiscussionTools",
	"Echo",
	"Elastica",
	"EmbedVideo",
	"DiscordRCFeed",
	"HTMLTags",
	"ImageMap",
	"JsonConfig",
	"LabeledSectionTransclusion",
	# Incompatible with CodeMirror: https://phabricator.wikimedia.org/T300618
	#"LinkSuggest",
	"Linter",
	"LocalVariables",
	"Loops",
	"MassEditRegex",
	"Math",
	"MobileDetect",
	"MobileFrontend",
	"NamespacePreload",
	"PageImages",
	"PageNotice",
	"ParserFunctions",
	"Poem",
	"Popups",
	"PortableInfobox",
	"RegexFunctions",
	"SearchDigest",
	"Scribunto",
	"SimpleBatchUpload",
	"SpamBlacklist",
	"SyntaxHighlightThemes",
	"SyntaxHighlight_GeSHi",
	"TabberNeue",
	"TemplateData",
	"TemplateStyles",
	"TemplateStylesExtender",
	"TextExtracts",
	"Theme",
	"Variables",
	"VisualEditor",
	"Widgets",
	"WikiEditor",
	"WikiSEO",
]);

#
# Skins
#

wfLoadSkin("Vector");
$wgDefaultSkin = "vector";
$wgDefaultTheme = "dark-grey"; # Extension:Theme
$wgSkipThemes = [
	'vector' => [ 'dark' => true ]
];

wfLoadSkin("Citizen");
$wgCitizenThemeDefault = "dark";
$wgDefaultMobileSkin = "Citizen"; # Extension:MobileFrontend

# Add CSS classes to body depending on whether user is logged in
$wgHooks['OutputPageBodyAttributes'][] = function( $out, $skin, &$attrs ) {
	if ( $out->getUser()->getId() == 0 ) {
		$attrs['class'] .= ' mw-anonymous';
	} else {
		$attrs['class'] .= ' mw-logged-in';
	}
};

# Add footer link to Copyrights page
$wgHooks['SkinAddFooterLinks'][] = function ( $skin, $key, &$links ) {
	if ( $key !== 'places' ) {
		return;
	}
	$links['copyright'] = $skin->footerLink(
		'bg3wiki-copyrights-text',
		'bg3wiki-copyrights-page'
	);
};

#
# Advertisement
#

function bg3wikiAdsEnabled( OutputPage $out ) {
	$user = $out->getUser();
	if ( $user->isRegistered() ) {
		return false;
	}
	$ns = $out->getTitle()->getNamespace();
	if ( !bg3wikiAdsEnabledNs($ns) ) {
		return false;
	}
	if ( isset($_COOKIE['bg3wiki_noads']) ) {
		return false;
	}
	return true;
}

function bg3wikiAdsEnabledNs( $ns ) {
	switch ( $ns ) {
		case NS_MAIN:
		case NS_FILE:
		case NS_SPECIAL:
		case NS_CATEGORY:
			return true;
		default:
			return false;
	}
}

# Add CSS class to body depending on whether ads should be enabled
$wgHooks['OutputPageBodyAttributes'][] = function( $out, $skin, &$attrs ) {
	if ( bg3wikiAdsEnabled( $out ) ) {
		$attrs['class'] .= ' mw-ads-enabled';
	} else {
		$attrs['class'] .= ' mw-ads-disabled';
	}
};

#
# We implement three ad units right now:
#
#   Header
#   Top/top-right static banner on desktop (Vector)
#
#   Sidebar
#   Sticky vertical in sidebar on desktop (Vector)
#
#   Footer
#   Sticky footer on mobile (Citizen)
#

$wgHooks['SiteNoticeAfter'][] = function ( &$html, $skin ) {
	if ( !bg3wikiAdsEnabled( $skin->getOutput() ) ) {
		return;
	}
	if ( $skin->getSkinName() !== "vector" ) {
		return;
	}
	$html .= <<< EOF
	  <div id='bg3wiki-header-ad'>
	    <p>Ad placeholder</p>
	    <div id='bg3wiki-header-ad-fuse' data-fuse='23198268145'></div>
	    <div id='bg3wiki-header-ad-ramp'></div>
	  </div>
	EOF;
};

$wgHooks['SkinAfterPortlet'][] = function( $skin, $portletName, &$html ) {
	if ( !bg3wikiAdsEnabled( $skin->getOutput() ) ) {
		return;
	}
	if ( $skin->getSkinName() !== "vector" ) {
		return;
	}
	if ( $portletName !== "Advertisement" ) {
		return;
	}
	$html .= <<< EOF
	  <div id='bg3wiki-sidebar-ad'>
	    <p>Ad placeholder</p>
	    <div id='bg3wiki-sidebar-ad-fuse' data-fuse='23198268148'></div>
	    <div id='bg3wiki-sidebar-ad-ramp'></div>
	  </div>
	  <p id='bg3wiki-ad-provider-notice'></p>
	EOF;
};

$wgHooks['SkinAfterContent'][] = function( &$html, $skin ) {
	if ( !bg3wikiAdsEnabled( $skin->getOutput() ) ) {
		return;
	}
	if ( $skin->getSkinName() !== "citizen" ) {
		return;
	}
	$html .= <<< EOF
	  <div id='bg3wiki-footer-ad'>
	    <p>Ad placeholder</p>
	    <div id='bg3wiki-footer-ad-fuse' data-fuse='23198268151'></div>
	    <div id='bg3wiki-footer-ad-ramp'></div>
	  </div>
	  <p id='bg3wiki-ad-provider-notice'></p>
	EOF;

};

$wgHooks['SkinAfterBottomScripts'][] = function ( $skin, &$html )
	use ( $devSite )
{
	if ( !bg3wikiAdsEnabled( $skin->getOutput() ) ) {
		return;
	}
	if ( $devSite ) {
		$html .= '<script src="/js/ads.dev.js"></script>';
	} else {
		$html .= '<script src="/js/ads.prod.js"></script>';
	}
};

#
# Namespaces
#

define( 'NS_GUIDE',        3000 );
define( 'NS_GUIDE_TALK',   3001 );
define( 'NS_MODDING',      3002 );
define( 'NS_MODDING_TALK', 3003 );
define( 'NS_MODS',         3004 );
define( 'NS_MODS_TALK',    3005 );

# Would be defined by Scribunto later, but we want it now.
# Defining an NS constant here is supported by MediaWiki; see:
# includes/registration/ExtensionProcessor.php (1.39.7)
define( 'NS_MODULE',      828 );
define( 'NS_MODULE_TALK', 829 );

$wgExtraNamespaces[NS_GUIDE] = 'Guide';
$wgExtraNamespaces[NS_GUIDE_TALK] = 'Guide_talk';
$wgExtraNamespaces[NS_MODDING] = 'Modding';
$wgExtraNamespaces[NS_MODDING_TALK] = 'Modding_talk';
$wgExtraNamespaces[NS_MODS] = 'Mods';
$wgExtraNamespaces[NS_MODS_TALK] = 'Mods_talk';

$wgContentNamespaces[] = NS_GUIDE;
$wgContentNamespaces[] = NS_MODDING;
$wgContentNamespaces[] = NS_MODS;

$wgSitemapNamespaces = $wgContentNamespaces;

$wgNamespacesWithSubpages[NS_MAIN] = true;
$wgNamespacesWithSubpages[NS_GUIDE] = true;
$wgNamespacesWithSubpages[NS_MODDING] = true;
$wgNamespacesWithSubpages[NS_MODS] = true;

$wgVisualEditorAvailableNamespaces['Help'] = true;
$wgVisualEditorAvailableNamespaces['Guides'] = true;
$wgVisualEditorAvailableNamespaces['Modding'] = true;

$wgNamespaceAliases = [
	'mw' => NS_MEDIAWIKI,
	't' => NS_TEMPLATE,
	'f' => NS_FILE,
	'c' => NS_CATEGORY,
	'lua' => NS_MODULE,
];

#
# General
#

#$wgReadOnly = 'Server transfer in progress; please save your changes in a text file and try again later.';

# Serve Main_Page as https://bg3.wiki/
$wgMainPageIsDomainRoot = true;

# Add rel="canonical" link tags
$wgEnableCanonicalServerLink = true;

# Open external links in new tab
$wgExternalLinkTarget = '_blank';

# Allow pages to override their title
$wgRestrictDisplayTitle = false;

# Enable fancy Wikitext editing
$wgDefaultUserOptions['usecodemirror'] = 1;

$wgAllowUserCss = true;
$wgAllowUserJs = true;

$wgFileExtensions[] = 'webm';
$wgFileExtensions[] = 'mp4';

$wgGalleryOptions['mode'] = 'packed';

$wgMaxPPExpandDepth = 200;

$wgTidyConfig = [
	'driver' => 'RemexHtml',
	'pwrap' => false,
];

# For when working on MW:Vector.css and such
#$wgResourceLoaderMaxage['unversioned'] = 20;

#
# Security
#

$wgPasswordAttemptThrottle = [
	[ 'count' => 10, 'seconds' => 600 ]
];

#
# Performance
#

# We use a systemd service for this
$wgJobRunRate = 0;

# Don't invalidate caches every time this file is edited
$wgInvalidateCacheOnLocalSettingsChange = false;

# Update this to invalidate caches manually instead
$wgCacheEpoch = 20240528030000;

# Parser cache lasts 10 days
$wgParserCacheExpiryTime = 10 * 24 * 60 * 60;

# Allow caching via reverse proxy
# In our case this is just the Nginx FCGI cache
$wgUseCdn = !$devSite;
$wgCdnMaxAge = 3600;

# Make MediaWiki send PURGE requests to Nginx
# Note that this implicitly uses port 1080
$wgCdnServers = [ '127.0.0.1' ];
$wgInternalServer = 'http://bg3.wiki';

# Seems to cause issues?
#$wgEnableSidebarCache = true;
#$wgSidebarCacheExpiry = 3600;

#
# SEO
#

# Add <meta name="robots" content="noindex,nofollow"/>
# to all pages outside the main and guide namespaces.
#
# Jan 2024: Should not be necessary anymore, since our
# rankings are quite solid; just let the crawlers do
# what they want to do, and let people find all our
# pages in search results.
#
#$wgDefaultRobotPolicy = 'noindex,nofollow';
#$wgNamespaceRobotPolicies[NS_MAIN] = 'index,follow';
#$wgNamespaceRobotPolicies[NS_GUIDE] = 'index,follow';
#$wgNamespaceRobotPolicies[NS_MODDING] = 'index,follow';
#$wgNamespaceRobotPolicies[NS_MODS] = 'index,follow';

# We're careful about spammers; no need for this
$wgNoFollowLinks = false;

#
# Email
#

$wgSMTP = [
	'host' => 'ssl://smtp.gmail.com',
	'IDHost' => 'bg3.wiki',
	'port' => 465,
	'username' => 'bg3communitywiki@gmail.com',
	'password' => $gmailAppPassword,
	'auth' => true
];

#
# Autoconfirm
#

$wgAutoConfirmAge = 10;
$wgAutoConfirmCount = 3;

$wgGroupPermissions['autoconfirmed']['autopatrol'] = true;
# Extension:ConfirmEdit
$wgGroupPermissions['autoconfirmed']['skipcaptcha'] = true;
# Extension:SpamBlacklist
$wgGroupPermissions['autoconfirmed']['sboverride'] = true;

#
# Search
#

$wgSearchType = 'CirrusSearch';

$wgNamespacesToBeSearchedDefault = [
	NS_MAIN => true,
	NS_TALK => true,
	NS_FILE => true,
	NS_FILE_TALK => true,
	NS_HELP => true,
	NS_HELP_TALK => true,
	NS_CATEGORY => true,
	NS_CATEGORY_TALK => true,
	NS_GUIDE => true,
	NS_GUIDE_TALK => true,
	NS_MODDING => true,
	NS_MODDING_TALK => true,
	NS_MODS => true,
	NS_MODS_TALK => true,
];

#$wgDisableSearchUpdate = true;

#
# User groups & permissions
#

$wgAvailableRights[] = 'editmodules';
$wgAvailableRights[] = 'editproject';
$wgAvailableRights[] = 'edittemplates';

$wgRestrictionLevels[] = 'editinterface';
$wgRestrictionLevels[] = 'editmodules';
$wgRestrictionLevels[] = 'editproject';
$wgRestrictionLevels[] = 'edittemplates';
$wgRestrictionLevels[] = 'protect';

$wgGroupPermissions['*']['createpage'] = false;
$wgGroupPermissions['user']['createpage'] = true;

$wgGroupPermissions['maintainer']['delete'] = true;
$wgGroupPermissions['maintainer']['patrol'] = true;
$wgGroupPermissions['maintainer']['protect'] = true;
$wgGroupPermissions['maintainer']['editmodules'] = true;
$wgGroupPermissions['maintainer']['editproject'] = true;
$wgGroupPermissions['maintainer']['edittemplates'] = true;
$wgGroupPermissions['maintainer']['recreatecargodata'] = true;

$wgGroupPermissions['sysop']['checkuser'] = true;
$wgGroupPermissions['sysop']['checkuser-log'] = true;
$wgGroupPermissions['sysop']['investigate'] = true;
$wgGroupPermissions['sysop']['checkuser-temporary-account'] = true;

$wgNamespaceProtection[NS_TEMPLATE] = ['edittemplates'];
$wgNamespaceProtection[NS_PROJECT] = ['editproject'];
$wgNamespaceProtection[NS_MODULE] = ['editmodules'];

# To allow the public to see deleted content:
#$wgGroupPermissions['*']['deletedhistory'] = true;
#$wgGroupPermissions['*']['browsearchive'] = true;
#$wgGroupPermissions['*']['deletedtext'] = true;

####################################
#                                  #
# Extension-specific configuration #
#                                  #
####################################

#
# CAPTCHA
#

$wgCaptchaQuestions = [
	"Which class plays instruments? (Create an account to skip CAPTCHA.)" => "bard",
	"Which class uses nature magic? (Create an account to skip CAPTCHA.)" => "druid",
	"Which class uses unarmed combat? (Create an account to skip CAPTCHA.)" => "monk",
	"What year was the game released? (Create an account to skip CAPTCHA.)" => "2023",
	"The second word in the game's name? (Create an account to skip CAPTCHA.)" => "gate",
];

$wgCaptchaTriggers['edit']          = true;
$wgCaptchaTriggers['create']        = true;
$wgCaptchaTriggers['createtalk']    = true;
$wgCaptchaTriggers['addurl']        = true;
$wgCaptchaTriggers['createaccount'] = true;
$wgCaptchaTriggers['badlogin']      = true;

#
# Cargo
#

$wgCargoDBtype = "mysql";
$wgCargoDBserver = "localhost";
$wgCargoDBname = "bg3wiki-cargo";
$wgCargoDBuser = "bg3wiki-cargo";
$wgCargoMaxQueryLimit = 5000;
#$wgCargoDBpassword = "(set in secrets.php)";

#
# Contribution Scores
#

$wgContribScoreDisableCache = true;
$wgContribScoreCacheTTL = 0.1;
$wgContribScoreReports = [
    [ 30, 20 ],
    [ 0, 200 ],
];

#
# Discord RC Feed
#

$wgRCFeeds['discord'] = [
	'url' => $discordRCFeedWebhookUri,
	'omit_minor' => true,
	'omit_talk' => true,
	'omit_namespaces' => [ NS_FILE, NS_USER, NS_MEDIAWIKI ],
];

$wgRCFeeds['discord_file'] = [
	'url' => $discordRCFeedFileWebhookUri,
	'only_namespaces' => [ NS_FILE ],
];

$wgRCFeeds['discord_talk'] = [
	'url' => $discordRCFeedTalkWebhookUri,
	'omit_minor' => true,
	'only_talk' => true,
	'omit_namespaces' => [ NS_USER_TALK ],
];

$wgRCFeeds['discord_untrusted'] = [
	'url' => $discordRCFeedUntrustedWebhookUri,
	'omit_patrolled' => true,
];

#
# HTML Tags
#

$wgHTMLTagsAttributes['details'] = [ 'class', 'style', 'open' ];
$wgHTMLTagsAttributes['summary'] = [ 'class', 'style' ];

#
# JSON Config
#

$wgJsonConfigEnableLuaSupport = true;
$wgJsonConfigModels['Tabular.JsonConfig'] = 'JsonConfig\JCTabularContent';
$wgJsonConfigs['Tabular.JsonConfig'] = [
        'namespace' => 486,
        'nsName' => 'Data',
        // page name must end in ".tab", and contain at least one symbol
        'pattern' => '/.\.tab$/',
        'license' => 'CC0-1.0',
        'isLocal' => false,
];

$wgJsonConfigModels['Map.JsonConfig'] = 'JsonConfig\JCMapDataContent';
$wgJsonConfigs['Map.JsonConfig'] = [
        'namespace' => 486,
        'nsName' => 'Data',
        // page name must end in ".map", and contain at least one symbol
        'pattern' => '/.\.map$/',
        'license' => 'CC0-1.0',
        'isLocal' => false,
];
$wgJsonConfigInterwikiPrefix = "commons";

$wgJsonConfigs['Tabular.JsonConfig']['remote'] = [
        'url' => 'https://commons.wikimedia.org/w/api.php'
];
$wgJsonConfigs['Map.JsonConfig']['remote'] = [
        'url' => 'https://commons.wikimedia.org/w/api.php'
];

#
# Loops
#

$egLoopsCountLimit = 1000;

#
# MassEditRegex
#

$wgGroupPermissions['sysop']['masseditregex'] = true;

#
# MobileFrontend
#

$wgMFCollapseSectionsByDefault = false;

# Non-blocking loading of Mobile.css causes Citizen colors to
# change after the page becomes visible, which isn't nice.
$wgMFSiteStylesRenderBlocking = true;

# Image lazy loading causes weird bugs with PortableInfobox.
$wgMFLazyLoadImages = [
	'beta' => false,
	'base' => false,
];

#
# PageImages
#

$wgPageImagesLeadSectionOnly = false;

#
# ParserFunctions
#

$wgPFEnableStringFunctions = true;

#
# Scribunto
#

$wgScribuntoDefaultEngine = 'luasandbox';
$wgScribuntoUseGeSHi = true;
$wgScribuntoUseCodeEditor = true;
$wgScribuntoEngineConf['luasandbox']['allowEnvFuncs'] = false;

#
# SpamBlacklist
#

# Just use the following wiki pages:
# MediaWiki:Spam-blacklist
# MediaWiki:Spam-whitelist
$wgSpamBlacklistSettings = [];

$wgLogSpamBlacklistHits = true;

#
# SyntaxHighlightThemes
#

$wgDefaultUserOptions['syntaxhighlight-theme'] = 'stata-dark';

#
# TextExtracts
#

# We would use this to remove 'div' from the list, but it seems
# that the defaults cannot be removed, probably because the
# extension copies the default config value somewhere on init.
# Instead, modify: ./extensions/TextExtracts/extension.json
#$wgExtractsRemoveClasses = [];

#
# Variables
#

$egVariablesDisabledFunctions = [ 'var_final' ];

#
# WikiSEO
#

$wgGoogleSiteVerificationKey = 'AFZzz9W5H3CmDLSRstrLBj7jyuQqJCrOwX1IS01k1MA';

$wgWikiSeoOverwritePageImage = true;

$wgTwitterCardType = 'summary';
$wgTwitterSiteHandle = "@bg3_wiki";

#
# END OF FILE
#
