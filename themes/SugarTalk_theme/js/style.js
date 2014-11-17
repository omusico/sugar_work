/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

$(document).ready(function() {
        jQuery.fn.exists = function() {
           return $(this).length;
        };


        $("#create_image").remove();
        $("#detail_header_action_menu").removeClass('clickMenu');
        $("#detail_header_action_menu li.sugar_action_button").removeClass('sugar_action_button').addClass('btn-group');
        $("#detail_header_action_menu li.btn-group span").remove();
        $("#detail_header_action_menu li.btn-group a").addClass('button');
        $("#detail_header_action_menu li.btn-group input[type=submit]").addClass('button');
        $("#detail_header_action_menu li.btn-group ul").removeClass('subnav').addClass('dropdown-menu');
        $('#detail_header_action_menu li.btn-group').append('<a id="dropdown-toggle-menu" class="button dropdown-toggle" style="padding: 9px 8px 10px; margin-left:-4px;" href="#" data-toggle="dropdown"><span class="caret"></span></a>');
        $('#detail_header_action_menu li.btn-group a#edit_button').css("padding","3px 40px");
        $('#detail_header_action_menu li.btn-group a#edit_button').css("-webkit-padding-after","5px");
        $('#detail_header_action_menu').css("margin-left","-35px");

        var detail_offset_height = $("#content .detail.view.detail508 table tr td[scope='col']").outerWidth();
        var edit_offset_map_height = $("td#map_in_editview_label").outerWidth();
        $('table.panelContainer div#map_canvas').css("right", detail_offset_height);
        $('table.panelContainer div#map_canvas').css("right", edit_offset_map_height);
        $('#map_in_editview').parent().prev().removeAttr("scope");
        $('#map_in_editview').parent().prev().text("");

        $("div#content-gallery div#gallery > div").css("right", 250);
        $('#content-gallery').parent().prev().removeAttr("scope");
        $('#content-gallery').parent().prev().text("");

        !function(a,b,c){a.fn.scrollUp=function(b){a.data(c.body,"scrollUp")||(a.data(c.body,"scrollUp",!0),a.fn.scrollUp.init(b))},a.fn.scrollUp.init=function(d){var e=a.fn.scrollUp.settings=a.extend({},a.fn.scrollUp.defaults,d),f=e.scrollTitle?e.scrollTitle:e.scrollText,g=a("<a/>",{id:e.scrollName,href:"#top",title:f}).appendTo("body");e.scrollImg||g.html(e.scrollText),g.css({display:"none",position:"fixed",zIndex:e.zIndex}),e.activeOverlay&&a("<div/>",{id:e.scrollName+"-active"}).css({position:"absolute",top:e.scrollDistance+"px",width:"100%",borderTop:"1px dotted"+e.activeOverlay,zIndex:e.zIndex}).appendTo("body"),scrollEvent=a(b).scroll(function(){switch(scrollDis="top"===e.scrollFrom?e.scrollDistance:a(c).height()-a(b).height()-e.scrollDistance,e.animation){case"fade":a(a(b).scrollTop()>scrollDis?g.fadeIn(e.animationInSpeed):g.fadeOut(e.animationOutSpeed));break;case"slide":a(a(b).scrollTop()>scrollDis?g.slideDown(e.animationInSpeed):g.slideUp(e.animationOutSpeed));break;default:a(a(b).scrollTop()>scrollDis?g.show(0):g.hide(0))}}),g.click(function(b){b.preventDefault(),a("html, body").animate({scrollTop:0},e.scrollSpeed,e.easingType)})},a.fn.scrollUp.defaults={scrollName:"scrollUp",scrollDistance:300,scrollFrom:"top",scrollSpeed:300,easingType:"linear",animation:"fade",animationInSpeed:200,animationOutSpeed:200,scrollText:"Scroll to top",scrollTitle:!1,scrollImg:!1,activeOverlay:!1,zIndex:2147483647},a.fn.scrollUp.destroy=function(d){a.removeData(c.body,"scrollUp"),a("#"+a.fn.scrollUp.settings.scrollName).remove(),a("#"+a.fn.scrollUp.settings.scrollName+"-active").remove(),a.fn.jquery.split(".")[1]>=7?a(b).off("scroll",d):a(b).unbind("scroll",d)},a.scrollUp=a.fn.scrollUp}(jQuery,window,document);

         $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            topDistance: '300', // Distance from top before showing element (px)
            topSpeed: 300, // Speed back to top (ms)
            animation: 'fade', // Fade, slide, none
            animationInSpeed: 200, // Animation in speed (ms)
            animationOutSpeed: 200, // Animation out speed (ms)
            scrollText: '', // Text for element
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
        });

        var shortcuts = "";
        var shortcuts_first = "";
        var i = 0;
        if(typeof(shortcuts_json)!= "undefined" && shortcuts_json!== "")
        {
            $.each(shortcuts_json, function(index, element) {
                if(!element.IMAGE) element.IMAGE = "<img src='themes/SugarTalk_theme/images/ConfigureSubPanels.gif'/>";//[no logo]
//                console.log(element.IMAGE);
                if(i==0) shortcuts_first = "<a class='first' href='"+element.URL+"'>"+element.IMAGE+" "+element.LABEL+"</a>";
                else shortcuts += "<a href='"+element.URL+"'>"+element.IMAGE+" "+element.LABEL+"</a>";
                i++;
            });
        }

        $('#search_form table tr td span.id-ff.multiple').addClass("btn-group");
        $('div#EditView_tabs table tr td span.id-ff.multiple').addClass("btn-group");

