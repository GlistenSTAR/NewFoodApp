var myApp = new Framework7,
    $$ = Dom7,
    view1 = myApp.addView("#tab-1", {
        dynamicNavbar: !0
    }),
    view2 = myApp.addView("#tab-2", {
        dynamicNavbar: !0
    }),
    view3 = myApp.addView("#tab-3", {
        dynamicNavbar: !0
    }),
    view4 = myApp.addView("#tab-4", {
        dynamicNavbar: !0
    }),
    view5 = myApp.addView("#tab-5", {
        dynamicNavbar: !0
    });

function init() {
    null === localStorage.getItem("firstRun") ? setup() : loadTheme()
}

function setup() {
    localStorage.setItem("theme", "light"), localStorage.setItem("firstRun", !0), loadTheme()
}

function loadTheme() {
    "dark" === localStorage.getItem("theme") ? makeDarkTheme() : makeWhiteTheme()
}

function setThemeWhite() {
    localStorage.setItem("theme", "light"), makeWhiteTheme()
}

function setThemeDark() {
    localStorage.setItem("theme", "dark"), makeDarkTheme()
}

function makeWhiteTheme() {
    document.getElementById("body").className = "layout-white framework7-root"
}

function makeDarkTheme() {
    document.getElementById("body").className = "layout-dark framework7-root"
}

function toggleTheme() {
    "light" === localStorage.getItem("theme") ? (setThemeDark(), document.cookie = "fasttheme-switching=true; expires=Thu, 01 Jan 2025 00:00:00 UTC; path=/;") : (setThemeWhite(), document.cookie = "fasttheme-switching=false; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;")
}
$("#tab-2").on("show", function() {
    $(".swiper-container").each(function(e, t) {
        this.swiper.update()
    })
}), $("#tab-3").on("show", function() {
    $(".swiper-container").each(function(e, t) {
        this.swiper.update()
    })
});
var ptrContent = $$(".pull-to-refresh-content");
ptrContent.on("ptr:refresh", function(e) {
    setTimeout(function() {
        location.reload(), myApp.pullToRefreshDone()
    }, 700)
});

$(".app-icon").on("error", function(e){
    e.target.onerror = "";
    e.target.src = "http://a1iraqi.com/sc/imgae/logo.png";
    return true;
})

$$(document).on('page:init', '.page[data-name="install"]', function (e) {
	if ($(e.target).data('app-name')&&$(e.target).data('id'))
	  ga('send', {
	  hitType: 'event',
	  eventCategory: 'App',
	  eventAction: 'view',
	  eventLabel: $(e.target).data('app-name')
	});
})


$$(document).on('page:init', '.page[data-name="install"]', function (e) {
	window.google_ad_client = "ca-pub-4937367116541461";
	window.google_ad_slot = "9058741767";
	window.google_ad_width = 320;
	window.google_ad_height = 100;
	console.log("test");

	// container is where you want the ad to be inserted
	var container = document.getElementById('ad_container');
	var w = document.write;
	document.write = function (content) {
		container.innerHTML = content;
		//document.write = w;
	};

	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
	document.getElementsByTagName("head")[0].appendChild(script);
})


$$(document).on('click', '.install', function (e) {
	if ($(e.target).data('app-name')&&$(e.target).data('id'))
	ga('send', {
	  hitType: 'event',
	  eventCategory: 'App',
	  eventAction: 'install',
	  eventLabel: $(e.target).data('app-name')
	});
})