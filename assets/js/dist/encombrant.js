"use strict";function asyncGeneratorStep(e,t,n,a,r,o,s){try{var i=e[o](s),u=i.value}catch(e){return void n(e)}i.done?t(u):Promise.resolve(u).then(a,r)}function _asyncToGenerator(i){return function(){var e=this,s=arguments;return new Promise(function(t,n){var a=i.apply(e,s);function r(e){asyncGeneratorStep(a,t,n,r,o,"next",e)}function o(e){asyncGeneratorStep(a,t,n,r,o,"throw",e)}r(void 0)})}}var formData,nextAvailableDate=function(){var e=new Date;for(e.setDate(e.getDate()+2);0===e.getDay()||6===e.getDay();)e.setDate(e.getDate()+1);return e.setHours(8),e.setMinutes(0),e};function displayStep(e){"first"===e?(document.getElementsByTagName("form")[1].style.display="none",document.getElementsByTagName("form")[0].style.display="block",document.getElementById("return-button").style.display="none"):"second"===e&&(document.getElementsByTagName("form")[0].style.display="none",document.getElementsByTagName("form")[1].style.display="block",document.getElementById("return-button").style.display="block")}flatpickr("#input-datetime",{locale:"fr",altInput:!0,inline:!0,disable:[function(e){return 0===e.getDay()||6===e.getDay()}],monthSelectorType:"static",enableTime:!0,time_24hr:!0,minTime:"8:00",maxTime:"16:00",minuteIncrement:30,altFormat:"j F Y à H\\hi",minDate:(new Date).fp_incr(2),defaultDate:nextAvailableDate()}),document.getElementsByClassName("flatpickr-time-separator")[0].textContent="h",window.onsubmit=function(){var t=_asyncToGenerator(regeneratorRuntime.mark(function e(t){var n;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(t.preventDefault(),!t.target.classList.contains("first-step")){e.next=6;break}displayStep("second"),formData=new FormData(t.target),e.next=25;break;case 6:if(t.target.classList.contains("second-step"))return formData.append("input-datetime",document.getElementById("input-datetime").value),e.next=10,fetch("php/tasks/encombrant-task.php",{method:"POST",body:formData});e.next=25;break;case 10:return n=e.sent,e.next=13,n.text();case 13:n=e.sent,e.t0=n,e.next="success"===e.t0?17:"error"===e.t0?19:"file"===e.t0?21:"missing"===e.t0?23:25;break;case 17:return document.location.replace("index.php"),e.abrupt("break",25);case 19:return displayError(document.getElementById("encombrant-submit"),"Une erreur est survenue."),e.abrupt("break",25);case 21:return displayError(document.getElementById("encombrant-submit"),"Erreur lors de l'upload de l'image."),e.abrupt("break",25);case 23:return displayError(document.getElementById("encombrant-submit"),"Un champ est manquant."),e.abrupt("break",25);case 25:case"end":return e.stop()}},e)}));return function(e){return t.apply(this,arguments)}}(),document.getElementById("return-button").onclick=function(){displayStep("first")};