//        $('div.moduleTitle span').addClass("btn-group");
        if( $("#create_link").exists() )
        {
//            console.log(shortcuts.length);
            if(shortcuts.length>0)
            {
                $('span.utils').append("<ul class='dropdown-menu'><li>"+shortcuts_first+shortcuts+"</li></ul>");
            }
            $("#create_image img").remove();

            $("#create_link").addClass("button")
                             .after("<a id='dropdown-toggle-menu' class='utilsLink button dropdown-toggle' data-toggle='dropdown' href='#'><span class='caret'></span></a>");
        }
        else if( !($("#create_link").exists()) &&  shortcuts.length>0)
        {
            if($('span.utils').exists()) $("span.utils").remove();
            $("div.moduleTitle h2:first-child").after('<span id="my_span" class="utils"></span>');
//            console.log(shortcuts.length);
            if(shortcuts.length>0)
            {
                $('#my_span.utils').append(shortcuts_first);
                $('#my_span.utils').append("<ul class='dropdown-menu'><li>"+shortcuts+"</li></ul>");
            }
            $('#my_span.utils a.first').addClass("button").addClass("utilsLink")
                             .after("<a id='dropdown-toggle-menu' class='utilsLink button dropdown-toggle' data-toggle='dropdown' href='#'><span class='caret'></span></a>");

        }

//        $("input[type=checkbox]").addClass("css-checkbox med")
//                                 .after("<label class='css-label med elegant'></label>");

	$("ul.clickMenu").each(function(index, node) {
		$(node).sugarActionMenu();
	});
	
	$( "#subModuleList" ).slideUp( "slow" );
	var tabsUp = true;

	$("#moduleList ul li a").click(function(){//mouseover
		if(tabsUp){
			$( "#subModuleList" ).slideDown( "slow" );
			tabsUp=false;
		}
		else{
			$( "#subModuleList" ).slideUp( "slow" );
			tabsUp=true;
		}
	});

	    /* $("#header").mouseleave(function(){
	        $( "#subModuleList" ).slideUp( );
	    }); */
        $("#moduleList ul li").mouseenter(function(){
                $("#moduleList ul li[class!=noBorderOffset]").attr("class", "");
	        $(this).attr( "class", "currentTab");
        });
});



YAHOO.util.Event.onAvailable('sitemapLinkSpan', function() {

	document.getElementById('sitemapLinkSpan').onclick = function() {
		ajaxStatus.showStatus(SUGAR.language.get('app_strings', 'LBL_LOADING_PAGE'));
		var smMarkup = '';
		var callback = {
			success: function(r) {
				ajaxStatus.hideStatus();
				document.getElementById('sm_holder').innerHTML = r.responseText;
				with(document.getElementById('sitemap').style) {
					display = "block";
					position = "absolute";
					right = 0;
					top = 80;
				}
				document.getElementById('sitemapClose').onclick = function() {
					document.getElementById('sitemap').style.display = "none";
				}
			}
		}
		postData = 'module=Home&action=sitemap&GetSiteMap=now&sugar_body_only=true';
		YAHOO.util.Connect.asyncRequest('POST', 'index.php', callback, postData);
	}
});

