!function(){"use strict";document.addEventListener("DOMContentLoaded",(function(){for(var t=document.querySelectorAll(".js-nyt-bestseller-listings_changeList"),e=0;e<t.length;e++)t[e].addEventListener("change",(function(){var e=this.parentNode.parentNode.querySelector(".nyt-bestseller-listings-booklist");e.classList.add("loading");var n,s=new URLSearchParams(window.location.search);s.set("nytlist",this.value),history.pushState({},"","?"+s.toString()),(n=this.value,new Promise((function(t,e){const s=window.bslnyt&&!1===window.bslnyt.displayImages?0:1;jQuery.get(nyt_bestseller_listings_settings.ajaxurl,{action:"nyt_bestseller_listings_getList",listName:n,displayImages:s},(function(e){t(e)}))}))).then((function(t){e.innerHTML=t,e.classList.remove("loading")}));for(var i=0;i<t.length;i++)t[i]!==this&&(t[i].value=this.value)}))}))}();