(function(){

if (innerWidth >= 320 && innerHeight >= 720) {
	enableAds();
} else {
	addEventListener('resize', maybeEnableAds);
}

function maybeEnableAds() {
	if (innerWidth < 320 || innerHeight < 720) {
		return;
	}

	enableAds();

	removeEventListener('resize', maybeEnableAds);
}

function enableAds() {
	const query = new URLSearchParams(location.search);
	let provider = query.get('ad_provider');
	if (provider == null) {
		if (Math.random() < 0.5) {
			provider = 'playwire';
		} else {
			provider = 'publift';
		}
	}

	console.log("Enabling ads for: " + provider);

	loadAdScript(provider);

	const notice = document.getElementById('bg3wiki-ad-provider-notice');
	notice.innerText = 'Ads provided by: ' + provider;
}

function loadAdScript(provider) {
	let src;
	if (provider == 'playwire') {
		ramp = {};
		ramp.que = [];
		ramp.passiveMode = true;
		ramp.que.push(rampSetup);
		src = '//cdn.intergient.com/1025372/75208/ramp.js';
	} else {
		fusetag = {};
		fusetag.que = [];
		fusetag.que.push(fuseSetup);
		src = '//cdn.fuseplatform.net/publift/tags/2/3741/fuse.js';
	}

	const script = document.createElement('script');
	script.async = true;
	script.src = src;
	script.onload = function(){
		console.log('Done loading ads JS.');
	};
	script.onerror = function(){
		console.log('Error loading ads JS.');
	};
	document.body.appendChild(script);
}

function rampSetup() {
	const classes = document.body.classList;
	if (!classes.contains('skin-citizen')) {
		console.log('Not on mobile.');
		ramp.spaNewPage();
		return;
	}

	let newPage = true;

	function setFooterXL() {
		setFooter('footer-970-wide', 'standard_iab_foot2');
	}

	function setFooterL() {
		setFooter('large-portrait-tablet', 'standard_iab_foot2');
	}

	function setFooterM() {
		setFooter('ROS', 'standard_iab_foot1');
	}

	function setFooterS() {
		setFooter('ROS', 'standard_iab_foot1');
	}

	function setNoFooter() {
		setFooter('ROS', null);
	}

	function setFooter(path, type) {
		console.log(`New Footer: ${path}/${type}`);

		if (ramp.settings.cp == path) {
			setType();
		} else {
			ramp.setPath(path).then(setType);
		}

		function setType() {
			ramp.destroyUnits('all').then(() => {
				if (type == null) {
					if (newPage) {
						ramp.spaNewPage();
						newPage = false;
					}
					return;
				}
				ramp.addUnits({
					type: type,
					selectorId: 'bg3wiki-footer-ad-ramp',
				}).then(() => {
					if (newPage) {
						ramp.spaNewPage();
						newPage = false;
					} else {
						ramp.displayUnits();
					}
				});
			});
		}
	}

	const sizes = [
		[ [970, 1024], setFooterXL ],
		[ [728, 1024], setFooterL  ],
		[ [468,  720], setFooterM  ],
		[ [320,  720], setFooterS  ],
	];

	function footerSetterForScreenSize() {
		for (const entry of sizes) {
			const dimens = entry[0];
			const setter = entry[1];
			const w = dimens[0];
			const h = dimens[1];
			if (innerWidth >= w && innerHeight >= h) {
				return setter;
			}
		}
		return setNoFooter;
	}

	let setter = footerSetterForScreenSize();
	setter();

	function onResize() {
		const newSetter = footerSetterForScreenSize();
		if (setter != newSetter) {
			setter = newSetter;
			setter();
		}
	}

	let timeout;
	const delay = 200;
	function debouncedOnResize() {
		clearTimeout(timeout);
		timeout = setTimeout(onResize, delay);
	}

	addEventListener('resize', debouncedOnResize);
}

function fuseSetup() {
	const classes = document.body.classList;
	if (!classes.contains('skin-citizen')) {
		console.log('Not on mobile.');
		return;
	}

	// IDs to be changed
	const footerFuseIds = [
		[ [970, 1024], '23198268151' ],
		[ [728, 1024], '23198268151' ],
		[ [468,  720], '23198268151' ],
		[ [320,  720], '23198268151' ],
	];

	function footerFuseIdForScreenSize() {
		for (const entry of footerFuseIds) {
			const dimens = entry[0];
			const fuseId = entry[1];
			const w = dimens[0];
			const h = dimens[1];
			if (innerWidth >= w && innerHeight >= h) {
				return fuseId;
			}
		}
		return null;
	}

	function replaceFooterAdZone(fuseId) {
		console.log('Replacing footer fuseId to: ' + fuseId);

		const outerDivId = 'bg3wiki-footer-ad';
		const innerDivId = 'bg3wiki-footer-ad-fuse';

		const outerDiv = document.getElementById(outerDivId);
		const innerDiv = document.getElementById(innerDivId);
		if (innerDiv != null) {
			outerDiv.removeChild(innerDiv);
		}

		if (fuseId != null) {
			const newDiv = document.createElement('div');
			newDiv.id = innerDivId;
			newDiv.setAttribute('data-fuse', fuseId);
			outerDiv.appendChild(newDiv);

			fusetag.registerZone(innerDivId);
		}
	}

	let footerFuseId = footerFuseIdForScreenSize();
	replaceFooterAdZone(footerFuseId);

	function onResize() {
		const newFuseId = footerFuseIdForScreenSize();
		if (footerFuseId != newFuseId) {
			footerFuseId = newFuseId;
			replaceFooterAdZone(footerFuseId);
		}
	}

	let timeout;
	const delay = 200;
	function debouncedOnResize() {
		clearTimeout(timeout);
		timeout = setTimeout(onResize, delay);
	}

	addEventListener('resize', debouncedOnResize);
}

})()