function IKEADEBUG() {
	var moduleLinks = document.getElementById('moduleList').getElementsByTagName("a");
	moduleLinkMouseOver = function() {
		var matches = /grouptab_([0-9]+)/i.exec(this.id);
		var tabNum = matches[1];
		var moduleGroups = document.getElementById('subModuleList').getElementsByTagName("span");
		for (var i = 0; i < moduleGroups.length; i++) {
			if (i == tabNum) {
				moduleGroups[i].className = 'selected';
			} else {
				moduleGroups[i].className = '';
			}
		}
		var groupList = document.getElementById('moduleList').getElementsByTagName("li");
		var currentGroupItem = tabNum;
		for (var i = 0; i < groupList.length; i++) {
			var aElem = groupList[i].getElementsByTagName("a")[0];
			if (aElem == null) {
				continue;
			}
			var classStarter = 'notC';
			if (aElem.id == "grouptab_" + tabNum) {
				classStarter = 'c';
				currentGroupItem = i;
			}
			var spanTags = groupList[i].getElementsByTagName("span");
			for (var ii = 0; ii < spanTags.length; ii++) {
				if (spanTags[ii].className == null) {
					continue;
				}
				var oldClass = spanTags[ii].className.match(/urrentTab.*/);
				spanTags[ii].className = classStarter + oldClass;
			}
		}
		var menuHandle = moduleGroups[tabNum];
		var parentMenu = groupList[currentGroupItem];
		if (menuHandle && parentMenu) {
			updateSubmenuPosition(menuHandle, parentMenu);
		}
	};
	for (var i = 0; i < moduleLinks.length; i++) {
		moduleLinks[i].onmouseover = moduleLinkMouseOver;
	}
};

function updateSubmenuPosition(menuHandle, parentMenu) {
	var left = '';
	if (left == "") {
		p = parentMenu;
		var left = 0;
		while (p && p.tagName.toUpperCase() != 'BODY') {
			left += p.offsetLeft;
			p = p.offsetParent;
		}
	}
	var bw = checkBrowserWidth();
	if (!parentMenu) {
		return;
	}
	var groupTabLeft = left + (parentMenu.offsetWidth / 2);
	var subTabHalfLength = 0;
	var children = menuHandle.getElementsByTagName('li');
	for (var i = 0; i < children.length; i++) {
		if (children[i].className == 'subTabMore' || children[i].parentNode.className == 'cssmenu') {
			continue;
		}
		subTabHalfLength += parseInt(children[i].offsetWidth);
	}
	if (subTabHalfLength != 0) {
		subTabHalfLength = subTabHalfLength / 2;
	}
	var totalLengthInTheory = subTabHalfLength + groupTabLeft;
	if (subTabHalfLength > 0 && groupTabLeft > 0) {
		if (subTabHalfLength >= groupTabLeft) {
			left = 1;
		} else {
			left = groupTabLeft - subTabHalfLength;
		}
	}
	if (totalLengthInTheory > bw) {
		var differ = totalLengthInTheory - bw;
		left = groupTabLeft - subTabHalfLength - differ - 2;
	}
	if (left >= 0) {
		menuHandle.style.marginLeft = left + 'px';
	}
}
YAHOO.util.Event.onDOMReady(function() {
	if (document.getElementById('subModuleList')) {
		var parentMenu = false;
		var moduleListDom = document.getElementById('moduleList');
		if (moduleListDom != null) {
			var parentTabLis = moduleListDom.getElementsByTagName("li");
			var tabNum = 0;
			for (var ii = 0; ii < parentTabLis.length; ii++) {
				var spans = parentTabLis[ii].getElementsByTagName("span");
				for (var jj = 0; jj < spans.length; jj++) {
					if (spans[jj].className.match(/currentTab.*/)) {
						tabNum = ii;
					}
				}
			}
			var parentMenu = parentTabLis[tabNum];
		}
		var moduleGroups = document.getElementById('subModuleList').getElementsByTagName("span");
		for (var i = 0; i < moduleGroups.length; i++) {
			if (moduleGroups[i].className.match(/selected/)) {
				tabNum = i;
			}
		}
		var menuHandle = moduleGroups[tabNum];
		if (menuHandle && parentMenu) {
			updateSubmenuPosition(menuHandle, parentMenu);
		}
	}
});
SUGAR.themes = SUGAR.namespace("themes");
SUGAR.append(SUGAR.themes, {
	allMenuBars: {},
	setModuleTabs: function(html) {
		var el = document.getElementById('ajaxHeader');
		if (el) {
			try {
				YAHOO.util.Event.purgeElement(el, true);
				for (var i in this.allMenuBars) {
					if (this.allMenuBars[i].destroy)
						this.allMenuBars[i].destroy();
				}
			} catch (e) {
				window.location.reload();
			}
			if (el.hasChildNodes()) {
				while (el.childNodes.length >= 1) {
					el.removeChild(el.firstChild);
				}
			}
			el.innerHTML += html;
			this.loadModuleList();
		}
	},
	actionMenu: function() {
		$("ul.clickMenu").each(function(index, node) {
			$(node).sugarActionMenu();
		});
	},
	loadModuleList: function() {
		var nodes = YAHOO.util.Selector.query('#moduleList>div'),
			currMenuBar;
		this.allMenuBars = {};
		for (var i = 0; i < nodes.length; i++) {
			currMenuBar = SUGAR.themes.currMenuBar = new YAHOO.widget.MenuBar(nodes[i].id, {
				autosubmenudisplay: true,
				visible: false,
				hidedelay: 750,
				lazyload: true
			});
			currMenuBar.render();
			this.allMenuBars[nodes[i].id.substr(nodes[i].id.indexOf('_') + 1)] = currMenuBar;
			if (typeof YAHOO.util.Dom.getChildren(nodes[i]) == 'object' && YAHOO.util.Dom.getChildren(nodes[i]).shift().style.display != 'none') {
				oMenuBar = currMenuBar;
			}
		}
		YAHOO.util.Event.onAvailable('subModuleList', IKEADEBUG);
	},
	setCurrentTab: function() {}
});
YAHOO.util.Event.onDOMReady(SUGAR.themes.loadModuleList, SUGAR.themes, true);




