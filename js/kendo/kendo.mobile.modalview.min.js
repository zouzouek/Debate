/*
* Kendo UI Complete v2014.1.318 (http://kendoui.com)
* Copyright 2014 Telerik AD. All rights reserved.
*
* Kendo UI Complete commercial licenses may be obtained at
* http://www.telerik.com/purchase/license-agreement/kendo-ui-complete
* If you do not own a commercial license, this file shall be governed by the trial license terms.
*/
!function(e,define){define(["./kendo.mobile.shim.min","./kendo.mobile.application.min"],e)}(function(){return function(e){var t=window.kendo,n=t.mobile.ui,i=n.Shim,o=n.Widget,r="open",a="close",s="init",l='<div class="km-modalview-wrapper" />',d=n.View.extend({init:function(e,n){var r,a,d=this;o.fn.init.call(d,e,n),e=d.element,n=d.options,r=e[0].style.width||"auto",a=e[0].style.height||"auto",e.addClass("km-modalview").wrap(l),d.wrapper=e.parent().css({width:n.width||r||300,height:n.height||a||300}),e.css({width:"",height:""}),d.shim=new i(d.wrapper,{modal:n.modal,position:"center center",align:"center center",effect:"fade:in",className:"km-modalview-root"}),t.support.mobileOS.wp&&d.shim.shim.on("click",!1),d._layout(),d._scroller(),d._model(),d.element.css("display",""),d.trigger(s)},events:[s,r,a],options:{name:"ModalView",modal:!0,width:null,height:null},destroy:function(){o.fn.destroy.call(this),this.shim.destroy()},open:function(t){var n=this;n.target=e(t),n.shim.show(),n.trigger("show",{view:n})},openFor:function(e){this.open(e),this.trigger(r,{target:e})},close:function(){this.shim.hide(),this.trigger(a)}});n.plugin(d)}(window.kendo.jQuery),window.kendo},"function"==typeof define&&define.amd?define:function(e,t){t()});