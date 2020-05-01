//BEGIN automated edits. These will be automatically overwritten.
var THEME_NAME = 'nebula-child';
var NEBULA_VERSION = 'v8.0.1.3546'; //Friday, May 1, 2020 8:30:49 AM
var OFFLINE_URL = 'https://gearside.com/nebula/offline/';
var OFFLINE_IMG = 'https://gearside.com/nebula/wp-content/themes/Nebula-master/assets/img/offline.svg';
var OFFLINE_GA_DIMENSION = 'cd2';
var META_ICON = 'https://gearside.com/nebula/wp-content/themes/Nebula-master/assets/img/meta/android-chrome-512x512.png';
var MANIFEST = 'https://gearside.com/nebula/wp-content/themes/Nebula-master/inc/manifest.json';
var HOME_URL = 'https://gearside.com/nebula/';
var START_URL = 'https://gearside.com/nebula/?utm_source=pwa'; //@todo "Nebula" 0: How do we append ?utm_source=pwa to this without causing an additional resource request to cache it?
//END automated edits

importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.1.3/workbox-sw.js'); //https://developers.google.com/web/tools/workbox/guides/get-started
workbox.setConfig({debug: false}); //https://developers.google.com/web/tools/workbox/guides/troubleshoot-and-debug

//@todo "Nebula" 0: If ?debug is present in the URL on load, dump the entire cache and unregister (or update) the SW completely
//deleteCacheAndMetadata();

workbox.core.skipWaiting();
workbox.core.clientsClaim();
workbox.precaching.cleanupOutdatedCaches(); //This listens for "-precache-" in the cache name

//Cache names
workbox.core.setCacheNameDetails({
	prefix: THEME_NAME,
	suffix: NEBULA_VERSION,
	precache: 'precache',
	runtime: 'runtime',
	googleAnalytics: 'ga'
});

//Precache files on SW install
workbox.precaching.precacheAndRoute([
	OFFLINE_URL,
	OFFLINE_IMG,
	META_ICON,
	MANIFEST,
	HOME_URL,
	START_URL
]);

//Check if we need to force network retrieval for specific resources (false = network only, true = allow caching)
function isCacheAllowed(event){
	if ( event.request ){ //Use event.request for non-Workbox requests (just in case)
		event = event.request;
	}

	if ( event.method !== 'GET' ){ //Prevent cache for POST and AJAX requests (Workbox may already handle this, but just to be safe)
		return false;
	}

	var eventReferrer = event.referrer; //The page making the request
	var eventURL = event.url.href || event.url; //The file being requested

	//Check domains, directories, and pages
	var pageRegex = /\/chrome-extension:\/\/|\/wp-login.php|\/wp-admin|analytics|hubspot|hs-scripts|customize.php|customize_|no-cache|admin-ajax|gutenberg\//;
	if ( pageRegex.test(eventReferrer) || pageRegex.test(eventURL) ){
		return false;
	}

	//Check file extensions
	var fileRegex = /\.(?:pdf|docx?|xlsx?|pptx?|zipx?|rar|tar|txt|rtf|ics|vcard)/;
	if ( fileRegex.test(eventReferrer) || fileRegex.test(eventURL) ){
		return false;
	}

	return true;
}

//Data feeds
workbox.routing.registerRoute(
	new RegExp('/\.(?:json|xml|yaml|csv)/'),
	new workbox.strategies.NetworkFirst()
);

//Images
workbox.routing.registerRoute(
	new RegExp('/\.(?:png|gif|jpg|jpeg|webp|svg)$/'),
	new workbox.strategies.StaleWhileRevalidate({
		cacheName: 'images', //This cache name is used for the offline fallback and expiration plugin
		plugins: [
			new workbox.expiration.ExpirationPlugin({
				maxEntries: 100, //Cache a maximum number of resources (Figure out a reasonable amount here...)
				maxAgeSeconds: 7 * 24 * 60 * 60, //Cache for a maximum of a week
				purgeOnQuotaError: true //Purge if an error occurs
			})
		]
	})
);

//Everything else (not using setDefaultHandler() to avoid caching certain requests)
workbox.routing.registerRoute(
	isCacheAllowed, //Avoid caching certain requests
	new workbox.strategies.StaleWhileRevalidate({
		cacheName: 'default', //Cache name is required for expiration plugin
		plugins: [
			new workbox.expiration.ExpirationPlugin({
				maxEntries: 250, //Cache a maximum of 250 resources (Figure out a reasonable amount here...)
				maxAgeSeconds: 30 * 24 * 60 * 60, //Cache for a maximum of a month
				purgeOnQuotaError: true //Purge if an error occurs
			})
		]
	})
);

//Offline response
workbox.routing.setCatchHandler(function(params){
	if ( params.event.request.mode === 'navigate' ){
		return caches.match(workbox.precaching.getCacheKeyForURL(OFFLINE_URL));
	}

	if ( params.event.request.destination === 'image' ){
		return caches.match(workbox.precaching.getCacheKeyForURL(OFFLINE_IMG));
	}

	return Response.error(); //If we don't have a fallback, just return an error response.
});

//Offline Google Analytics: https://developers.google.com/web/tools/workbox/modules/workbox-google-analytics
//Noticing some strange (not set) Language traffic in GA... currently testing this before bringing it back.
workbox.googleAnalytics.initialize({
	parameterOverrides: {
		[OFFLINE_GA_DIMENSION]: 'offline', //Set a custom dimension to note offline hits (if set in Nebula Options)
	},
});