!function ($) {

  "use strict"; // jshint ;_;


 /* DROPDOWN CLASS DEFINITION
  * ========================= */

  var toggle = '[data-toggle=dropdown]'
    , Dropdown = function (element) {
        var $el = $(element).on('click.dropdown.data-api', this.toggle)
        $('html').on('click.dropdown.data-api', function () {
          $el.parent().removeClass('open')
        })
      }

  Dropdown.prototype = {

    constructor: Dropdown

  , toggle: function (e) {
      var $this = $(this)
        , $parent
        , isActive

      if ($this.is('.disabled, :disabled')) return

      $parent = getParent($this)

      isActive = $parent.hasClass('open')

      clearMenus()

      if (!isActive) {
        if ('ontouchstart' in document.documentElement) {
          // if mobile we we use a backdrop because click events don't delegate
          $('<div class="dropdown-backdrop"/>').insertBefore($(this)).on('click', clearMenus)
        }
        $parent.toggleClass('open')
      }

      $this.focus()

      return false
    }

  , keydown: function (e) {
      var $this
        , $items
        , $active
        , $parent
        , isActive
        , index

      if (!/(38|40|27)/.test(e.keyCode)) return

      $this = $(this)

      e.preventDefault()
      e.stopPropagation()

      if ($this.is('.disabled, :disabled')) return

      $parent = getParent($this)

      isActive = $parent.hasClass('open')

      if (!isActive || (isActive && e.keyCode == 27)) {
        if (e.which == 27) $parent.find(toggle).focus()
        return $this.click()
      }

      $items = $('[role=menu] li:not(.divider):visible a', $parent)

      if (!$items.length) return

      index = $items.index($items.filter(':focus'))

      if (e.keyCode == 38 && index > 0) index--                                        // up
      if (e.keyCode == 40 && index < $items.length - 1) index++                        // down
      if (!~index) index = 0

      $items
        .eq(index)
        .focus()
    }

  }

  function clearMenus() {
    $('.dropdown-backdrop').remove()
    $(toggle).each(function () {
      getParent($(this)).removeClass('open')
    })
  }

  function getParent($this) {
    var selector = $this.attr('data-target')
      , $parent

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && /#/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '') //strip for ie7
    }

    $parent = selector && $(selector)

    if (!$parent || !$parent.length) $parent = $this.parent()

    return $parent
  }


  /* DROPDOWN PLUGIN DEFINITION
   * ========================== */

  var old = $.fn.dropdown

  $.fn.dropdown = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('dropdown')
      if (!data) $this.data('dropdown', (data = new Dropdown(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  $.fn.dropdown.Constructor = Dropdown


 /* DROPDOWN NO CONFLICT
  * ==================== */

  $.fn.dropdown.noConflict = function () {
    $.fn.dropdown = old
    return this
  }


  /* APPLY TO STANDARD DROPDOWN ELEMENTS
   * =================================== */

  $(document)
    .on('click.dropdown.data-api', clearMenus)
    .on('click.dropdown.data-api', '.dropdown form', function (e) { e.stopPropagation() })
    .on('click.dropdown.data-api'  , toggle, Dropdown.prototype.toggle)
    .on('keydown.dropdown.data-api', toggle + ', [role=menu]' , Dropdown.prototype.keydown)

}(window.jQuery);