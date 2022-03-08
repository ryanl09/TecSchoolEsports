<?php

/**
 * The template for freestyle
 *
 * Template Name: FreeStyle
 *
 * @package Rookie
 */

get_header();
?>

<div id="primary" class="content-area content-area-full-width">
	<main id="main" class="site-main" role="main">
            <h1 class="entry-title">FreeStyle</h1>



                                           
<div id="loaderAlign">
    <div class="loader"></div>
</div>
<div id="iframediv" style="display: none;height: 2905px;min-height: 600px;">
    <iframe id="myIframe" scrolling="no" height="100%" width="100%" src="https://www.augustasportswear.com/freestyle-custom-headwear">
    </iframe>
</div>
<style>
    body, html {
        overflow: initial !important;
        overscroll-behavior: initial !important;
    }
    .store-front {
        height: auto !important;
    }
    #loaderAlign{
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }
                                
    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }
                                
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<script type="text/javascript">
	var asbFSPluginVersion = "20220208-1644";
	var pageUrl = location.href;
	var domainUrl = document.domain;
	var pageQuery = null;
	var iframeHasSameDomainUrl = true;


	var defaultConfig = {
		'discount' : 5,
		'addlLeadTime' : 2,
		'moq':6,
		'moqPrice':60
	};

	var categoryArray = [
		{'name' : 'custom-headwear', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'styles', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'running-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'beanies-knits', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'camo-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'on-field-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'lifestyle-outdoor-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'sideline-coaches-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'trucker-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'visors', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'boonie-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'features', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'flexfit-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'snapback-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'structured-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'unstructured-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'search-display-view-tags', 'tag' : 'search-display-view-tags',  'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'search-display-view-term', 'searchTerm' : 'search-display-view-tags', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'fanwear', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'lacrosse', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'baseball', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'basketball', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'soccer', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'football', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'fleece', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'track', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'training', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'softball', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'polo', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : '5-day-turbo', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'volleyball', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'babe-ruth-turbo', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'accessories', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'compression', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'semi-sublimated', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'default-page', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice }
	];

	var categoryShareMapper = {
		'custom headwear': 'custom-headwear',
		'styles': 'styles',
		'active/lightweight': 'running-hats',
		'beanies': 'beanies-knits',
		'camo': 'camo-hats',
		'on-field': 'on-field-hats',
		'outdoor': 'lifestyle-outdoor-hats',
		'sideline': 'sideline-coaches-hats',
		'truckers / mesh back': 'trucker-hats',
		'visors': 'visors',
		'wide brim / boonie': 'boonie-hats',
		'features': 'features',
		'flexfit': 'flexfit-hats',
		'snapback': 'snapback-hats',
		'structured': 'structured-hats',
		'unstructured': 'unstructured-hats',
		'search-display-view-tags' : 'search-display-view-tags',
		'search-display-view-term' : 'search-display-view-term',
		'fanwear' : 'fanwear',
		'lacrosse' : 'lacrosse',
		'baseball' : 'baseball',
		'basketball' : 'basketball',
		'soccer' : 'soccer',
		'football' : 'football',
		'fleece' : 'fleece',
		'outerwear' : 'fleece',
		'track' : 'track',
		'training' : 'training',
		'softball' : 'softball',
		'polos' : 'polo',
		'turbo' : '5-day-turbo',
		'volleyball' : 'volleyball',
		'babe ruth turbo' : 'babe-ruth-turbo',
		'masks, gaiters,' : 'accessories',
		'compression' : 'compression',
		'semi-sublimated' : 'semi-sublimated',
		'freestyle sublimation' : 'default-page'
	};


	window.onmessage = (e) => {
		var data = e.data.toString();

		if(e.data.domainUrl){
			iframeHasSameDomainUrl = false;
			pageUrl = e.data.pageUrl;
			pageQuery = e.data.pageQuery;
			var domain = e.data.domainUrl;
			domainUrl = domain.replace(/^https?:\/\//,'');
			setIframeSrc();
			var iframeSrc =  getIframeSrc();
		}
		if (data.indexOf('asgIframeHeight') > -1) {
			var iframeHeight = e.data.split(":");
			document.getElementById('iframediv').style.height = iframeHeight[1] + 'px';
		}
		if (data.indexOf('reLoadIframe') > -1) {
			//document.getElementById("showSummary").style.display = "none";
			setIframeSrc();
		}
		if (data.indexOf('scrollToTop') > -1) {
			window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
		}
		if (data.indexOf('asgPageName') > -1) {
			var pageName = e.data.split(":");
			if (pageName[1] == 'capConfigurator')
				document.getElementById("myIframe").setAttribute("scrolling", "yes");
			else {
				document.getElementById("myIframe").setAttribute("scrolling", "no");
			}
		}
	};
	document.querySelector('#myIframe').addEventListener("load", e => {
		sendParentHeightToChild();

	})
	function sendParentHeightToChild() {
		var child = document.getElementById("myIframe").contentWindow;
		var elemTop = document.getElementById("iframediv").offsetTop;
		var windowHeight =  document.documentElement.clientHeight || document.body.clientHeight || window.innerHeight;
		var calcHeight = windowHeight - elemTop;
		if (child.postMessage) {
			child.postMessage("parentHeight:" + calcHeight, '*');
			child.postMessage("parentDomain:" + domainUrl, '*');
		}
	}
	function sendDataToChild() {
		var child = document.getElementById("myIframe").contentWindow;
		if (child.postMessage) {
			child.postMessage("loadNextPageIframe", '*');
		}
	}
	function getFullUrl (){
		var searchLocation = false;
		if(window.location){
			if(window.location.search){
				if(window.location.search.substr(1)){
				searchLocation = true;
				}
			}
		}
		if(searchLocation){
			return window.location.search.substr(1);
		} else {
			var baseUrl = window.document.baseURI;
			var baseUrlData = baseUrl.split("?");
			if(baseUrlData[1] != undefined){
				return baseUrlData[1];
			}
			return "";
		}
	}
	function getCurrentUrlParams () {
		if(iframeHasSameDomainUrl === false){
			return pageQuery;
		} else {

			var operator = '&';
			var getUrl = getFullUrl();
			var queryString = (function(params) {
				if (params === "") return {};
				var obj = {};
				for (var i = 0; i < params.length; ++i)
				{
				var value = params[i].split('=', 2);
				if (value.length === 1)
					obj[value[0]] = "";
				else
					obj[value[0]] = decodeURIComponent(value[1].replace(/\+/g, " "));
				}
				return obj;
			})(getUrl.split(operator));

			return queryString;
		}
	}
	function setIframeSrc () {
		var url =  getIframeSrc();
		if(url) {
			document.getElementById('myIframe').src = url;
		}else {
			var iframe = document.getElementById('myIframe');
			iframe.src = iframe.src;
		}
		setTimeout(function(){
			document.getElementById("iframediv").style.display = "block";
			document.getElementById("loaderAlign").style.display = "none";
		}, 1000);
	}
	function validate (queryString, type) {
		if(queryString){
			if(queryString[type]){
				return true;
			}
			return false;
		}
		return false;
	}
	function getIframeSrc () {
		var queryString = getCurrentUrlParams();

		if(validate(queryString,'categoryName')){
			var categoryName = queryString['categoryName'];
			return generateUrl((categoryName.toLowerCase()).trim(), true)
		} else if(validate(queryString,'searchTerm')){
			var searchTerm = queryString['searchTerm'];
			return generateUrl('search-display-view-term', false)
		} else if(validate(queryString,'tag')){
			var tag = queryString['tag'];
			return generateUrl('search-display-view-tags', false)
		}else {
			var currentURL = pageUrl;
			var url = currentURL.split("?");
			var urlArray = url[0];
			var urlHrefArray = urlArray.split('/');
			var categoryName = null;
			urlHrefArray.forEach(function(urlEntity) {
				categoryArray.forEach(function(category){
				if( (urlEntity.toLowerCase()).trim() === ((category.name).toLowerCase()).trim() ){
					categoryName = ((category.name).toLowerCase()).trim();
				}
				})
			})
			return generateUrl(categoryName, true);
		}
	}
	function isCapConfiguratorPage () {
		var queryString = getCurrentUrlParams();
		if(validate(queryString,'dNumber')){
			return true;
		}
		return false;
	}
	function isConfiguratorPage () {
		var queryString = getCurrentUrlParams();
		if(validate(queryString,'sNumber')){
			return true;
		}
		return false;
	}
	function checkCategory (categoryName) {
			const category = categoryArray.filter((item) => item.name === categoryName);
			if(category.length){
				return true;
			}
			return false;
		}
	function generateUrl(categoryName, isCategoryName){
			var currentIframeUrl = document.getElementById('myIframe').src;
			var queryString = getCurrentUrlParams();
			var replaceText = 'freestyle-custom-headwear';
			if(categoryName){
				categoryName = categoryShareMapper[categoryName];
				replaceText = 'freestyle-custom-headwear-'+categoryName;
				if(isCapConfiguratorPage()){
					replaceText = 'CapConfigurator';
				}else if(isConfiguratorPage()){
					replaceText = 'Configurator';
				} else if(!isCategoryName) {
					replaceText = 'SearchDisplayView';
					categoryName = categoryShareMapper[categoryName];
				}
				else if(!checkCategory(categoryName)) {
					categoryName = 'custom-headwear';
					replaceText = 'freestyle-custom-headwear';
				}
			} else{
				categoryName = 'custom-headwear';
				if(isCapConfiguratorPage()){
					replaceText = 'CapConfigurator';
				}else if(isConfiguratorPage()){
					categoryName = 'default-page';
					replaceText = 'Configurator';
				} 
			}
			var Index = categoryArray.findIndex(x => ((x.name).toLowerCase()).trim() === categoryName );
			var categoryObj = categoryArray[Index];
			var url = currentIframeUrl.split('?');
			var urlArray = url[0];
			var paramsArray = url[1];
			var urlHrefArray = urlArray.split('/');
			var urlHrefReplaceEntity = urlHrefArray[urlHrefArray.length -1];
			url[0] = urlArray.replace(urlHrefReplaceEntity, replaceText);
			var newUrl = url.join('?');
			var href = new URL(newUrl);
			var categoryObjLength = Object.keys(categoryObj).length;
			if(categoryObjLength) {
				Object.keys(categoryObj).forEach(function(key){
					href.searchParams.delete(key);
					if(key == 'tag'){
						value = queryString['tag']
						href.searchParams.set(key, value);
					}else if(key == 'searchTerm'){
						value = queryString['searchTerm']
						href.searchParams.set(key, value);
					}
					else{
						href.searchParams.set(key, categoryObj[key]);
					}
				})
			}
			if(isConfiguratorPage() || isCapConfiguratorPage()){
				Object.keys(queryString).forEach(function(key){
					href.searchParams.delete(key);
					href.searchParams.set(key, queryString[key]);
				})
			}

			return href.toString();
	}
	function isScrolledIntoView() {
		var elem = document.getElementById("iframediv");
		var docViewTop = (document.documentElement && document.documentElement.scrollTop) ||  document.body.scrollTop;
		var windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		var docViewBottom = docViewTop + windowHeight;
		var elemTop = elem.offsetTop;
		var elemBottom = elemTop + elem.offsetHeight;
		return ((elemBottom <= docViewBottom));
	}
	if (typeof $ !== "undefined"){
		if($(document).ready) {$(document).ready(pageLoad, false);}
		else  {document.addEventListener('load', pageLoad, false);}
	}else{
		if (window.attachEvent) {window.attachEvent('onload', pageLoad);}
		else if (window.addEventListener) {window.addEventListener('load', pageLoad, false);}
		else  {document.addEventListener('load', pageLoad, false);}
	}
	function pageLoad() {
		setIframeSrc();
		window.onscroll = function() {
			if (isScrolledIntoView()) {
				sendDataToChild();
			}
		};
	}
    </script>                             
 
    

<div id="loaderAlign">
    <div class="loader"></div>
</div>
<div id="iframediv" style="display: none;height: 2905px;min-height: 600px;">
    <iframe id="myIframe" scrolling="no" height="100%" width="100%" src="https://www.augustasportswear.com/custom-sublimation">
    </iframe>
</div>
<style>
    body, html {
        overflow: initial !important;
        overscroll-behavior: initial !important;
    }
    .store-front {
        height: auto !important;
    }
    #loaderAlign{
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<script type="text/javascript">
	var asbFSPluginVersion = "20220208-1644";
	var pageUrl = location.href;
	var domainUrl = document.domain;
	var pageQuery = null;
	var iframeHasSameDomainUrl = true;


	var defaultConfig = {
		'discount' : 5,
		'addlLeadTime' : 2,
		'moq':6,
		'moqPrice':60
	};

	var categoryArray = [
		{'name' : 'fanwear', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'lacrosse', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'baseball', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'basketball', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'soccer', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'football', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'fleece', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'track', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'training', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'softball', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'polo', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : '5-day-turbo', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'volleyball', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'babe-ruth-turbo', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'accessories', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'compression', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'semi-sublimated', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'default-page', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'search-display-view-tags', 'tag' : 'search-display-view-tags',  'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'search-display-view-term', 'searchTerm' : 'search-display-view-tags', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'custom-headwear', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'styles', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'running-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'beanies-knits', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'camo-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'on-field-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'lifestyle-outdoor-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'sideline-coaches-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'trucker-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'visors', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'boonie-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'features', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'flexfit-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'snapback-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'structured-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice },
		{'name' : 'unstructured-hats', 'discount' : defaultConfig.discount, 'addlLeadTime' : defaultConfig.addlLeadTime,'moq':defaultConfig.moq, 'moqPrice':defaultConfig.moqPrice }
	];

	var categoryShareMapper = {
		'fanwear' : 'fanwear',
		'lacrosse' : 'lacrosse',
		'baseball' : 'baseball',
		'basketball' : 'basketball',
		'soccer' : 'soccer',
		'football' : 'football',
		'fleece' : 'fleece',
		'outerwear' : 'fleece',
		'track' : 'track',
		'training' : 'training',
		'softball' : 'softball',
		'polos' : 'polo',
		'turbo' : '5-day-turbo',
		'volleyball' : 'volleyball',
		'babe ruth turbo' : 'babe-ruth-turbo',
		'masks, gaiters,' : 'accessories',
		'compression' : 'compression',
		'semi-sublimated' : 'semi-sublimated',
		'freestyle sublimation' : 'default-page',
		'search-display-view-tags' : 'search-display-view-tags',
		'search-display-view-term' : 'search-display-view-term',
		'custom headwear': 'custom-headwear',
		'styles': 'styles',
		'active/lightweight': 'running-hats',
		'beanies': 'beanies-knits',
		'camo': 'camo-hats',
		'on-field': 'on-field-hats',
		'outdoor': 'lifestyle-outdoor-hats',
		'sideline': 'sideline-coaches-hats',
		'truckers / mesh back': 'trucker-hats',
		'visors': 'visors',
		'wide brim / boonie': 'boonie-hats',
		'features': 'features',
		'flexfit': 'flexfit-hats',
		'snapback': 'snapback-hats',
		'structured': 'structured-hats',
		'unstructured': 'unstructured-hats'
	};

	window.onmessage = (e) => {
		var data = e.data.toString();

		if(e.data.domainUrl){
			iframeHasSameDomainUrl = false;
			pageUrl = e.data.pageUrl;
			pageQuery = e.data.pageQuery;
			var domain = e.data.domainUrl;
			domainUrl = domain.replace(/^https?:\/\//,'');
			setIframeSrc();
			var iframeSrc =  getIframeSrc();
		}
		if (data.indexOf('asgIframeHeight') > -1) {
			var iframeHeight = e.data.split(":");
			document.getElementById('iframediv').style.height = iframeHeight[1] + 'px';
		}
		if (data.indexOf('reLoadIframe') > -1) {
			//document.getElementById("showSummary").style.display = "none";
			setIframeSrc();
		}
		if (data.indexOf('scrollToTop') > -1) {
			window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
		}
		if (data.indexOf('asgPageName') > -1) {
			var pageName = e.data.split(":");
			if (pageName[1] == 'configurator')
				document.getElementById("myIframe").setAttribute("scrolling", "yes");
			else {
				document.getElementById("myIframe").setAttribute("scrolling", "no");
			}
		}
	};
	document.querySelector('#myIframe').addEventListener("load", e => {
		sendParentHeightToChild();

	})
	function sendParentHeightToChild() {
		var child = document.getElementById("myIframe").contentWindow;
		var elemTop = document.getElementById("iframediv").offsetTop;
		var windowHeight =  document.documentElement.clientHeight || document.body.clientHeight || window.innerHeight;
		var calcHeight = windowHeight - elemTop;
		if (child.postMessage) {
			child.postMessage("parentHeight:" + calcHeight, '*');
			child.postMessage("parentDomain:" + domainUrl, '*');
		}
	}
	function sendDataToChild() {
		var child = document.getElementById("myIframe").contentWindow;
		if (child.postMessage) {
			child.postMessage("loadNextPageIframe", '*');
		}
	}
	function getFullUrl (){
		var searchLocation = false;
		if(window.location){
			if(window.location.search){
				if(window.location.search.substr(1)){
					searchLocation = true;
				}
			}
		}
		if(searchLocation){
			return window.location.search.substr(1);
		} else {
			var baseUrl = window.document.baseURI;
			var baseUrlData = baseUrl.split("?");
			if(baseUrlData[1] != undefined){
				return baseUrlData[1];
			}
			return "";
		}
	}
	function getCurrentUrlParams () {
		if(iframeHasSameDomainUrl === false){
			return pageQuery;
		} else {

			var operator = '&';
			var getUrl = getFullUrl();
			var queryString = (function(params) {
				if (params === "") return {};
				var obj = {};
				for (var i = 0; i < params.length; ++i)
				{
					var value = params[i].split('=', 2);
					if (value.length === 1)
						obj[value[0]] = "";
					else
						obj[value[0]] = decodeURIComponent(value[1].replace(/\+/g, " "));
				}
				return obj;
			})(getUrl.split(operator));

			return queryString;
		}
	}
	function setIframeSrc () {
		var url =  getIframeSrc();
		if(url) {
			document.getElementById('myIframe').src = url;
		}else {
			var iframe = document.getElementById('myIframe');
			iframe.src = iframe.src;
		}
		setTimeout(function(){
			document.getElementById("iframediv").style.display = "block";
			document.getElementById("loaderAlign").style.display = "none";
		}, 1000);
	}
	function validate (queryString, type) {
		if(queryString){
			if(queryString[type]){
				return true;
			}
			return false;
		}
		return false;
	}
	function getIframeSrc () {
		var queryString = getCurrentUrlParams();
			
		if(validate(queryString,'categoryName')){
			var categoryName = queryString['categoryName'];
			return generateUrl((categoryName.toLowerCase()).trim(), true)
		} else if(validate(queryString,'searchTerm')){
			var searchTerm = queryString['searchTerm'];
			return generateUrl('search-display-view-term', false)
		} else if(validate(queryString,'tag')){
			var tag = queryString['tag'];
			return generateUrl('search-display-view-tags', false)
		}
		else {
			var currentURL = pageUrl;
			var url = currentURL.split("?");
			var urlArray = url[0];
			var urlHrefArray = urlArray.split('/');
			var categoryName = null;
			urlHrefArray.forEach(function(urlEntity) {
				categoryArray.forEach(function(category){
					if( (urlEntity.toLowerCase()).trim() === ((category.name).toLowerCase()).trim() ){
						categoryName = ((category.name).toLowerCase()).trim();
					}
				})
			})
			return generateUrl(categoryName);
		}
	}
	function isConfiguratorPage () {
		var queryString = getCurrentUrlParams();
		if(validate(queryString,'sNumber')){
			return true;
		}
		return false;
	}
	function isCapConfiguratorPage () {
		var queryString = getCurrentUrlParams();
		if(validate(queryString,'dNumber')){
			return true;
		}
		return false;
	}
	function checkCategory (categoryName) {
		const category = categoryArray.filter((item) => item.name === categoryName);
		if(category.length){
			return true;
		}
		return false;
	}
	function generateUrl(categoryName, isCategoryName){
		var currentIframeUrl = document.getElementById('myIframe').src;
		var queryString = getCurrentUrlParams();
		var replaceText = 'custom-sublimation';
		if(categoryName){
			replaceText = 'custom-sublimation-'+categoryName;
			if(isConfiguratorPage()){
				replaceText = 'Configurator';
				categoryName = categoryShareMapper[categoryName];
			}else if(isCapConfiguratorPage()){
				replaceText = 'CapConfigurator';
				categoryName = categoryShareMapper[categoryName];
			} else if(!isCategoryName) {
				replaceText = 'SearchDisplayView';
				categoryName = categoryShareMapper[categoryName];
			} else if( (categoryName === '5-day-turbo') || (categoryName === 'semi-sublimated') ) {
				replaceText = categoryName;
			} else if(!checkCategory(categoryName)) {
				categoryName = 'default-page';
				replaceText = 'custom-sublimation';
			}
		} else{
			categoryName = 'default-page';
			if(isConfiguratorPage()){
				replaceText = 'Configurator';
			} else if(isCapConfiguratorPage()){
				categoryName = 'custom-headwear';
				replaceText = 'CapConfigurator';
			}
		}
		var Index = categoryArray.findIndex(x => ((x.name).toLowerCase()).trim() === categoryName );
		var categoryObj = categoryArray[Index];
		var url = currentIframeUrl.split('?');
		var urlArray = url[0];
		var paramsArray = url[1];
		var urlHrefArray = urlArray.split('/');
		var urlHrefReplaceEntity = urlHrefArray[urlHrefArray.length -1];
		url[0] = urlArray.replace(urlHrefReplaceEntity, replaceText);
		var newUrl = url.join('?');
		var href = new URL(newUrl);
		var categoryObjLength = Object.keys(categoryObj).length;
		if(categoryObjLength) {
			Object.keys(categoryObj).forEach(function(key){
				href.searchParams.delete(key);
				if(key == 'tag'){
					value = queryString['tag']
					href.searchParams.set(key, value);
				}else if(key == 'searchTerm'){
					value = queryString['searchTerm']
					href.searchParams.set(key, value);
				}
				else{
					href.searchParams.set(key, categoryObj[key]);
				}
				
			})
		}
		if(isConfiguratorPage() || isCapConfiguratorPage()){
			Object.keys(queryString).forEach(function(key){
				href.searchParams.delete(key);
				href.searchParams.set(key, queryString[key]);
			})
		}

		return href.toString();
	}
	function isScrolledIntoView() {
		var elem = document.getElementById("iframediv");
		var docViewTop = (document.documentElement && document.documentElement.scrollTop) ||  document.body.scrollTop;
		var windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		var docViewBottom = docViewTop + windowHeight;
		var elemTop = elem.offsetTop;
		var elemBottom = elemTop + elem.offsetHeight;
		return ((elemBottom <= docViewBottom));
	}
	if (typeof $ !== "undefined"){
		if($(document).ready) {$(document).ready(pageLoad, false);}
		else  {document.addEventListener('load', pageLoad, false);}
	}else{
		if (window.attachEvent) {window.attachEvent('onload', pageLoad);}
		else if (window.addEventListener) {window.addEventListener('load', pageLoad, false);}
		else  {document.addEventListener('load', pageLoad, false);}
	}
	function pageLoad() {
		setIframeSrc();
		window.onscroll = function() {
			if (isScrolledIntoView()) {
				sendDataToChild();
			}
		};
	}
</script>                                 

                            
    </main>
</div>


<?php get_footer(); ?>