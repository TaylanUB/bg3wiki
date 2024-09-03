(function(){

/*
 * Note: CSS viewport width/height doesn't match innerWidth/innerHeight!
 * Use window.matchMedia to make sure we're in sync with CSS.
 */

function matchMinWH(w, h) {
	return matchMedia(
		`(min-width: ${w}px) and (min-height: ${h}px)`
	);
}

let matcher = matchMinWH(320, 600);

if (matcher.matches) {
	enableAds();
} else {
	matcher.onchange = function() {
		if (matcher.matches) {
			matcher.onchange = null;
			matcher = null;
			enableAds();
		}
	};
}

function enableAds() {
	let provider = localStorage.getItem('ad_provider');
	if (provider == null) {
		const query = new URLSearchParams(location.search);
		provider = query.get('ad_provider');
	}
	if (provider == null) {
		if (Math.random() < 0.5) {
			provider = 'playwire';
		} else {
			provider = 'publift';
		}
	}

	const notice = document.getElementById('bg3wiki-ad-provider-notice');
	notice.innerText = 'Ads provided by: ' + provider;

	loadAdScript(provider);
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
	script.onerror = function(){
		const classes = document.body.classList;
		classes.replace('mw-ads-enabled', 'mw-ads-disabled');
	};
	document.body.appendChild(script);
}

function rampSetup() {
	const classes = document.body.classList;
	if (!classes.contains('skin-citizen')) {
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
		if (ramp.settings.cp == path) {
			setType();
		} else {
			ramp.setPath(path).then(setType);
		}

		function setType() {
			if (newPage) {
				newPage = false;
				ramp.spaNewPage();
				return;
			}
			ramp.destroyUnits('all').then(() => {
				if (type == null) {
					return;
				}
				ramp.addUnits({
					type: type,
					selectorId: 'bg3wiki-footer-ad-ramp',
				}).then(() => {
					ramp.displayUnits();
				});
			});
		}
	}

	const sizes = [
		[ matchMinWH(970, 800), setFooterXL ],
		[ matchMinWH(728, 800), setFooterL  ],
		[ matchMinWH(468, 600), setFooterM  ],
		[ matchMinWH(320, 600), setFooterS  ],
	];

	function footerSetterForScreenSize() {
		for (const entry of sizes) {
			const matcher = entry[0];
			const setter = entry[1];
			if (matcher.matches) {
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
			ramp.que.push(setter);
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
		return;
	}

	const footerFuseIds = [
		[ matchMinWH(970, 800), '23201541515' ],
		[ matchMinWH(728, 800), '23200582344' ],
		[ matchMinWH(468, 600), '23200580337' ],
		[ matchMinWH(320, 600), '23200581156' ],
	];

	function footerFuseIdForScreenSize() {
		for (const entry of footerFuseIds) {
			const matcher = entry[0];
			const fuseId = entry[1];
			if (matcher.matches) {
				return fuseId;
			}
		}
		return null;
	}

	let footerFuseId = footerFuseIdForScreenSize();

	function replaceFooterAdZone() {
		const outerDivId = 'bg3wiki-footer-ad';
		const innerDivId = 'bg3wiki-footer-ad-fuse';

		const outerDiv = document.getElementById(outerDivId);
		const innerDiv = document.getElementById(innerDivId);
		if (innerDiv != null) {
			outerDiv.removeChild(innerDiv);
		}

		if (footerFuseId != null) {
			const newDiv = document.createElement('div');
			newDiv.id = innerDivId;
			newDiv.setAttribute('data-fuse', footerFuseId);
			outerDiv.appendChild(newDiv);

			fusetag.registerZone(innerDivId);
		}
	}

	replaceFooterAdZone();

	function onResize() {
		const newFuseId = footerFuseIdForScreenSize();
		if (footerFuseId != newFuseId) {
			footerFuseId = newFuseId;
			fusetag.que.push(replaceFooterAdZone);
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
